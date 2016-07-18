<?php

namespace App\Http\Controllers;

use App\Page;
use App\Photo;
use App\Update;
use App\User;
use Image;

class PagesController extends Controller
{

    public function index()
    {
        $pages = Page::with('photos')->get();
        foreach ($pages as $index => $page) {
            $pages[$index]->num_reviews = $page->reviews()->count();
        }
        return $pages;
    }

    public function pageFeed(Page $page)
    {
        // gets the ids of the pages followed by a user to an array
        // $pages_followed = $user->following()->pluck('pages.id')->toArray();
        // get lateast 10 updates for those pages
        $updates = $page->updates()->orderBy('updated_at', 'desc')->take(10)->get();

        foreach ($updates as $update) {
            if ($update->with_image == '1') {
                $update->image = $update->getImage();
            }
            $update->formatted_date = $update->updated_at->diffForHumans();
        }
        return $updates;
    }

    // it gets all places nearby and marks the ones with pages created
    public function getPagesAndPlacesNearby($position)
    {

        $places_nearby = \GPHelper::googleSearch($position);

        return $this->placesWithPages($places_nearby);

    }

    // gets all the pages around the user
    public function getPagesNearBy($position)
    {

        $places_nearby = \GPHelper::googleSearch($position);

        $nearby_ids = [];
        foreach ($places_nearby->results as $place) {
            $nearby_ids[] = "'" . $place->place_id . "'";
        }
        if (count($nearby_ids) <= 0) {
            return [];
        }

        $pages = Page::whereRaw('google_place_id IN (' . implode(',', $nearby_ids) . ')')->get();
        foreach ($pages as $index => $page) {
            $pages[$index]->thumb = $page->getThumb();
            $pages[$index]->num_reviews = $page->reviews()->count();
        }

        return $pages;
    }

    public function search($query, $position)
    {

        if (\GPHelper::isCategory($query)) {
            // the query is a category, search for nearby places on that category
            $google_places = \GPHelper::googleSearch($position, '', $query);
        } else {
            // get places by text-search (any category)
            $google_places = \GPHelper::googleSearch($position, $query);
        }

        return $this->placesWithPages($google_places);

    }

    public function placesWithPages($google_places)
    {
        $nearby_places = [];
        $nearby_ids = [];
        foreach ($google_places->results as $place) {
            $nearby_ids[] = "'" . $place->place_id . "'";
            if (!empty($place->vicinity)) {
                $address = $place->vicinity;
            } else {
                $address = $place->formatted_address;
            }

            $nearby_places[$place->place_id] = [
                'title' => $place->name,
                'address' => $address,
                'place_id' => $place->place_id,
                'about' => '',
                'rating' => '0',
                'lat' => $place->geometry->location->lat,
                'lng' => $place->geometry->location->lng,
                'withpage' => 'no',
            ];
        }

        if (count($nearby_ids) <= 0) {
            return [];
        }

        $pages_and_places = [];
        $places_ids_with_pages = [];
        $pages = Page::whereRaw('google_place_id IN (' . implode(',', $nearby_ids) . ')')->get();
        foreach ($pages as $index => $page) {
            $pages[$index]->thumb = $page->getThumb();
            $pages[$index]->num_reviews = $page->reviews()->count();
            $pages[$index]->withpage = 'yes';
            $places_ids_with_pages[] = $page->google_place_id;
            $pages_and_places[] = $pages[$index];
        }

        // if this place is not already as a page, lets add it
        foreach ($nearby_places as $place_id => $place) {
            if (!in_array($place_id, $places_ids_with_pages)) {
                $pages_and_places[] = $nearby_places[$place_id];
            }
        }

        return $pages_and_places;
    }

