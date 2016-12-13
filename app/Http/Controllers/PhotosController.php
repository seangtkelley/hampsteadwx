<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Events\Alert;
use Carbon\Carbon;

class PhotosController extends Controller{
    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the display of the welcome page
    |
    */

    /**
     * Show the welcome view and set the locale
     *
     * @param string $locale
     * @return mixed
     */
    public function showPhotosHome(){
        $photos = \App\Photos::all();

        return view('photos.home', [ 'photos' => $photos]);
    }

    /**
     * Show the welcome view and set the locale
     *
     * @param string $locale
     * @return mixed
     */
    public function showPhotosSubmit(){
        return view('photos.submit');
    }

    /**
     * Show the welcome view and set the locale
     *
     * @param string $locale
     * @return mixed
     */
    public function submitPhoto(){
      if(\Input::get('password') == env('SITE_PASS')){

        // getting all of the post data
        $file = array('image' => \Input::file('image'));
        //return $file;
        // setting up rules
        $rules = array(
          'uploadedimage' => 'image|max:5000',
          'uploaded' => 'mimes:jpeg,bmp,png'
        );
        // doing the validation, passing post data, rules and the messages
        $validator = \Validator::make($file, $rules);
        if ($validator->fails()) {
         // send back to the page with the input data and errors
         event(new Alert('create', array('type' => 'danger', 'body' => 'Error uploading photo.')));
         return redirect()->route('photos.submit');
        } else {
         // checking file is valid.
         if (\Input::file('image')->isValid()) {
           $destinationPath = "./img";
           $fileName = \Input::file('image')->getClientOriginalName();
           $extension = \Input::file('image')->getClientOriginalExtension(); // getting image extension
           $fullpath = $destinationPath . "/" . $fileName;

           if(\Input::file('image')->move($destinationPath, $fileName)){
             $photoObject = new \App\Photos;
             $photoObject->url = str_replace("./", "", $fullpath);
             $photoObject->caption = \Input::get('caption');

             if($photoObject->save()){
               event(new Alert('create', array('type' => 'success', 'body' => 'Photo uploaded successfully.')));
               return redirect()->route('photos.submit');
             } else {
               event(new Alert('create', array('type' => 'danger', 'body' => 'Photo not uploaded successfully.')));
               return redirect()->route('photos.submit');
             }

           } else {
             event(new Alert('create', array('type' => 'danger', 'body' => 'Photo not uploaded successfully.')));
             return redirect()->route('photos.submit');
           }
         } else {
           // sending back with error message.
           event(new Alert('create', array('type' => 'success', 'body' => 'Photo not valid.')));
           return redirect()->route('photos.submit');
         }
        }
      } else {
        event(new Alert('create', array('type' => 'danger', 'body' => 'Incorrect password.')));
        return redirect()->route('photos.submit');
      }
    }
}
