<?php namespace App\Http\Controllers\Member\helpdesk\Admin;
// Controllers
use App\Http\Controllers\Controller;
use App\Http\Controllers\Member\kb\UserController;
// Requests
use App\Http\Requests\kb\ArticleRequest;
use App\Http\Requests\kb\ArticleUpdate;
use App\Http\Requests\kb\ArticleAddLanguage;


// Models
use App\Model\kb\Article;
use App\Model\kb\Category;
use App\Model\kb\Comment;
// Classes
use Auth;
use DB;
use Illuminate\Http\Request;
use Redirect;
use Exception;
use App\Classes\UserClass;
use Lang;
use Response;
use App\Model\Language;
use App\Model\kb\ArticleDetail;
use Input;
/**
 * ArticleController
 * This controller is used to CRUD Articles
 *
 * @package 	Controllers
 * @subpackage 	Controller
 * @author     	Cara <kamal@cara.com.my>
 */
class ArticleController extends Controller {

	/**
	 * Create a new controller instance.
	 * constructor to check
	 * 1. authentication
	 * 2. user roles 
	 * 3. roles must be admin
	 * @return void
	 */
	public function __construct() {
		// checking authentication
		$this->middleware('auth');
		$this->middleware('admin', ['except' => 'quick_login']);
		
	}
	
	

	/**
	 * List of Articles
	 * @return type view
	 */
	public function index(Article $article) {
		$user_id = Auth::user()->id;
		$user_details = UserClass::getUserDetails($user_id);
		$pagination = 15;
		$articles = $article->getAllArticles([])->paginate($pagination);
		$articleArr = array();
		$totalLanguage = Language::count();
		foreach ($articles as $art)
		{
		
			$languages = $art->ArticleLanguages;
			$articleArr[] = (object)array(
					'article_detail_id'=>$art->kb_article_detail_id,
					'article_id'=>$art->article_id,
					'name'=>$art->name,
					'can_delete'=>1,
					'langCode'=>$art->code,
					'language_id'=>$art->language_id,
					'totalLang'=>$art->totalLang,
					'description'=>$art->description,
					'slug'=>$art->slug,
					'created_at'=>$art->created_at,
					'languages'=>$languages,
					'addMore'=>(count($languages) < $totalLanguage)?'1':''
			);
		}
		return view('helpticket.admin.article.index')
		->with('user_details', $user_details)
		->with('articles', $articleArr)
		->with('renderPaginate', $articles);
	}
	
	/**
	 * Edit an Article by id
	 * @param type Integer $id
	 * @param type Article $article
	 * @param type Relationship $relation
	 * @param type Category $category
	 * @return view
	 */
	public function edit($id,Article $article,ArticleDetail $artDetail, Category $category) {
		$artDetail  = $artDetail->find($id);
		
		$article = $article->find($artDetail->article_id);
		$categories = $category->lists('id', 'name');
		$user_id = Auth::user()->id;
		$user_details = UserClass::getUserDetails($user_id);
		return view('helpticket.admin.article.edit', compact('artDetail', 'article', 'categories'))
		->with('user_details', $user_details)
		->with('language',Language::find($artDetail->language_id));
	
	}
	
	### EDIT BY LANGUAGE ####
	public function editArticle($article_id,$languageID,Article $article,ArticleDetail $artDetail, Category $category) {
		$artDetail  = $artDetail->where(['article_id'=>$article_id,'language_id'=>$languageID])->first();
		$article = $article->find($artDetail->article_id);
		$categories = $category->lists('id', 'name');
		$user_id = Auth::user()->id;
		$user_details = UserClass::getUserDetails($user_id);
		return view('helpticket.admin.article.editarticlelanguage', compact('artDetail', 'article', 'categories'))
		->with('user_details', $user_details)
		->with('language',Language::find($artDetail->language_id))
		->with('existingLangs', $artDetail->where(['article_id'=>$article->id])->lists('language_id')->toArray())
		->with('languages', Language::all());
	
	}
	
	/**
	 * Creating a Article
	 * @param type Category $category
	 * @return type view
	 */
	public function create(Category $category) {
		/* get the attributes of the category */
		$user_id = Auth::user()->id;
		$user_details = UserClass::getUserDetails($user_id);
		$category = $category->lists('id', 'name');
		//dd($category);
		return view('helpticket.admin.article.create')
		->with('user_details', $user_details)
		->with('categories', $category);
	}
	
	
	public function addMoreArticleLanguage($articleID,Article $article,ArticleDetail $artDetail,Category $category)
	{
		$article = $article->find($articleID);
		$artDetail  = $artDetail->where(['article_id'=>$article->id])->first();
		$categories = $category->lists('id', 'name');
		$user_id = Auth::user()->id;
		$user_details = UserClass::getUserDetails($user_id);
		return view('helpticket.admin.article.addlanguage', compact('article', 'categories'))
		->with('user_details', $user_details)
		->with('languages', Language::all())
		->with('artDetail',$artDetail)
		->with('existingLangs', $artDetail->where(['article_id'=>$article->id])->lists('language_id')->toArray())
		->with('language',Language::find($artDetail->language_id));
	}

	

	

}
