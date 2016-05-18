<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Photo;

class PhotosController extends Controller
{
 	public function delete(Photo $photo){
 	   	$photo->delete();
        return response()->json(['status' => 'success']);
 	}   
}
