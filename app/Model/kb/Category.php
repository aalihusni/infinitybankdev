<?php namespace App\Model\kb;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Model\kb\Article;
use App\Model\kb\Relationship;
class Category extends Model {

	protected $table = 'kb_category';
	protected $fillable = ['id', 'slug', 'name', 'description', 'status', 'created_at', 'updated_at'];
	
	
	public function getCategories() {
		$Query = Category::select ( 'kb_category.*','ArticleRelation.*' )
		->join ( 'kb_article as AR', 'AR.category_id', '=', 'kb_category.id','left')
		->leftJoin ( DB::raw ( '(SELECT category_id,count(*) as total
    			 FROM `kb_article` GROUP BY category_id) ArticleRelation' ), function ($join) {
	    			 	$join->on ( 'kb_category.id', '=', 'ArticleRelation.category_id' );
	    			 } )
	    ->where('kb_category.status', 1)
	    ->groupBy('kb_category.id')			 
	    ->orderBy ( 'ArticleRelation.total', 'desc' );
	    return $Query->get();
	}
	
	#### CATEGORY ARTICLES ##### 
	public function Articles($data){
		return $this->hasMany('App\Model\kb\Article')
				->join ( 'kb_article_detail as D', 'kb_article.id', '=', 'D.article_id' )
				->join ( 'language as L', 'L.id', '=', 'D.language_id')
				->join ( 'users as U', 'U.id', '=', 'D.added_by' )
				->where ( function ($query) use ($data){
					if(key_exists('language_id', $data))
					$query->where('D.language_id', $data['language_id']);
					if(key_exists('status', $data))
						$query->where('kb_article.status', $data['status']);
				} )->orderBy ( 'kb_article.id', 'asc' )
				->select('D.*','kb_article.*','L.name as lname','L.image','U.profile_pic');
	}
	
	public function totalArticle()
	{
		return $this->hasMany('App\Model\kb\Article','category_id');
	}
	
	
}
