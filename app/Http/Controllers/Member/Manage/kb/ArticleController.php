<?php namespace App\Http\Controllers\Member\Manage\kb;
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
	 * 3. roles must be agent
	 * @return void
	 */
	public function __construct() {
		// checking authentication
		$this->middleware('auth');
		// checking roles
		$this->middleware('roles');
		//SettingsController::language();
	}
	
	public function test() {
		//$table = $this->setDatatable();
		return view('themes.default1.agent.kb.article.test');
	}

	/**
	 * Fetching all the list of articles in a chumper datatable format
	 * @return type void
	 */
	public function getData() {
		// returns chumper datatable
		return Datatable::collection(Article::All())
			/* searcable column name */
			->searchColumns('name')
			/* order column name and description */
			->orderColumns('name', 'description')
			/* add column name */
			->addColumn('name', function ($model) {
				return $model->name;
			})
			/* add column Created */
			->addColumn('Created', function ($model) {
				$t = $model->created_at;
				return TicketController::usertimezone($t);
			})
			/* add column action */
			->addColumn('Actions', function ($model) {
				/* here are all the action buttons and modal popup to delete articles with confirmations */
				return '<span  data-toggle="modal" data-target="#deletearticle'.$model->id .'"><a href="#" ><button class="btn btn-danger btn-xs"></a> ' . \Lang::get('lang.delete') . ' </button></span>&nbsp;<a href=article/' . $model->id . '/edit class="btn btn-warning btn-xs">' . \Lang::get('lang.edit') . '</a>&nbsp;<a href=show/'.$model->slug .' class="btn btn-primary btn-xs">' . \Lang::get('lang.view') . '</a>
				<div class="modal fade" id="deletearticle'.$model->id .'">
        			<div class="modal-dialog">
            			<div class="modal-content">
                			<div class="modal-header">
                    			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    			<h4 class="modal-title">Are You Sure ?</h4>
                			</div>
                			<div class="modal-body">
                				'.$model->name.'
                			</div>
                			<div class="modal-footer">
                    			<button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis2">Close</button>
                    			<a href="article/delete/'.$model->slug.'"><button class="btn btn-danger">delete</button></a>
                			</div>
            			</div><!-- /.modal-content -->
        			</div><!-- /.modal-dialog -->
    			</div>';
				})
				->make();
	}

	/**
	 * List of Articles
	 * @return type view
	 */
	public function index(Article $article) {
		
		$user_id = Auth::user()->id;
		$user_details = UserClass::getUserDetails($user_id);
		$pagination = 10;
		$articles = $article->getAllArticles([])->paginate($pagination);
		
		$articleArr = array();
		$totalLanguage = Language::count();
		
		foreach ($articles as $art)
		{
			
			//if($art->totalLang > 1)
			$languages = $art->ArticleLanguages;
			$articleArr[] = (object)array(
					'article_detail_id'=>$art->kb_article_detail_id,
					'article_id'=>$art->article_id,
					'name'=>$art->name,
					'can_delete'=>($art->added_by==Auth::user()->id)?'1':'0',
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
		
		return view('helpticket.manage.kb.article.index')
		->with('user_details', $user_details)
		->with('articles', $articleArr);
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
		return view('helpticket.manage.kb.article.create')
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
		return view('helpticket.manage.kb.article.addlanguage', compact('article', 'categories'))
		->with('user_details', $user_details)
		->with('languages', Language::all())
		->with('artDetail',$artDetail)
		->with('existingLangs', $artDetail->where(['article_id'=>$article->id])->lists('language_id')->toArray())
		->with('language',Language::find($artDetail->language_id));
	}
	public function postMoreArticleLanguage(Request $request,Article $article, ArticleAddLanguage $request)
	{
		//dd($request->input('description'));
		//dd(Input::all());
		$sl = $request->input('name');
		$Language = Language::find($request->input('language_id'));
		$slug = str_slug($sl, "-");
		$articleDetail = ArticleDetail::findOrNew($request->article_detail_id);
	
		$articleDetail->slug = $slug.'-'.$Language->code;
		$articleDetail->article_id = $request->article_id;
		$articleDetail->name =  $request->input('name');
		$articleDetail->status = $request->input('status');
		$articleDetail->language_id = $request->input('language_id');
		$articleDetail->description = $request->input('description');
		if(!$request->article_detail_id)
		$articleDetail->added_by = Auth::user()->id;
		$result = $articleDetail->save();
		if($result){
			$message = 'Article Inserted Successfully';
			if($request->article_detail_id)
				$message = 'Article Updated Successfully';
			$response = ['response' => 1,'message'=>$message];
		} else {
			$response = ['response' => 0,'message'=>'Article Not Inserted'];
		}
		return Response::json ( $response );
	}

	/**
	 * Insert the values to the article
	 * @param type Article $article
	 * @param type ArticleRequest $request
	 * @return type redirect
	 */
	public function store(ArticleRequest $request,ArticleDetail $articleDetail) {
		// requesting the values to store article data
		$DefaultLang = Language::find(1);
		DB::beginTransaction ();
		$article = new Article();
		$article->category_id = $request->input('category_id');
		$article->status = $request->input('status');
		$article->save();
		$sl = $request->input('name');
		$slug = str_slug($sl, "-");
		$articleDetail->slug = $slug.'-'.$DefaultLang->code;
		$articleDetail->article_id = $article->id;
		$articleDetail->name =  $request->input('name');
		$articleDetail->language_id = $DefaultLang->id;
		$articleDetail->description = $request->input('description');
		$articleDetail->added_by = Auth::user()->id;
		$result = $articleDetail->save();
		if($result){
			DB::commit ();
			$response = ['response' => 1,'message'=>'Article Inserted Successfully'];
		} else {
			DB::rollback ();
			$response = ['response' => 0,'message'=>'Article Not Inserted'];
		}
		return Response::json ( $response );
		
		
	}

	/**
	 * Edit an Article by id
	 * @param type Integer $id
	 * @param type Article $article
	
	 * @param type Category $category
	 * @return view
	 */
	public function edit($id,Article $article,ArticleDetail $artDetail, Category $category) {
		$artDetail  = $artDetail->find($id);
		$article = $article->find($artDetail->article_id);
		$categories = $category->lists('id', 'name');
		$user_id = Auth::user()->id;
		$user_details = UserClass::getUserDetails($user_id);
		return view('helpticket.manage.kb.article.edit', compact('artDetail', 'article', 'categories'))
		->with('user_details', $user_details)
		->with('language',Language::find($artDetail->language_id));
		
	}
	
	
	public function editArticle($article_id,$languageID,Article $article,ArticleDetail $artDetail, Category $category) {
		$artDetail  = $artDetail->where(['article_id'=>$article_id,'language_id'=>$languageID])->first();
		$article = $article->find($artDetail->article_id);
		$categories = $category->lists('id', 'name');
		$user_id = Auth::user()->id;
		$user_details = UserClass::getUserDetails($user_id);
		return view('helpticket.manage.kb.article.editarticlelanguage', compact('artDetail', 'article', 'categories'))
		->with('user_details', $user_details)
		->with('language',Language::find($artDetail->language_id))
		->with('existingLangs', $artDetail->where(['article_id'=>$article->id])->lists('language_id')->toArray())
		->with('languages', Language::all());
	
	}

	/**
	 * Update an Artile by id
	 * @param type Integer $id
	 * @param type Article $article
	 
	 * @param type ArticleRequest $request
	 * @return Response
	 */
	public function update($id, Article $article, ArticleUpdate $request) {
		
		// requesting the values to store article data
		$DefaultLang = Language::find(1);
		DB::beginTransaction ();
		$article = Article::find($id);
		$article->category_id = $request->input('category_id');
		$article->status = $request->input('status');
		$article->save();
		$sl = $request->input('name');
		$slug = str_slug($sl, "-");
		$articleDetail = ArticleDetail::where(['article_id'=>$id])->first();
		$articleDetail->slug = $slug.'-'.$DefaultLang->code;
		$articleDetail->name =  $request->input('name');
		//$articleDetail->language_id = $DefaultLang->id;
		$articleDetail->description = $request->input('description');
		$articleDetail->added_by = Auth::user()->id;
		$result = $articleDetail->save();
		if($result){
			DB::commit ();
			$response = ['response' => 1,'message'=>'Article Updated Successfully'];
		} else {
			DB::rollback ();
			$response = ['response' => 0,'message'=>'Article Not Inserted'];
		}
		return Response::json ( $response );
		
	}
	
	

	/**
	 * Delete an 
	 * @param type $id
	 * @param type Article $article
	 * @return Response
	 */
	public function destroy(Request $request,Article $article,Comment $comment,ArticleDetail $ArticleDetail) {
    	/* delete the selected article from the table */
		$article_id = $request->article_id;
		$languageId = $request->language_id;
		//if(!$languageId)
			//$languageId = 1;
		$artDetail  = $ArticleDetail->where(['article_id'=>$article_id,'language_id'=>$languageId])->first();
		
		$article = Article::find($artDetail->article_id); //get the selected article via id
		$totalArticle = $ArticleDetail->where(['article_id'=>$article_id])->count();
		DB::beginTransaction ();
		if($totalArticle >1)
		{
			$artDetail->comments()->delete();
			$result= $artDetail->delete();
			$deleteRow = 0;
		}else {
			$article->allComments()->delete();
			$artDetail->delete();
			$result = $article->delete();
			$deleteRow = 1;
		}
		if($result){
			DB::commit ();
			$response = ['response' => 1,'message'=>'Article Deleted Successfully','delRow'=>$deleteRow];
		} else {
			DB::rollback ();
			$response = ['response' => 0,'message'=>'Article Not Deleted','delRow'=>$deleteRow];
		}
		return Response::json ( $response );
	}

	/**
	 * user time zone
	 * fetching timezone
	 * @param type $utc
	 * @return type
	 */
	static function usertimezone($utc) {
		$user = Auth::user();
		$tz = $user->timezone;
		$set = Settings::whereId('1')->first();
		$format = $set->dateformat;
		//$utc = date('M d Y h:i:s A');
		date_default_timezone_set($tz);
		$offset = date('Z', strtotime($utc));
		$date = date($format, strtotime($utc) + $offset);
		echo $date;
	}

}
