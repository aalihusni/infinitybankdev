<?php
namespace App\Http\Controllers\Member\helpdesk\Admin;
// controllers
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Illuminate\Http\Request;
use Auth;
use Response;

use App\Model\helpdesk\Ticket\TicketManager;
use App\Model\helpdesk\Ticket\TicketHelpTopicManager;
use App\Model\helpdesk\Manage\Help_topic;
use Validator;
use App\Model\helpdesk\Ticket\Tickets;
/**
 * ManageTicketController
 *
 * @package Controllers
 * @subpackage Controller
 * 
 */
class ManageTicketController extends Controller {
	
	/**
	 * Create a new controller instance.
	 * 
	 * @return type response
	 */
	
	public function __construct() {
		// SettingsController::smtp();
		$this->middleware ( 'admin', [ 
				'except' => 'quick_login'
		] );
	}
	
	public function index(Help_topic $Topic,TicketManager $Manager,TicketHelpTopicManager $TopicManager)
	{
		$SupportTeams = $Manager->get();
		$TeamsData = [];
		foreach ($SupportTeams as $team)
		{
			$assignedTopics = $Manager->getAssignedTopics(['manager_code'=>$team->manager_code]);
			$TeamsData[] = (object)['id'=>$team->id,'manager_code'=>$team->manager_code,'assignedTopics'=>$assignedTopics];
		}
		return view ( 'helpticket.admin.ticket.manage.index' )
				->with('Topics',$Topic->OrderBy('ordering','asc')->get())
				->with('Managers',$TeamsData);
	}
	
	### UPDATE TOPIC ###
	public function updateTopic(Request $request)
	{
		$validator = $this->validateForm('HelpTopic', $request);
		if ($validator->fails()) {
			return Response::json(array(
					'response' => 0,
					'errors' => $validator->getMessageBag()->toArray()
			));
		}
		$id = $request->topic_id;
		$HelpTopic = Help_topic::find($id);
		$HelpTopic->topic = $request->topic;
		$HelpTopic->description = $request->description;
		$HelpTopic->css_class = $request->css_class;
		$HelpTopic->status = $request->status;
		$HelpTopic->ordering = $request->ordering;
		$HelpTopic->save();
		return Response::json ( ['response'=>1,'StatusText'=>getStatusString($request->status)]);
	}
	
	public function insertTopic(Request $request)
	{
		$validator = $this->validateForm('HelpTopic', $request);
		if ($validator->fails()) {
			return Response::json(array(
					'response' => 0,
					'errors' => $validator->getMessageBag()->toArray()
			));
		}
		$HelpTopic = Help_topic::findOrNew(0);
		$HelpTopic->topic = $request->topic;
		$HelpTopic->description = $request->description;
		$HelpTopic->status = $request->status;
		$HelpTopic->css_class = $request->css_class;
		$HelpTopic->ordering = $request->ordering;
		$HelpTopic->save();
		$id = $HelpTopic->id;
		$text = "<tr id=\"row\">";
		$text .="<td id=\"topic_row".$id."\">$HelpTopic->topic</td>";
		$text .="<td id=\"open_row".$id."\">0</td>";
		$text .="<td id=\"description_row".$id."\">$HelpTopic->description</td>";
		$text .="<td id=\"css_class_row".$id."\">$HelpTopic->css_class</td>";
		$text .="<td id=\"status_row".$id."\">".getStatusString($HelpTopic->status)."<input type='hidden' id='td_status_".$id."' value='".$request->status."' /></td>";
		$text .="<td id=\"ordering_row".$id."\">$HelpTopic->ordering</td>";
		$text .="<td><button type=\"button\" class=\"btn btn-primary btn-xs\" id=\"edit_button".$id."\" onclick=\"edit_row('".$id."')\"><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></button>";
		$text .="<button type=\"button\" class=\"btn btn-danger btn-xs save\" id=\"save_button".$id."\" onclick=\"save_row('".$id."')\"><i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>";
		//$text .="&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></button>";
		$text .="</td>";
		$text .="</tr>";
		
		return Response::json ( ['response'=>1,'id'=>$HelpTopic->id,'newRow'=>$text]);
	}
	
