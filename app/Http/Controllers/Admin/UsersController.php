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
use App\UserClasses;
use App\Classes\EmailClass;
use App\Classes\TrailLogClass;
use Carbon\Carbon;
use App\Model\LanguageTranslation;
use App\Model\UsersDispute;
use App\Model\UsersDisputeLogs;
use App\Classes\SharesClass;
use App\Classes\PHGHClass;
use App\Classes\PassportClass;
use App\Classes\BitcoinWalletClass;

class UsersController extends Controller {
	
	
	public function getKeyUpForLanguage(Request $request) {
		$user_id = $request->filter_id;
		$filter_alias = $request->filter_alias;
		$filter_email = $request->filter_email;
		$htmlData = '';
		if (! $filter_alias && ! $filter_email && ! $user_id)
			return Response::json ( array (
					'content' => '',
					'hasRecord' => 0
			) );
			$sql = User::whereIn ( 'user_type', [2,3]);
			if ($user_id)
				$sql->where ( 'id', $user_id );
				if ($filter_email)
					$sql->where ( 'email', $filter_email );
					if ($filter_alias)
						$sql->where ( 'alias', $filter_alias );
						$result = $sql->first ();
						$files = "";
						$btnStatus = 1;
						if (is_null ( $result )) {
							$htmlData = '<br>No Result';
							$sel_id = 0;
						} else {
							$hasRequests = LanguageTranslation::hasRecords(['user_id'=>$result->id,'status'=>[0,1]]);
							if($hasRequests)
							$files = $hasRequests->files;
							
							$htmlData = '<br><b>User ID</b> : ' . $result->id . ' &nbsp;&nbsp;<b>Name</b> : ' . $result->firstname . ' ' . $result->lastname.' &nbsp;&nbsp;<b>User Class : </b>'. UserClasses::where('class',$result->user_class)->pluck('name') ;
							$htmlData .= '<br> <b>Email</b> : ' . $result->email . '';
							$htmlData .= ' &nbsp;&nbsp;<b>Alias</b> : ' . $result->alias . ' <span class="label label-warning label-round">' . $result->country_code . '</span>';
							$sel_id = $result->id;
							
						}
						return Response::json ( array (
								'content' => $htmlData,
								'hasRecord' => explode(',',$files ),
								'user_id' => $sel_id,'btnStatus'=>$btnStatus
						) );
	}
	
	public function getDisputes(UsersDispute $UserDisputeObj)
	{
		$lists = $UserDisputeObj->getAll();
		return view('admin.system.disputeusers.index')
				->with('lists',$lists);
	}
	public function postDispute(Request $request,UsersDispute $userDisputeObj,UsersDisputeLogs $logObj)
	{
		$complain_by = $request->complain_by;
		$complain_to = 	$request->complain_to;
		$amount = $request->amount;
		$description = $request->description;
		
		$errors = array();
		### VALIDATION ####
		//$checkDuplicate = UsersDispute::where(['complain_by'=>$complain_by,'complain_to'=>$complain_to,'status'=>0])->count();
		
		$checkDuplicate = UsersDispute::where(function($sql)use($complain_by,$complain_to){
						$sql->whereIn('status',[0,1]);
						$sql->where('complain_by',$complain_by);
						$sql->where('complain_to',$complain_to);
		})->count();
		
		
		if($checkDuplicate)
			$errors['custom-err'] = 'Already exists in the users disputes table.';
		$complain_toStatus = User::where(['id'=>$complain_to,'is_dispute'=>1])->count();
		if($complain_toStatus)
			$errors['complain_to'] = "Complain To User's (ID : $complain_to) account already in suspended mode";
		
		
		if(is_null(User::find($complain_by)))
				$errors['complain_by'] = "Invalid ID";
		if(is_null($ComplainToUser = User::find($complain_to)))
				$errors['complain_to'] = "Invalid ID";
		if($complain_by ==  $complain_to)
			$errors['custom-err'] = "User IDs (Complain By & Complain To) could not be same";
		### VALIDATION ####
		if($errors)
			return Response::json ( array (
				'response' => 0,
				'errors' => $errors
		) );
			
			
			$userDisputeObj -> complain_by = $complain_by;
			$userDisputeObj -> complain_to = $complain_to;
			$userDisputeObj -> amount = $amount;
			if(!$description)
				$description = "Amount to return : $amount BTC";
			$userDisputeObj -> description = $description;
			$userDisputeObj -> save();
			if($userDisputeObj->id)
			{
				$ComplainToUser->is_dispute = 1;
				$ComplainToUser->save();
				
				$logObj->users_dispute_id = $userDisputeObj->id;
				$logObj->user_id = Auth::user()->id;
				$logObj->description = $request->description;
				$logObj->save();
				
				
				$user = User::find($complain_to);
				$email = $user->email;
				$template = 'emails.dispute';
				$subject = $user->alias.", Your Bitregion account has been suspended.";
				$data = array(
						'username'=>$user->alias
				);
				EmailClass::send_email($template, $email, $subject, $data, 1);
				
			}
			return Response::json(array('response' => 1, 'message' => "New Dispute record added successfully."));
		
	}
	
