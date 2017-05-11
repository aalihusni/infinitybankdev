<?php namespace App\Model\kb;
use Illuminate\Database\Eloquent\Model;
class ArticleDetail extends Model {

	/*  define the table name to get the properties of article model as protected  */
	protected $table = 'kb_article_detail';
	/* define the fillable field in the table */
	protected $dates = ['created_at', 'updated_at'];
	protected $fillable = ['name', 'slug','article_id','language_id', 'description', 'type', 'status'];

	public function comments()
	{
		return $this->hasMany('App\Model\kb\Comment','article_detail_id');
	}
}
