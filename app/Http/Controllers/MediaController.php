<?php

namespace App\Http\Controllers;

use App\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth, Image;

class MediaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        // print_r($request->all());

        if($request->hasFile('photo')){
            try {
                $photo = $request->photo;
                $extension = $photo->getClientOriginalExtension();
                $path = public_path().DIRECTORY_SEPARATOR.'photos'.DIRECTORY_SEPARATOR.Auth::user()->id;
                $path_thumbnail = public_path().DIRECTORY_SEPARATOR.'photos'.DIRECTORY_SEPARATOR.Auth::user()->id.DIRECTORY_SEPARATOR.'thumbnail';
                if (!file_exists($path_thumbnail)) {
                    mkdir($path_thumbnail, 0777, true);
                }            
                Storage::makeDirectory($path_thumbnail);
                do {

                    $nom = str_random(10) . '.' . $extension;

                } while(file_exists($path . '/' . $nom));

                $photo->move($path, $nom);
                Image::make($path . '/' . $nom)->widen(200)->save($path_thumbnail.'/'.$nom);
                $relative_path = 'photos'.DIRECTORY_SEPARATOR.Auth::user()->id.DIRECTORY_SEPARATOR.'thumbnail'.DIRECTORY_SEPARATOR.$nom;
                return response()->json(['url'=>$relative_path]);
            } catch(\Exception $ex){
                
            }
        } else {
            echo 'no-photo';
        }
    }
}
