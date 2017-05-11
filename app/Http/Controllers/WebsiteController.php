<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Classes\EmailClass;
use DB;
use Validator;
use Response;
use Input;
use Carbon\Carbon;
use App\Model\LeadershipRequests;

class WebsiteController extends Controller
{
    public function submit_message()
    {
        $name = $_POST['c_name'];
        $email = $_POST['c_email'];
        $phone = $_POST['c_phone'];
        $message = $_POST['c_message'];
        $ref = $_POST['c_ref'];

        $referral_id = User::where('alias','=',$ref)->first()->id;
        if ($referral_id <= 3281)
        {
            $referral_id = 1;
        }

        $template = 'emails.website_contact';
        $subject = "You have receive a message from $name.";
        $data = array('username'=>$ref, 'name'=>$name,'email'=>$email, 'phone'=>$phone, 'message'=>$message);
        EmailClass::send_email($template, $email, $subject, $data, '0', $referral_id, '4');
    }
    
    public function postLeadership(Request $request,LeadershipRequests $LRObj)
    {
    	
    	$rules = array(
    			'full_name' => 'required|min:5|max:50',
    			'email' => 'required|email|unique:users',
    			//'wechat_url' => 'required|URL',
    			'phone' => 'required',
    			'photo' => 'mimes:jpeg,bmp,png',
    			'document' =>'mimes:doc,docs,pdf',
    			'description' => 'required|min:30|max:1000',
    			
    	);
    	if($request->is_member)
    		$rules['bitregion_username'] =  'required|exists:users,alias';
    	
    	$validator = Validator::make(Input::all(), $rules);
    	$errors = array();
    	if ($validator->fails()) {
    		$errors = $validator->getMessageBag ()->toArray ();
    	}
    	
    	/*
    	if(!preg_match('/^(http\:\/\/|https\:\/\/)?(?:www\.)?facebook\.com\/(?:(?:\w\.)*#!\/)?(?:pages\/)?(?:[\w\-\.]*\/)*([\w\-\.]*)/', $request->fb_url)){
    		$errors['fb_url'] = "Invalid Facebook URL";
    	}*/
    	
    	if($errors)
    		return Response::json ( array (
    				'response' => 0,
    				'errors' => $errors
    	) );
    	$imageDir='';
    	$docDir = '';
    	if($request->hasFile('photo')) {
    			$file = Input::file('photo');
    			$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
    			$imageTitle = $timestamp. '-' .$file->getClientOriginalName();
    			$imageDir = 'leadership/'.$imageTitle;
    			$file->move(public_path().'/leadership/', $imageTitle);
    	}
    	
    	if($request->hasFile('document')) {
    		$file = Input::file('document');
    		$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
    		$docTitle = 'doc-'.$timestamp. '-' .$file->getClientOriginalName();
    		$docDir = 'leadership/'.$docTitle;
    		$file->move(public_path().'/leadership/', $docTitle);
    	}
    	
    	$social_account = '';
    	foreach($request->social_account as $socialLink)
    	{
    		if (!filter_var($socialLink, FILTER_VALIDATE_URL) === false)
    			$social_account .= $socialLink.',';
    			
    	}
    	
    	$convince = 'In 2 Weeks : '.$request->in_2_weeks.'<br>';
    	$convince .= 'In A Month : '.$request->in_month.'<br>';
    	$convince .= 'In 3 Months : '.$request->in_3_months.'<br>';
    	$convince .= 'In 6 Months : '.$request->in_6_months.'<br>';
    		
    	$LRObj->name = $request->full_name;
    	$LRObj->email = $request->email;
    	$LRObj->phone = $request->phone;
    	$LRObj->fb_name = $request->fb_name;
    	$LRObj->fb_url	= $request->fb_url;
    	$LRObj->wechat_name = $request->wechat_name;
    	$LRObj->wechat_url	= $request->wechat_url;
    	$LRObj->social_account = $social_account;
    	$LRObj->description = $request->description;
    	$LRObj->image = $imageDir;
    	$LRObj->document = $docDir;
    	$LRObj->convince_detail = $convince;
    	$LRObj->is_member = $request->is_member;
    	$LRObj->ip_address = $_SERVER['REMOTE_ADDR'];
    	
    	if($request->is_member)
    		$LRObj->member_alias = $request->bitregion_username;
    	$LRObj->save();
    	return Response::json(array('response' => 1, 'message' => "Thanks.You are very important to us, all information received will always remain confidential. We will contact you as soon as we review your message."));
    		
    	
    }
}
