<?php namespace App\Http\Controllers\Member\helpdesk\Admin;

// Controllers
use App\Http\Controllers\Member\kb\UserController;
use App\Http\Controllers\Controller;

// Requests
use App\Http\Requests\kb\CategoryRequest;
use App\Http\Requests\kb\CategoryUpdate;

// Model
use App\Model\kb\Category;
use Auth;
use App\Classes\UserClass;
use Lang;
use Response;
// Classes
use Datatable;
use Redirect;
use Exception;
use App\Model\kb\Article;

/**
 * CategoryController
 * This controller is used to CRUD category 
 *
 * @package 	Controllers
 * @subpackage 	Controller
 * @author     	Cara <kamal@cara.com.my>
 */
class CategoryController extends Controller {

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
		// checking roles
		$this->middleware('admin', ['except' => 'quick_login']);
		
	}

	/**
	 * Indexing all Category
	 * @param type Category $category
	 * @return Response
	 */
	public function index(Category $category) {
		/*  get the view of index of the catogorys with all attributes
		of category model  */
		$user_id = Auth::user()->id;
		$user_details = UserClass::getUserDetails($user_id);
		return view('helpticket.admin.category.index')
		->with('user_details', $user_details)
		->with('categories', $category->get());
		
	}

	/**
	 * Create a Category
	 * @param type Category $category
	 * @return type view
	 */
	public function create(Category $category) {
		$user_id = Auth::user()->id;
		$user_details = UserClass::getUserDetails($user_id);
		/* Get the all attributes in the category model */
		return view('helpticket.admin.category.create')
		->with('user_details', $user_details)
		->with('categories', $category->get());
		
	}

	

	/**
	 * Show the form for editing the specified category.
	 * @param type $slug 
	 * @param type Category $category 
	 * @return type view
	 */
	public function edit($slug, Category $category) {
		// fetch the category
		$cid = $category->where('id', $slug)->first();
		$id = $cid->id;
		/* get the atributes of the category model whose id == $id */
		$category = $category->whereId($id)->first();
		$user_id = Auth::user()->id;
		$user_details = UserClass::getUserDetails($user_id);
		/* get the Edit page the selected category via id */
		return view('helpticket.admin.category.edit', compact('category'))
		->with('user_details', $user_details);
	}

	

	

}
