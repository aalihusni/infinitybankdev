<?php namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class LanguageTranslation extends Model {

    protected $table = 'language_translation';
    
	public function getAll()
	{
		return LanguageTranslation::join('users','language_translation.user_id','=','users.id')
				->join('language','language_translation.language_id','=','language.id')
				->select('language_translation.*','users.alias','users.email','language.name')
				->orderBy('language_translation.id','desc')
				->get();
	}
	
	public function getMembersRequestList($data)
	{
		return LanguageTranslation::join('users','language_translation.user_id','=','users.id')
		->join('language','language_translation.language_id','=','language.id')
		->where(function ($query)use($data){
			$query->where('language_translation.user_id',$data['user_id']);
			$query->whereIn('language_translation.status',$data['status']);
			if(key_exists('language_id', $data))
				$query->where('language_id',$data['language_id']);
		})
		->select('language_translation.*','users.alias','users.email','language.name','language.image')
		->orderBy('language_translation.id','desc')
		->get();
	}
	
	public static function hasRecords($data)
	{
		return LanguageTranslation::where(function ($query)use($data){
			$query->where('user_id',$data['user_id']);
			$query->whereIn('status',$data['status']);
			if(key_exists('language_id', $data))
				$query->where('language_id',$data['language_id']);
		})
		->first();
	}
	
	public function translatedData()
	{
		return $this->hasMany('App\Model\LanguageTranslationFiles');
	}
}