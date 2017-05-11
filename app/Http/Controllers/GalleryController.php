<?php

namespace App\Http\Controllers;

use Auth;
use Redirect;
use Crypt;
use File;
use Input;
use Session;
use Validator;
use App\User;
use App\GalleryAlbum;
use App\GalleryImage;
use DB;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin', ['except' => 'quick_login']);
    }

    public function image_create_album()
    {
        $title = $_POST['title'];
        $country = $_POST['country'];
        $description = $_POST['description'];

        $newalbum = new GalleryAlbum();
        $newalbum->title = $title;
        $newalbum->country = $country;
        $newalbum->description = $description;
        $newalbum->images = 'empty.png';
        $newalbum->save();

        return Redirect::back()->with('success','New album created.');
    }

    public function image_save_album()
    {
        $album_id = $_POST['album_id'];
        $title = $_POST['title'];
        $country = $_POST['country'];
        $description = $_POST['description'];

        $newalbum = GalleryAlbum::find($album_id);
        $newalbum->title = $title;
        $newalbum->country = $country;
        $newalbum->description = $description;
        $newalbum->save();

        return Redirect::back()->with('success','Album information updated.');
    }

    public function set_default_image()
    {
        $album_id = $_GET['album_id'];
        $imagename = $_GET['imagename'];

        $newalbum = GalleryAlbum::find($album_id);
        $newalbum->images = $imagename;
        $newalbum->save();

        return Redirect::back()->with('success','Album information updated.');
    }

    public function delete_image()
    {
        $id = $_POST['id'];

        $img = GalleryImage::find($id);
        $filename = "gallery/".$img->image_file;
        File::delete($filename);

        $img->delete();

        return Redirect::back()->with('success','Image Deleted');
    }

    public function delete_album()
    {
        $id = $_POST['id'];

        $pictures = GalleryImage::where('album_id','=',$id)->get();

        foreach($pictures as $picture)
        {
            $filename = "gallery/".$picture->image_file;
            File::delete($filename);
        }

        $img = GalleryImage::where('album_id','=',$id);
        $img->delete();

        $album = GalleryAlbum::find($id);
        $album->delete();

        return Redirect::back()->with('success','Album Deleted');
    }

    public function upload_images()
    {
        $album_id = $_POST['album_id'];
        // getting all of the post data
        $files = Input::file('images');
        // Making counting of uploaded images
        $file_count = count($files);
        // start count how many uploaded
        $uploadcount = 0;
        foreach($files as $file) {
            $rules = array('file' => 'required|mimes:png,gif,jpeg,jpg');
            $validator = Validator::make(array('file'=> $file), $rules);
            if($validator->passes()){
                $destinationPath = 'gallery';
                $filename = $album_id.'_'.$file->getClientOriginalName();
                $upload_success = $file->move($destinationPath, $filename);
                $newimage = new GalleryImage();
                $newimage->album_id = $album_id;
                $newimage->image_file = $filename;
                $newimage->save();
                $uploadcount ++;
            }
        }
        if($uploadcount == $file_count){

            //Set Gallery Image
            $random_img = GalleryImage::where('album_id','=',$album_id)->orderBy(DB::raw('RAND()'))->first();
            $album = GalleryAlbum::find($album_id);
            $album->images = $random_img->image_file;
            $album->save();

            Session::flash('success', 'Upload successfully');
            return Redirect::back()->with('success','New album created.');
        }
        else {
            return Redirect::back()->withErrors($validator);
        }
    }
}