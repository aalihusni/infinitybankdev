<?php
namespace App\Http\Controllers\Member;
// controllers
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Response;
use Validator;
use Auth;
use Redirect;
use App\Model\UsersDispute;
use App\Classes\UserClass;
use App\Model\UsersDisputeLogs;
use App\Classes\EmailClass;

class DisputeUserController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
    	
        $user = Auth::user();
        $user_id = $user->id;
        
        if($user->is_dispute <> 1)
        	return redirect('members/home');
        
        $DisputeDetail = UsersDispute::where(function ($sql) use($user_id){
        	//$sql->where('complain_to',$user_id);
        	$sql->whereIn('status',[0,1]);
        	$sql->where(function ($query) {
        		$query->where('complain_to', Auth::user()->id)
        		->orWhere('complain_by',Auth::user()->id);
        	});
        })->first();
        
        $DetailData = array();
        
        
        if(is_null($DisputeDetail))
        	$SuspensionType = 1;
        else{
        	$SuspensionType = 0;
        	if($DisputeDetail->complain_to == $user_id)
        	{
        		$DetailData['ComplainDetailUser'] = User::find($DisputeDetail->complain_by);
        		$DetailData['ComplainTo'] = 'ME';
        	}else{
        		$DetailData['ComplainDetailUser'] = User::find($DisputeDetail->complain_to);
        		$DetailData['ComplainTo'] = 'Other';
        	}
        }
        $DetailData['SuspensionType'] = $SuspensionType;
        
        
       
        $Logs = $DisputeDetail->getTransactionLink;
       
        
        
        $user_details = UserClass::getUserDetails($user_id);
        return view('member.dispute.default')
       
        ->with('user_details', $user_details)
        ->with('SuspensionDetail', $DetailData)
        ->with('DisputeDetail', $DisputeDetail)
        ->with('logs',$Logs);
    }
    
    public function postUpdate(Request $request,UsersDisputeLogs $logObj)
    {
    	$rules = array();
    	$rules['transaction_link'] = 'required|min:15|max:255';
    	$rules['dispute_id'] = 'exists:users_dispute,id,status,0,complain_to,'.Auth::user()->id;
    	
    	$validator = Validator::make($request->all(), $rules);
    	
    	if ($validator->fails()) {
    		return redirect('members/dispute')
    		->withErrors($validator)
    		->withInput();
    	}else{
    		
    		$DisputeDetail = UsersDispute::find($request->dispute_id);
    		
    		$logObj->users_dispute_id = $request->dispute_id;
    		$logObj->user_id = Auth::user()->id;
    		$logObj->transaction_link	= $request->transaction_link;
    		$logObj->description = 'Updated as paid.';
    		$logObj->save();
    		
    		$DisputeDetail->status = 1;
    		$DisputeDetail->save();
    		
    		$ComplainBy = User::find($DisputeDetail->complain_by);
    		$ComplainBy->is_dispute = 1;
    		$ComplainBy->save();
    		
    		return redirect("members/dispute")->with('message','Successfully updated.');
    		
    	}
    	 
    }

    public function postUpdateFromComplainBy(Request $request,UsersDisputeLogs $logObj)
    {
    	$rules = array();
    	$rules['response'] = 'required';
    	$rules['dispute_id'] = 'exists:users_dispute,id,status,1,complain_by,'.Auth::user()->id;
    	$validator = Validator::make($request->all(), $rules);
    	 
    	if ($validator->fails()) {
    		return redirect('members/dispute')
    		->withErrors($validator)
    		->withInput();
    	}else{
    		$DisputeDetail = UsersDispute::find($request->dispute_id);
    		if($request->response == 'Yes')
    		{
    			
    			$DisputeDetail->status = 2;
    			$DisputeDetail->save();
    			User::whereIn('id',[$DisputeDetail->complain_by,$DisputeDetail->complain_to])->update(['is_dispute' => 0]);
    			$ids = array($DisputeDetail->complain_by,$DisputeDetail->complain_to);
    			foreach ($ids as $uid){
    				$user = User::find($uid);
    				$email = $user->email;
    				$template = 'emails.dispute_reactivate';
    				$subject = $user->alias.", Your Bitregion account has been reactivated.";
    				$data = array(
    						'username'=>$user->alias
    				);
    				EmailClass::send_email($template, $email, $subject, $data, 1);
    			}
    		}else {
    			$DisputeDetail->status = 0;
    			$DisputeDetail->save();
    			
    			$logObj->users_dispute_id = $request->dispute_id;
    			$logObj->user_id = Auth::user()->id;
    			//$logObj->transaction_link	= $request->transaction_link;
    			$logObj->description = 'I Still have not received the amount that i claimed.';
    			$logObj->save();
    			User::where('id',[$DisputeDetail->complain_by])->update(['is_dispute' => 0]);
    		}
    		
    		return redirect("members/dispute")->with('message','Successfully updated.');
    		
    		
    	}
    }
    

}