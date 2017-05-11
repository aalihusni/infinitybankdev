<?php namespace App\Http\Controllers\Member\Manage\kb;

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
		return view('helpticket.manage.kb.category.index')
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
		
		return view('helpticket.manage.kb.category.create')
		->with('user_details', $user_details)
		->with('categories', $category->get());
		
	}

	/**
	 * To store the selected category
	 * @param type Category $category 
	 * @param type CategoryRequest $request 
	 * @return type Redirect
	 */
	public function store(Category $category, CategoryRequest $request) {
		
		/* Get the whole request from the form and insert into table via model */
		$sl = $request->input('slug');
		$slug = str_slug($sl, "-");
		$category->slug = $slug;
		$category->added_by = Auth::user()->id;
		// send success message to index page
		try{
			$category->fill($request->except('slug'))->save();
			$response = ['response' => 1,'message'=>'Category Inserted Successfully'];
		} catch(Exception $e) {
			$response = ['response' => 0,'message'=>'Category Not Inserted'.'<li>'.$e->errorInfo[2].'</li>'];
		}
		return Response::json ( $response );
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
		return view('helpticket.manage.kb.category.edit', compact('category'))
		->with('user_details', $user_details);
	}

	/**
	 * Update the specified Category in storage.
	 * @param type $slug 
	 * @param type Category $category 
	 * @param type CategoryUpdate $request 
	 * @return type redirect
	 */
	public function update($slug, Category $category, CategoryUpdate $request) {
		/* Edit the selected category via id */
		$category = $category->where('id', $slug)->first();
		$sl = $request->input('slug');
		$slug = str_slug($sl, "-");
		$category->slug = $slug;
		/* update the values at the table via model according with the request */
		//redirct to index page with success message
		try{
			$category->fill($request->all())->save();
			$category->slug = $slug;
			$category->save();
			$response = ['response' => 1,'message'=>'Category Updated Successfully'];
		} catch(Exception $e) {
			$response = ['response' => 0,'message'=>'Category Not Updated'.'<li>'.$e->errorInfo[2].'</li>'];
		}
		return Response::json ( $response );
	}

	/**
	 * Remove the specified category from storage.
	 * @param type $id 
	 * @param type Category $category 
	 * @param type Relationship $relation 
	 * @return type Redirect
	 */
	public function destroy(Category $category,Article $article) {
		$id = $_POST['category_id'];
		$hasRecord = $article->where('category_id', $id)->count();
		if($hasRecord){
			$response = ['response' => 0,'errors' => array('custom_message'=>'Category Not Deleted')];
		}
		else {
			/*  delete the category selected, id == $id */
			$category = $category->whereId($id)->first();
			// redirect to index with success message
			try{
				$category->delete();
				$response = ['response' => 1,'message'=>'Category Deleted Successfully'];
			} catch(Exception $e){
				$response = ['response' => 0,'errors' => array('custom_message'=>'Category Not Deleted'.'<li>'.$e->errorInfo[2].'</li>')];
			}			
		}
		return Response::json ( $response );
	}

}
