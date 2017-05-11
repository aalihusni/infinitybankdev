<?php namespace App\Http\Controllers\Member\kb;

use App\Http\Controllers\Controller;
use App\Http\Requests\kb\CommentRequest;
use App\Http\Requests\kb\SearchRequest;
use App\Model\kb\Article;
use App\Model\kb\ArticleDetail;

use App\Model\kb\Category;
use App\Model\kb\Comment;
use App\Model\Language;
//use Config;
use Illuminate\Http\Request;
use Mail;
use Auth;
use Redirect;
use Hash;
use Exception;
use App\Classes\UserClass;
use Lang;
use Response;

class UserController extends Controller {

	public function __construct() {
		
	}

	/**
 	* @param
 	* @return response
 	* @package default
 	* 
 	*/
	public function getArticle(Article $article, Category $category) {
		
		$user_id = Auth::user()->id;
		$user_details = UserClass::getUserDetails($user_id);
		
		$pagination = 10;
		$articles = $article->getAllArticles(['category_status'=>1,'article_status'=>1])->paginate($pagination);
		
		$articleArr = array();
		foreach ($articles as $art)
		{
			$languages = $art->ArticleLanguages;
			$articleArr[] = (object)array(
					'article_id'=>$art->article_id,
					'name'=>$art->name,
					'totalLang'=>$art->totalLang,
					'description'=>$art->description,
					'slug'=>$art->slug,
					'created_at'=>$art->created_at,
					'languages'=>$languages
			);
		}
		
		$Categories = $category->getCategories();
		
		return view('helpticket.member.kb.article-list.all')
		->with('user_details', $user_details)
		->with('categorys', $Categories)
		->with('article', $articleArr);
	}
	
	public function loadArticleOfSelLang(Request $request,ArticleDetail $articleDetail)
	{
		$articleID = $request->articleID;
		$langID =$request->langID;
		$slug = $request->slug;
		$articleDetail = $articleDetail->where(['article_id'=>$articleID, 'language_id'=>$langID])->first();
		return view('helpticket.member.kb.article-list.ajax-lang-article')
		->with('article',$articleDetail);
		
	}

	/**
	 * Get excerpt from string
	 *
	 * @param String $str String to get an excerpt from
	 * @param Integer $startPos Position int string to start excerpt from
	 * @param Integer $maxLength Maximum length the excerpt may be
	 * @return String excerpt
	 */
	static function getExcerpt($str, $startPos = 0, $maxLength = 50) {
		if (strlen($str) > $maxLength) {
			$excerpt = substr($str, $startPos, $maxLength - 3);
			$lastSpace = strrpos($excerpt, ' ');
			$excerpt = substr($excerpt, 0, $lastSpace);
			$excerpt .= '...';
		} else {
			$excerpt = $str;
		}

		return $excerpt;
	}

	public function search(SearchRequest $request, Category $category, Article $article) {
		
		
		$user_id = Auth::user()->id;
		$user_details = UserClass::getUserDetails($user_id);
		$pagination = 10;
		$search = $request->input('search-text');
		$articles = $article->search(['article_status'=>1,'search_txt'=>$search])->paginate(20);
		$articleArr = array();
		foreach ($articles as $art)
		{
			$languages = $art->ArticleLanguages;
			$articleArr[] = (object)array(
					'article_id'=>$art->article_id,
					'name'=>$art->name,
					'totalLang'=>$art->totalLang,
					'description'=>$art->description,
					'slug'=>$art->slug,
					'created_at'=>$art->created_at,
					'languages'=>$languages
			);
		}
		//$Categories = $category->getCategories()->where('status',1);
		$Categories = $category->getCategories();
		return view('helpticket.member.kb.article-list.search')
		->with('user_details', $user_details)
		->with('categorys', $Categories)
		->with('search_txt',$search)
		->with('article', $articleArr);
		
	}

	/**
	 * to show the seleted article
	 * @return response
	 */
	public function show($slug, Article $article,  ArticleDetail $articleDetail, Category $category) {
		$user_id = Auth::user()->id;
		$user_details = UserClass::getUserDetails($user_id);
		$articleDetail = $articleDetail->where('slug', $slug)->first();
		$Article = Article::find($articleDetail->article_id);
		$category_id = $Article->category_id;
		$Comments = $Article->Comments;
		
		//$Comments = $article->comments(['article_id'=>$articleDetail->id])->get();
		return view('helpticket.member.kb.article-list.detail')->with('arti',$articleDetail)
				->with('category',Category::where('id', $category_id)->first())
				->with('category_id',$category_id)
				->with('user_details', $user_details)
				->with('categorys', $category->getCategories())
				->with('comments' , $Comments)
				->with('languages',$Article->ArticleLanguages);
	}

	public function getCategory($slug, Article $article, Category $category) { 
		/* get the article_id where category_id == current category */
		$Category = $category->where('slug', $slug)->first();
		$articles = $Category->Articles(['language_id'=>1,'status'=>1])
		->paginate(10);
		$articleArr = array();
		foreach ($articles as $art)
		{
			
			//if($art->totalLang > 1)
			$languages = $art->ArticleLanguages;
			$articleArr[] = (object)array(
					'article_id'=>$art->article_id,
					'name'=>$art->name,
					'totalLang'=>count($art->ArticleLanguages),
					'description'=>$art->description,
					'slug'=>$art->slug,
					'created_at'=>$art->created_at,
					'languages'=>$languages
			);
		}
		
		$Categories = $category->getCategories();
		$user_id = Auth::user()->id;
		$user_details = UserClass::getUserDetails($user_id);
		return view('helpticket.member.kb.article-list.category')
		->with('user_details', $user_details)
		->with('categorys', $Categories)
		->with('Category', $Category)
		->with('articles', $articleArr);
		
	}

	

	/**
	 * To insert the values to the comment table
	 * @param type Article $article
	 * @param type Request $request
	 * @param type Comment $comment
	 * @param type Id $id
	 * @return type response
	 */
	public function postComment($slug, ArticleDetail $articleDetail, CommentRequest $request, Comment $comment) {
		$article = $articleDetail->where('slug',$slug)->first();
		$id = $article->article_id;
		$comment->article_id = $id;
		$comment->article_detail_id = $article->id;
		$comment->status = 1;
		$comment->user_id = Auth::user()->id;
		if ($comment->fill($request->input())->save()) 
			$response = ['response' => 1,'message'=>Lang::get('helpdesk.text_success_comment')];
		else 
			$response = ['response' => 0,'message'=>Lang::get('error.error_action')];
		return Response::json ( $response );
	}

	
	
	

	public function getCategoryList(Article $article, Category $category) {
		//$Categories = $category->getCategories();
		$Categories = Category::all();
		$CatsData = array();
		foreach ($Categories as $cat)
		{
			/*$articles = Category::getCategoryArticles(['category_id'=>$cat->id])
			->where('status', 1)
			->where('type', 1)
			->get();*/
			$articles = $cat->Articles(['language_id'=>1,'status'=>1])
						->paginate(10);
			if($articles->total())
			$CatsData[] = (object)array(
						'name'=>$cat->name,'total'=>$articles->total(),
						'slug'=>$cat->slug,
						'articles'=>$articles
			);
		}
		$user_id = Auth::user()->id;
		$user_details = UserClass::getUserDetails($user_id);
		return view('helpticket.member.kb.article-list.Categories')
		->with('user_details', $user_details)
		->with('categorys',$category->get())
		->with('categories',$CatsData);

	}


}
