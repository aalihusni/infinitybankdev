<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;
use Auth;
use Input;
use File;
use Image;
use Storage;
use App\Classes\TrailLogClass;

class VerificationController extends Controller
{

    public function upload_veriid_type()
    {
        if($_POST['id_no']=='')
        {
            return Redirect::back()
                ->withErrors('You need to put your ID Number');
        }
        else
        {
            $user = Auth::user();

            $logtitle = "ID Verify Type Updated";
            $logfrom = "";
            $logto = "Type:".$_POST['id_type']." No:".$_POST['id_no'];
            TrailLogClass::addTrailLog($user->id, $logtitle, $logto, $logfrom);

            $user->id_verify_type = $_POST['id_type'];
            $user->id_verify_no = $_POST['id_no'];
            $user->save();

            return Redirect::back()->with('success', 'Your document type has been updated. You may now upload your document image.');
        }
    }

    public function upload_veriid()
    {
        //Validate Start
        $rules = array(
            'image'             => 'image|required',
        );

        $validator = Validator::make(Input::all(), $rules);
        //Validation End

        $image = Input::file('image');

        if ($validator->fails()) {

            return Redirect::to('members/verification')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        }
        elseif(Auth::user()->id_verify_type < 1 || empty(Auth::user()->id_verify_no)){
            return Redirect::back()
                ->withErrors('Please update your ID type first before uploading document.');
        } else {

            if (File::exists("private/id_verify/" . Auth::user()->id_verify_file)) {
                File::delete("private/id_verify/" . Auth::user()->id_verify_file);
            }

            if (Storage::exists("private/id_verify/" . Auth::user()->id_verify_file)) {
                Storage::delete("private/id_verify/" . Auth::user()->id_verify_file);
            }

            $filename = time() . Auth::user()->id . '.' . $image->getClientOriginalExtension();

            $path = 'private/id_verify/' . $filename;
            $full_path = public_path($path);


            //Image::make($image->getRealPath())->save($full_path);
            Storage::put($path, file_get_contents($image));

            $user = Auth::user();

            $logtitle = "ID Verify Uploaded";
            $logfrom = "";
            $logto = $filename;
            TrailLogClass::addTrailLog($user->id, $logtitle, $logto, $logfrom);

            $user->id_verify_file = $filename;
            $user->id_verify_status = 1;
            $user->save();

            return Redirect::back()->with('success', 'You document will be process shortly...');

        }
    }

    public function upload_veriselfie()
    {
        //Validate Start
        $rules = array(
            'image'             => 'image|required',
        );

        $validator = Validator::make(Input::all(), $rules);
        //Validation End

        $image = Input::file('image');

        if ($validator->fails()) {

            return Redirect::to('members/verification')
                ->withErrors($validator)
                ->withInput(Input::except('password'));

        } else {

            if (File::exists("private/photo_verify/" . Auth::user()->selfie_verify_file)) {
                File::delete("private/photo_verify/" . Auth::user()->selfie_verify_file);
            }

            if (Storage::exists("private/photo_verify/" . Auth::user()->selfie_verify_file)) {
                Storage::delete("private/photo_verify/" . Auth::user()->selfie_verify_file);
            }

            $filename = time() . Auth::user()->id . '.' . $image->getClientOriginalExtension();

            $path = 'private/photo_verify/' . $filename;
            $full_path = public_path($path);


            //Image::make($image->getRealPath())->save($full_path);
            Storage::put($path, file_get_contents($image));

            $user = Auth::user();

            $logtitle = "Photo Verify Uploaded";
            $logfrom = "";
            $logto = $filename;
            TrailLogClass::addTrailLog($user->id, $logtitle, $logto, $logfrom);

            $user->selfie_verify_file = $filename;
            $user->selfie_verify_status = 1;
            $user->save();

            return Redirect::back()->with('success', 'You document will be process shortly...');

        }
    }

}
