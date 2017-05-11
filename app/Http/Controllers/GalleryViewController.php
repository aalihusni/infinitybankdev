<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\GalleryAlbum;
use App\GalleryImage;

class GalleryViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('member');
    }

    public function image_gallery()
    {
        $albums = GalleryAlbum::orderBy('created_at','DESC')->get();
        return view('admin.gallery_album')->with('albums',$albums);
    }

    public function edit_album()
    {
        $id = $_GET['id'];
        $album = GalleryAlbum::find($id);
        $images = GalleryImage::where('album_id','=',$id)->get();
        return view('admin.edit_album')->with('album',$album)->with('images',$images);
    }

    public function index()
    {
        $albums = GalleryAlbum::orderBy('created_at','DESC')->get();
        $objectData = array();
        foreach($albums as $album)
        {
            $images = GalleryImage::where('album_id','=',$album->id)->count();

            $objectData[] = (object)array(
                'id'=>$album->id,
                'title'=>$album->title,
                'description'=>$album->description,
                'country'=>$album->country,
                'images'=>$album->images,
                'count'=>$images
            );
        }

        return view('member.gallery')->with('objectData',$objectData);
    }

    public function view()
    {
        $id = $_GET['id'];
        $album = GalleryAlbum::find($id);
        $images = GalleryImage::where('album_id','=',$id)->get();
        return view('member.gallery_view')->with('album',$album)->with('images',$images);
    }
}
