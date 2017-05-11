<?php

namespace App\Model\kb;

use Illuminate\Database\Eloquent\Model;
use DB;

class Article extends Model {
	public $timestamps = false;
	/* define the table name to get the properties of article model as protected */
	protected $table = 'kb_article';
	/* define the fillable field in the table */
	// protected $fillable = ['name', 'slug', 'category_id','description', 'type', 'status'];
	protected $fillable = [ 
			'category_id',
			'type',
			'status' 
	];
	
	
	public function allComments() {
		return $this->hasMany ( 'App\Model\kb\Comment', 'article_id' );
	}
	public function comments() {
		return $this->hasMany ( 'App\Model\kb\Comment', 'article_id' )->select ( 'kb_comment.*', 'U.profile_pic', 'U.firstname', 'U.lastname' )->join ( 'users as U', 'U.id', '=', 'kb_comment.user_id' )->orderBy ( 'kb_comment.id', 'asc' );
	}
	public function getAllArticles($data) {
		return Article::select ( 'kb_article.id', 'D.article_id', 'D.language_id', 'D.name', 'D.added_by', 'D.description', 'D.slug', 'D.created_at', 'D.id as kb_article_detail_id', 'kb_article.category_id', 'L.name as lname', 'L.code', 'L.image', 'langRelation.totalLang' )->join ( 'kb_article_detail as D', 'kb_article.id', '=', 'D.article_id' )->join ( 'kb_category as C', 'C.id', '=', 'kb_article.category_id' )->join ( 'language as L', 'L.id', '=', 'D.language_id' )->leftJoin ( DB::raw ( '(SELECT article_id,count(language_id) as totalLang
    			 FROM `kb_article_detail` GROUP BY article_id) langRelation' ), function ($join) {
			$join->on ( 'kb_article.id', '=', 'langRelation.article_id' );
		} )->where ( function ($query) use($data) {
			if (key_exists ( 'category_id', $data ))
				$query->where ( 'kb_article.category_id', $data ['category_id'] );
			$query->where ( 'D.language_id', 1 );
			if (key_exists ( 'category_status', $data ))
				$query->where ( 'C.status', $data ['category_status'] );
			if (key_exists ( 'article_status', $data ))
				$query->where ( 'kb_article.status', $data ['article_status'] );
		} )->orderBy ( 'kb_article.id', 'asc' );
	}
	public function ArticleLanguages() {
		return $this->hasMany ( 'App\Model\kb\ArticleDetail' )->join ( 'language as L', 'L.id', '=', 'kb_article_detail.language_id' )->select ( 'L.name', 'L.image', 'L.code', 'L.id', 'kb_article_detail.slug', 'kb_article_detail.added_by' );
	}
	public function search($data) {
		return Article::select ( 'kb_article.id', 'D.article_id', 'D.language_id', 'D.name', 'D.added_by', 'D.description', 'D.slug', 'D.created_at', 'D.id as kb_article_detail_id', 'kb_article.category_id', 'L.name as lname', 'L.code', 'L.image', 'langRelation.totalLang' )->join ( 'kb_article_detail as D', 'kb_article.id', '=', 'D.article_id' )->join ( 'kb_category as C', 'C.id', '=', 'kb_article.category_id' )->join ( 'language as L', 'L.id', '=', 'D.language_id' )->leftJoin ( DB::raw ( '(SELECT article_id,count(language_id) as totalLang
    			 FROM `kb_article_detail` GROUP BY article_id) langRelation' ), function ($join) {
			$join->on ( 'kb_article.id', '=', 'langRelation.article_id' );
		} )->where ( function ($query) use($data) {
			$query->where ( 'D.name', 'LIKE', "%{$data['search_txt']}%" )->orWhere ( 'D.description', 'LIKE', "%{$data['search_txt']}%" )->orWhere ( 'D.slug', 'LIKE', "%{$data['search_txt']}%" );
			if (key_exists ( 'category_id', $data ))
				$query->where ( 'kb_article.category_id', $data ['category_id'] );
			$query->where ( 'D.language_id', 1 );
			if (key_exists ( 'category_status', $data ))
				$query->where ( 'c.status', $data ['category_status'] );
			if (key_exists ( 'article_status', $data ))
				$query->where ( 'kb_article.status', $data ['article_status'] );
		} )->groupBy ( 'D.id' )->orderBy ( 'kb_article.id', 'asc' );
	}
}
