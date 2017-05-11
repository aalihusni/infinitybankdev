<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
class UsersDispute extends Model
{
    protected $table = 'users_dispute';
    
    /*
     * 0  pending (Complain To : Suspended)
     * 1  pending (Both : Suspended)
     * 2  Issues solved Both Active
     */
    
    public function getAll() { 
    	return UsersDispute::join('users as U1','U1.id', '=', 'users_dispute.complain_by','left')
    	->join('users as U2','U2.id', '=', 'users_dispute.complain_to','left')
    	->select('users_dispute.*','U1.alias as byAlias','U2.alias as toAlias','U1.is_dispute as statusBy','U2.is_dispute as statusTo','U1.country_code as byCode','U2.country_code as toCode')
    	->orderBy('users_dispute.created_at','desc')
    	->get();
        			 
    }
    
    public function getDetail($id) {
    	return UsersDispute::join('users as U1','U1.id', '=', 'users_dispute.complain_by','left')
    	->join('users as U2','U2.id', '=', 'users_dispute.complain_to','left')
    	->where('users_dispute.id',$id)
    	->select('users_dispute.*','U1.alias as byAlias','U2.alias as toAlias','U1.is_dispute as statusBy','U2.is_dispute as statusTo','U1.country_code as byCode','U2.country_code as toCode')
    	->first();
    
    }
    
    public function getLogs()
    {
    	return $this->hasMany('App\Model\UsersDisputeLogs')->join('users','users_dispute_logs.user_id','=','users.id')
    	->select('users_dispute_logs.*','users.alias');
    }
    
    public function getTransactionLink()
    {
    	return $this->hasMany('App\Model\UsersDisputeLogs')->where('transaction_link','!=','');
    }
    
}
