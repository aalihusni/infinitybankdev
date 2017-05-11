<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Auth;
use Response;
use App\User;
use Input;
use Config;
use Validator;
use DB;
use Carbon\Carbon;
use App\Model\LeadershipRequests;
use App\Model\Videos;
use Image;
class ManageRequestsController extends Controller {
	
	
	
	public function getLeadersRequest()
	{
		$lists = LeadershipRequests::orderBy('id','desc')->paginate(30);
		$data = array();
		foreach ($lists as $list)
		{
			$social_account = explode(',', $list->social_account);
			
			$data[] = (object)['id'=>$list->id, 'name'=>$list->name,'email'=>$list->email,'phone'=>$list->phone,'fb_name'=>$list->fb_name,'fb_url'=>$list->fb_url,
					'wechat_name'=>$list->wechat_name,
					'wechat_url'=>$list->wechat_url,'social_account'=>$social_account,'description'=>$list->description,'image'=>$list->image,
					'document'=>$list->document,'convince_detail'=>$list->convince_detail,'is_member'=>$list->is_member,'member_alias'=>$list->member_alias,
					'ip_address'=>$list->ip_address,'created_at'=>$list->created_at
						
			];
		}
		return view('admin.manage.leader-request')
				->with('lists',$data)
				->with('renderList',$lists);
	}
	
	public function updateLeadership()
	{
		
		$row = LeadershipRequests::find(Input::get('req_id'));
		$row->status = 1;
		$row->save();
		return Response::json(array('response' => 1, 'message' => "Updated Successfully."));
		
	}

	public function listVideos(Videos $Video)
	{
		$lists = Videos::orderBy('ordering','asc')->get();
		return view('admin.system.media.videos')
		->with('lists',$lists);
	}
	
	public function getVideoDetail($id)
	{
		$Detail = Videos::find($id);
		return view('admin.system.media.edit')
		->with('Detail',$Detail);
	}
	
	public function postVideo(Request $request,Videos $Video)
	{
		
		$rules = array(
				'title_1' => 'required|min:5|max:50',
				'v_url' => 'required|URL',
				'video_type' => 'required',
				//'cover_image' => 'required|mimes:jpeg,bmp,png',
		);
		
			 
			$validator = Validator::make(Input::all(), $rules);
			$errors = array();
			if ($validator->fails()) {
				$errors = $validator->getMessageBag ()->toArray ();
			}
			 
			if($errors)
				return Response::json ( array (
						'response' => 0,
						'errors' => $errors
				) );
				$imageDir='';
				$docDir = '';
		if($request->video_id)
			$Video = Videos::find($request->video_id);
		
		if($request->hasFile('cover_image')) {
					$image = Input::file('cover_image');
					$filename  = time() . '.' . $image->getClientOriginalExtension();
					$path = public_path('web_content/img/projects/' . $filename);
					Image::make($image->getRealPath())->resize(400, 400)->save($path);
					$Video->cover_image = $filename;
		}
		$Video->v_type = $request->video_type;
		$Video->title_1 = $request->title_1;
		$Video->title_2 = $request->title_2;
		$Video->v_url = $request->v_url;
		$Video->status = $request->status;
		$Video->ordering = $request->ordering;
		$Video->save();
		return Response::json(array('response' => 1, 'message' => "Video record updated successfully."));
		//dd($request);
	}
	
	public function postUpdateVideo(Request $request)
	{
		$Video = Videos::find($request->id);
		Videos::whereId($request->id)->update([''.$request->column.'' => $request->editval]);
		return Response::json(array('response' => 1, 'message' => "Video record updated successfully."));
		//$Video->$request->column = $request->editval;
		//$Video->save();
		
	}
	
}	
