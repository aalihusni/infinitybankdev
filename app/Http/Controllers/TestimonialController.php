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
use App\Testimonials;
use App\Classes\PassportClass;
use App\GalleryImage;
use DB;

class TestimonialController extends Controller
{
    public function __construct()
    {
        $this->middleware('member');
    }

    public function submit()
    {
        $user_id = Auth::user()->id;
        $website = $_POST['website'];
        $url = $_POST['url'];

        $testimonial = new Testimonials();
        $testimonial->user_id = $user_id;
        $testimonial->website = $website;
        $testimonial->url = $url;
        $testimonial->status = '1';
        $testimonial->save();

        return Redirect::back()->with('success','Testimonial successfully submitted.');
    }

    public function approve()
    {
        $id = $_POST['id'];
        $testi = Testimonials::find($id);

        PassportClass::setPassportBalance($testi->user_id, '2', "Testimonial Submission (From Admin)");

        $user = User::find($testi->user_id);
        $email = $user->email;
        $data = array(
            'username'=>$user->alias
        );
        $subject = "Your testimonial has been Approved. You received 2 passport.";
        $template = 'emails.testimonial_approved';
        EmailClass::send_email($template, $email, $subject, $data, '0');

        $testi->status = '2';
        $testi->save();

        echo "1";
    }

    public function reject()
    {
        $id = $_POST['id'];
        $reason = $_POST['reason'];
        $testi = Testimonials::find($id);

        $user = User::find($testi->user_id);
        $email = $user->email;
        $data = array(
            'username'=>$user->alias,
            'reason'=>$reason
        );
        $subject = "Your testimonial has been Rejected.";
        $template = 'emails.testimonial_rejected';
        EmailClass::send_email($template, $email, $subject, $data, '0');

        $testi->delete();

        echo '1';
    }

}