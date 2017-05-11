<?php namespace App\Http\Controllers\Member\helpdesk\Admin;
use App\Http\Controllers\Controller;

use Auth;
use Illuminate\Http\Request;
use Response;
use Redirect;
use Crypt;
use Input;
use App\User;
use App\Classes\PAGBClass;
use App\Classes\EmailClass;
use App\Classes\PassportClass;
use DB;
use App\Model\helpdesk\Manage\Leaders;
use Validator;
use App\Model\helpdesk\Ticket\Tickets;

class ManageLeaderController extends Controller {

    public function __construct()
    {
        $this->middleware('admin', ['except' => 'quick_login']);
    }

    public function quick_login($id)
    {
        if (isset($_COOKIE['cookieAdmin'])) {
            $cookieadmin = Crypt::decrypt($_COOKIE['cookieAdmin']);
            if ($cookieadmin) {
                if ($id == 1) {
                    Auth::loginUsingId($id);
                    return Redirect::to('admin/home');
                } else {
                    if (Auth::user()->id == 1) {
                        Auth::loginUsingId($id);
                        return Redirect::to('members/home');
                    }
                }
            }
        }

        return Redirect::to('login');
    }
    public function index(Leaders $leader,$filter_type = "", $filter_value = "")
    {
    	$DistinctCodes = User::select('country_code')->distinct()
    	->whereNotNull('country_code')
    	->where('country_code','<>','')
    	->get();
    	
    	
    	$leaders = $leader->getLeaders()->paginate(50);
    	return view('helpticket.admin.leader.index')
    	->with('Lists', $leaders)
    	->with('countryCode',$DistinctCodes)
    	->with('renderList',$leaders);
    	 
    }
    
    public function getKeyUp(Request $request)
    {
    	$user_id = $request->filter_id;
    	$code = $request->filter_country_code;
    	$filter_email = $request->filter_email;
    	$htmlData = '';
    	$Sql = User::where(function($query)use($user_id,$code,$filter_email){
    		if($user_id)
    			$query->where('id',$user_id);
    		//$query->where('id',$user_id);
    			if($filter_email)
    				$query->where('email',$filter_email);
    	});
    	
    	$result = $Sql->first();
    	if(is_null($result)){
    		$htmlData = 'No Result';
    		$hasRecord = 0;
    	}
    		
    	else{
    		$htmlData = 'User ID : '.$result->id.' ';
    		$htmlData .= '<br>Name : '.$result->firstname.' '.$result->lastname;
    		$htmlData .= '<br> Email : '.$result->email.'';
    		$htmlData .= '<br> Alias : <b>'.$result->alias.'</b>';
    		$htmlData .= '<br> Country Code : <b>'.$result->country_code.'</b>';
    		$hasRecord = 1;
    	}
    	return Response::json(array('content'=>$htmlData,'hasRecord'=>$hasRecord));
    	
    }
    
    public function postLeaderForm(Request $request,Leaders $Leader)
    {
    	##### FORM VALIDATION ####
    	$InputData['filter_id'] = Input::get('filter_id');
    	$InputData['country_code'] = Input::get('country_code');
    	$validator = Validator::make ( $InputData, [
    			'filter_id' => 'required|exists:users,id',
    			'country_code' => 'required|unique:leaders,country_code,NULL,id,user_id,' . Input::get('filter_id'),
    			//'country_code' => 'exists:leaders,country_code,user_id,'.Input::get('filter_id'),
    			] );
    	if ($validator->fails ()) {
    		return Response::json ( array (
    				'response' => 0,
    				'errors' => $validator->getMessageBag ()->toArray ()
    		) );
    	}
    	$Leader->user_id = Input::get('filter_id');
    	$Leader->country_code = Input::get('country_code');
    	
    	$hasLeaderForCode = Leaders::where('country_code',Input::get('country_code'))->count();
    	if(!$hasLeaderForCode)
    		$Leader->default = 1;
    	
    	$Leader->save();
    	
    	#### UPDATE leader_at in USER TABLE #####
    	/* $User = User::find(Input::get('filter_id'));
    	$User->leader_at = DB::raw('CURRENT_TIMESTAMP');
    	$User->save();
    	*/
    	
    	$response = ['response' => 1,'message'=>'Added Successfully'];
    	return Response::json($response);
    	##### FORM VALIDATION ####
    	
    }
    
    public function Remove($leaderID)
    {
    	
    	$Row = Leaders::find($leaderID);
    	$hasAssignedTicketOpen = Tickets::where(['assigned_to'=>$Row->user_id,'status'=>1])->count();
    	if($hasAssignedTicketOpen)
    	{
    		return Redirect::back()->withErrors('Sorry! System can not remove the selected Leader as leader has assigned to ('.$hasAssignedTicketOpen.')  Tickets.');
    	}
    	$result = $Row->delete();
    	if($result)
    		return redirect()->back()->with('success','Leader Deleted');
    	else 
    		return Redirect::back()->withErrors('Action Failed to Delete !');
    }

   

    
}