	public function deleteTopic(Request $request,Tickets $Ticket,Help_topic $Topic)
	{
		$topicId = $request->topic_id;
		$Row = $Topic->whereId($topicId)->first();
		$hasTicket = $Ticket->where(['help_topic_id'=>$topicId])->count();
		if($hasTicket)
		{
			return Response::json ( ['response'=>0,'message'=>"Warning: This topic(".$Row->topic.") cannot be deleted as it is currently assigned to $hasTicket tickets!"]);
		}else{
			$Row->delete();
			return Response::json ( ['response'=>1]);
		}
	}
	
	
	
	
	public function loadTopics($code='',Help_topic $Topic,TicketManager $Manager)
	{
		$assignedTopics = $Manager->getAssignedTopics(['manager_code'=>$code]);
		$assignedIds = array();
		foreach ($assignedTopics as $asigned)
		{
			$assignedIds[] = $asigned->id;
		}
		$unAssignedTopics = $Topic->whereNotIn('id',$assignedIds)->OrderBy('ordering','asc')->get();
		
		return view ( 'helpticket.admin.ticket.manage.loadtopic' )
		->with('Topics',$unAssignedTopics);
		
		
	}
	
	public function postAssignTopic(Request $request,TicketHelpTopicManager $TopicManager)
	{
			$IDS = $request->topicIDS;
			$hasAssignedAlready = $TopicManager->whereIn('topic_id',$IDS)->where('assign_to',$request->selected_manager_code)->count();
			if($hasAssignedAlready || !count($IDS))
			{
				return Response::json ( ['response'=>0,'message'=>'Topics Already Assigned.']);
			}else{
				$insertData = array();
				foreach($IDS as $id){
					$insertData[] = ['topic_id' => $id, 'assign_to' => $request->selected_manager_code];
				}
				DB::table('tkt_help_topic_manager')->insert($insertData);
				return Response::json ( ['response'=>1,'message'=>'Assigned Successfully']);
			}
	}
	
	public function  deleteAssignedTopic(Request $request,TicketHelpTopicManager $TopicManager)
	{
		$Row = $TopicManager->where(['assign_to'=>$request->mgr_code,'topic_id'=>$request->topic_id])->first();
		if(is_null($Row))
		{
			return Response::json ( ['response'=>0]);
		}else{
			
			$Row->delete();
			return Response::json ( ['response'=>1]);
		}
		
	}
	
	public function deleteTeamManager(Request $request,Tickets $tickets, TicketHelpTopicManager $TopicManager,TicketManager $Manager)
	{
		$memberId = $request->mgr_id;
		$MemberDetail = $Manager->whereId($memberId)->first();
		$hasIndividualAsignTickets = $tickets->where(['assigned_to_manager_id'=>$memberId,'status'=>1])->count();
		if($hasIndividualAsignTickets)
		{
			return Response::json ( ['response'=>0,'message'=>"Warning: This Team Member (".$MemberDetail->manager_code.") cannot be deleted as it is currently assigned to $hasIndividualAsignTickets Open Tickets!"]);
		
		}else{
			
			$TopicManager->where(['assign_to'=>$MemberDetail->manager_code])->delete();
			$MemberDetail->delete();
			return Response::json ( ['response'=>1]);
		}
	}
	public function addTeamManager(Request $request,TicketManager $Manager)
	{
		$manager_code = $request->manager_code;
		$validator = $this->validateForm('Manager', $request);
		if ($validator->fails()) {
			return Response::json(array(
					'response' => 0,
					'errors' => $validator->getMessageBag()->toArray()
			));
		}
		$Manager->manager_code = $manager_code;
		$Manager->save();
		
		return Response::json ( ['response'=>1]);
	}
	
	private function validateForm($validateFor, $request) {
		$rules = array();
		switch ($validateFor) {
			case 'HelpTopic':
				if(isset($request->topic_id))
					$rules['topic'] = 'required|unique:tkt_help_topic,topic,'.$request->topic_id;
					else $rules['topic'] = 'required|unique:tkt_help_topic';
					$rules['ordering'] = 'required';
					break;
					
					case 'Manager':
						$rules['manager_code'] = 'required|unique:tkt_manager';
					break;
		}
		return Validator::make($request->all(), $rules);
	}
}