    // gets all places without pages around the user
    public function getPlacesNearBy($coordinates)
    {

        $api_key = env('GOOGLE_API');
        $type = 'restaurant';
        $radius = '200'; //metres
        $rankby = '';

        // get places nearby from google
        $google_places_url = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=' . $api_key . '&location=' . $coordinates . '&radius=' . $radius . '&type=' . $type . '&rankby=' . $rankby;

        $places_nearby = json_decode(file_get_contents($google_places_url));

        // build query using these ids
        $nearby_ids = [];
        foreach ($places_nearby->results as $place) {
            $nearby_ids[] = "'" . $place->place_id . "'";
        }

        if (count($nearby_ids) <= 0) {
            return [];
        }

        $nearby_pages = [];

        // get nearby pages
        $pages = Page::whereRaw('google_place_id IN (' . implode(',', $nearby_ids) . ')')->get();
        foreach ($pages as $index => $page) {
            $nearby_pages[] = $page->google_place_id;
        }

        // exclude those pages from places
        $places_nearby_without_pages = [];
        foreach ($places_nearby->results as $place) {
            if (!in_array($place->place_id, $nearby_pages)) {
                $places_nearby_without_pages[] = $place;
            }
        }

        return $places_nearby_without_pages;
    }

    public function show(Page $page)
    {
        $page->photos = $page->photos()->get();
        $page->followed = $page->followed()->get();
        $page->pictures = $page->getImages();
        $page->thumb = $page->getThumb();
        $page->user = $page->user()->get();
        $page->num_reviews = $page->reviews()->count();

        $updates = $page->updates()->orderBy('updated_at', 'desc')->take(10)->get();
        foreach ($page->$updates as $update) {
            if ($update->with_image == '1') {
                $update->image = $update->getImage();
            }
            $update->formatted_date = $update->updated_at->diffForHumans();
        }
        $page->updates = $updates;
        return $page;
    }

    public function update(Page $page)
    {
        $request = request()->all();
        $page->about = $request['about'];
        $page->save();
        return response()->json(['status' => 'success']);
    }

    public function delete(Page $page)
    {
        $page->delete();
        return response()->json(['status' => 'success']);
    }

    public function userPages(User $user)
    {
        $pages = $user->pages()->with('photos')->get();
        foreach ($pages as $index => $page) {
            $pages[$index]->thumb = $page->getThumb();
            $pages[$index]->num_reviews = $page->reviews()->count();
        }
        return $pages;
    }

    public function getById()
    {
        $request = request()->all();
        //error_log(print_r($request,1));
        $requested_ids = [];
        foreach ($request as $request) {
            $requested_ids[] = "'" . $request['id'] . "'";
        }
        $pages = Page::whereRaw('google_place_id IN (' . implode(',', $requested_ids) . ')')->get();
        foreach ($pages as $index => $page) {
            $pages[$index]->num_reviews = $page->reviews()->count();
        }
        return $pages;
    }

    public function store(User $user)
    {

        $request = request()->all();

        error_log('store page');
        error_log(print_r($request, true));

        // get info for the place
        $place = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/place/details/json?placeid=' . $request['google_place_id'] . '&key=' . env('GOOGLE_API')));

        $page = Page::firstOrNew(['google_place_id' => $place->result->place_id]);

        $page->title = $place->result->name;
        $page->address = $place->result->formatted_address;
        $page->categories = implode(',', $place->result->types);
        $page->rating = $request['rating'];
        $page->about = $request['about'];
        $page->lat = $place->result->geometry->location->lat;
        $page->lng = $place->result->geometry->location->lng;
        $page->google_place_id = $place->result->place_id;
        $user->pages()->save($page);

        return response()->json(['status' => 'success', 'page_id' => $page->id]);

    }

    public function addImage(Page $page)
    {

        $request = request()->all();

        // create the photo record
        $photo = new Photo;
        $photo->page_id = $page->id;
        $photo->save();

        // upload photo and generate thumbs
        if (isset($request['file'])) {
            $request['file']->move('photos', $photo->id . '.jpg');
            // generate thumbs
            Image::make('photos/' . $photo->id . '.jpg')->fit(1000, 1000)->save('photos/' . $photo->id . '.jpg')->fit(160, 160)->save('photos/' . $photo->id . '_thumb.jpg');
        }

        return response()->json(['status' => 'success']);

    }

}
