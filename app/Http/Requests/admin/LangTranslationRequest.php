<?php
namespace App\Http\Requests\admin;
use Illuminate\Foundation\Http\FormRequest;
use Response;
use Illuminate\Support\Facades\Input;
use App\User;

class LangTranslationRequest extends FormRequest
{
    
    public function rules()
    {
    	$user_id = Input::get('filter_id');
    	$rules['filter_id'] = 'required|exists:users,id';
    	$rules['language_id'] = 'required|exists:language,id';
    	$rules['lang_files'] = 'required';
    	return  $rules;
    }
    
    /**
     * Determine if the user is valid to become leader.
     *
     * @return bool
     */
    public function authorize()
    {
    	return true;
    	$user_id = Input::get('filter_id');
    	$Validate =  User::where('id', $user_id)
    	->where('user_type',2)
    	->where('user_class', '<>', 0)
    	->count();
    	if($Validate)
    		return true;
    	else return false;
    }
    
	#### OPTIONAL RESPONSE ####
	public function response(array $errors)
	{
		
		return Response::json ( array (
				'errors' => $errors,
				'response' => 0
		) );
			
	}
	
	#### OPTIONAL AUTHORIZE FORBIDDEN  ####
	public function forbiddenResponse()
	{
	return Response::json ( array (
			'response' => 0,
			'errors' => array('filter_id'=>'User must have user_type : 2 & user_class > 0')
		) );
	}
    
    
}
?>