	public function getDisputeLogs($dispute_id,UsersDispute $DisputeObj,UsersDisputeLogs $DisputeLogObj)
	{
		$DisputeDetail = $DisputeObj->find($dispute_id);
		$Detail = $DisputeObj->getDetail($dispute_id);
		
		$Logs = $DisputeDetail->getLogs()->get();
		return view('admin.system.disputeusers.logs')->with('logs',$Logs)
		->with('Detail',$Detail);
		
	}
	public function disputeViewAndUpdate($dispute_id,UsersDispute $DisputeObj,UsersDisputeLogs $DisputeLogObj)
	{
		$Detail = $DisputeObj->getDetail($dispute_id);
		return view('admin.system.disputeusers.edit')
		->with('Detail',$Detail);
	}
	public function updateUserStatus(Request $request,UsersDispute $DisputeObj,UsersDisputeLogs $logObj)
	{
		$UpdateFor = $request->UpdateFor;
		$dispute_id = $request->dispute_id;
		$DisputeDetail = $DisputeObj->find($dispute_id);
		
		if($UpdateFor=='ComplainBy')
		{
			$ComplainBy = User::find($DisputeDetail->complain_by);
			$ComplainBy->is_dispute = $request->status_complainby;
			$ComplainBy->save();
			$ids = [$DisputeDetail->complain_by];
			
		}elseif($UpdateFor=='ComplainTo')
		{
			$ComplainTo = User::find($DisputeDetail->complain_to);
			$ComplainTo->is_dispute = $request->status_complainto;
			$ComplainTo->save();
			$ids = [$DisputeDetail->complain_to];
		}else
		{
			
			if(in_array($request->status_both, ['0','1'],true))
				User::whereIn('id',[$DisputeDetail->complain_by,$DisputeDetail->complain_to])->update(['is_dispute' => $request->status_both]);
			$ids = [$DisputeDetail->complain_to,$DisputeDetail->complain_by];
			
		}
		
		$BothStatus = User::whereIn('id',[$DisputeDetail->complain_by,$DisputeDetail->complain_to])
		->where(['is_dispute' => 0])->count();
		if($BothStatus == 2)
		{
			$DisputeDetail->status = 2;
			$DisputeDetail->save();
			$logObj->users_dispute_id = $dispute_id;
			$logObj->user_id = Auth::user()->id;
			$logObj->description = 'Closed By Admin.';
			$logObj->save();
		}
		
		/*
		foreach ($ids as $uid){
			$user = User::find($uid);
			$email = $user->email;
			$template = 'emails.dispute_reactivate';
			$subject = $user->alias.", Your Bitregion account has been reactivated.";
			$data = array(
					'username'=>$user->alias
			);
			EmailClass::send_email($template, $email, $subject, $data, 1);
		}*/
		
		return redirect("admin/system/dispute/users")->with('success','Successfully updated.');
    		
	}

	public function getHelp(){
		
		$user_id = Input::get('ghUserid1');
		$value_in_btc = Input::get('value_in_btc');
		$secret = Input::get('secret');
		SharesClass::setShares($user_id, $secret, "GHB", 0, $user_id, 0, $value_in_btc);
		PassportClass::setPassportBalance($user_id, 1, "GHB");
		$gh_status = PHGHClass::createGH($user_id, $value_in_btc, $secret);
		if (!isset($gh_status['error']))
		{
			SharesClass::setShares($user_id, $secret, "GH", $gh_status, $user_id, 0, -$value_in_btc);
		}
		return redirect("admin/users/member")->with('success','Successfully GHB.');
	}
}	
