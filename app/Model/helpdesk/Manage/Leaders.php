<?php namespace App\Model\helpdesk\Manage;

use Illuminate\Database\Eloquent\Model;

class Leaders extends Model
{
	protected $table = 'leaders';
	protected $fillable = 	[
								'user_id', 'default',  'country_code','created_at'
							];
	
	public function getLeaders()
	{
		return Leaders::join ( 'users as U', 'U.id', '=', 'leaders.user_id' )
		->select('U.*','leaders.country_code','leaders.created_at as addedOn','leaders.id as leaders_id');
	}
	
	public function getLeadersToAssign($data)
	{
		return Leaders::join ( 'users as U', 'U.id', '=', 'leaders.user_id' )
		->where(function($query)use($data){
			$query->where('leaders.country_code',$data['country_code']);
		})
		->select('U.firstname','U.lastname','U.profile_pic', 'U.id', 'leaders.country_code','leaders.created_at as addedOn');
	}
}							