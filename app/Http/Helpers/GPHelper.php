<?php

class GPHelper
{

    // detects if a string is a category
    public static function isCategory($query)
    {
        return in_array(strtolower($query), self::$categories);
    }

    public static function googleSearch($position, $query = '', $type = 'any')
    {
        $radius = 400; // in metres
        $rankby = '';

        $query = urlencode($query);

        if ($type != 'any') {
            // search by type
            $type = strtolower($query);
            $google_places_url = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=' . env('GOOGLE_API') . '&location=' . $position . '&radius=' . $radius . '&type=' . $type . '&rankby=' . $rankby;
        } else {
            if ($query != '') {
                $google_places_url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?key=' . env('GOOGLE_API') . '&location=' . $position . '&query=' . $query . '&radius=' . $radius;
            } else {
                // get all restaurants nearby
                $type = \GPHelper::$types;
                $google_places_url = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=' . env('GOOGLE_API') . '&location=' . $position . '&radius=' . $radius . '&rankby=' . $rankby;
            }
        }

        $google_places = json_decode(file_get_contents($google_places_url));
        error_log(print_r($google_places, true));
        return $google_places;
    }

    // types for the search of nearby places
    static $types = 'bar|cafe|food|gas_station|grocery_or_supermarket|liquor_store|meal_delivery|meal_takeaway|movie_theater|night_club|restaurant|shopping_mall|store';

    // categories list, from google places: https://developers.google.com/places/supported_types?hl=es#table1
    static $categories = [
        'accounting',
        'airport',
        'amusement_park',
        'aquarium',
        'art_gallery',
        'atm',
        'bakery',
        'bank',
        'bar',
        'beauty_salon',
        'bicycle_store',
        'book_store',
        'bowling_alley',
        'bus_station',
        'cafe',
        'campground',
        'car_dealer',
        'car_rental',
        'car_repair',
        'car_wash',
        'casino',
        'cemetery',
        'church',
        'city_hall',
        'clothing_store',
        'convenience_store',
        'courthouse',
        'dentist',
        'department_store',
        'doctor',
        'electrician',
        'electronics_store',
        'embassy',
        'establishment',
        'finance',
        'fire_station',
        'florist',
        'food',
        'funeral_home',
        'furniture_store',
        'gas_station',
        'general_contractor',
        'grocery_or_supermarket',
        'gym',
        'hair_care',
        'hardware_store',
        'health',
        'hindu_temple',
        'home_goods_store',
        'hospital',
        'insurance_agency',
        'jewelry_store',
        'laundry',
        'lawyer',
        'library',
        'liquor_store',
        'local_government_office',
        'locksmith',
        'lodging',
        'meal_delivery',
        'meal_takeaway',
        'mosque',
        'movie_rental',
        'movie_theater',
        'moving_company',
        'museum',
        'night_club',
        'painter',
        'park',
        'parking',
        'pet_store',
        'pharmacy',
        'physiotherapist',
        'place_of_worship',
        'plumber',
        'police',
        'post_office',
        'real_estate_agency',
        'restaurant',
        'roofing_contractor',
        'rv_park',
        'school',
        'shoe_store',
        'shopping_mall',
        'spa',
        'stadium',
        'storage',
        'store',
        'subway_station',
        'synagogue',
        'taxi_stand',
        'train_station',
        'travel_agency',
        'university',
        'veterinary_care',
        'zoo',
    ];

}
