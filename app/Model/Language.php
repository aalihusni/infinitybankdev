<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Session;
class Language extends Model
{
   /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'language';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'code', 'locale','image','directory','filename','sort_order','status'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public function Enquiries()
    {
    	
    	 return $this->hasMany('App\Models\Enquires')->where('language_id', Session::get('language_id'));
    }
    
    public static function ActiveLang()
    {
    	return self::where('language_id', '=', Session::get('language_id'));
    }
    
    public function LanguageTranslationRequest()
    {
    	return $this->hasMany('App\Model\LanguageTranslation')->join('users','language_translation.user_id','=','users.id')
    	->join('language','language_translation.language_id','=','language.id')
    	->select('language_translation.*','users.alias','users.email','language.name','language.image','language.code');
    }
}
