<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Input;
use Config;
use Validator;
use DB;
use Crypt;
use File;
use Auth;
use App\Model\Language;
use App\Model\LanguageTranslation;
use Response;
use App\User;
use Redirect;
use App\Model\LanguageTranslationFiles;
class LanguageTranslationController extends Controller {
		
	public function index(LanguageTranslation $langTranslation)
	{
		
		$PendingRequests = $langTranslation->getMembersRequestList(['user_id'=>Auth::user()->id,'status'=>[0,1]]);
		$lists = array();
		foreach ($PendingRequests as $list)
		{
			$status = $list->status == 0 ? 'Pending' : 'Waiting For Approval';
			
			$files = explode(',', $list->files);
			$i=1;
			foreach ($files as $file)
			{
				$translationStatus = LanguageTranslationFiles::where(['language_translation_id'=>$list->id,'file_name'=>$file])->pluck('status');
				if(is_null($translationStatus))
					$translationStatus = 0;
				if($translationStatus==2)
					$css = 'success';
					elseif($translationStatus==1)
					$css = 'warning';
					elseif($translationStatus==3)
					$css = 'danger';
					elseif($translationStatus==4)
					$css = 'danger';
					else $css = 'info';
				
				$lists[] = (object)array('id'=>$list->id,'filename'=>$file,'snnumber'=>$i,'status'=>$status,
						'translationStatus'=>Config::get('settings.translationStaus')[$translationStatus],
						'languagetitle'=>$list->name,'language_id'=>$list->language_id,'image'=>$list->image,'cssname'=>$css
				);
				$i++;
			}
		}
		return view('member.language.index')
				->with('languages',Language::all())
		->with('fileList',$lists);
		
	}
	
	public function getFileData($fileName,$id)
	{
		
		$RowDetail = LanguageTranslation::where(['id'=>$id,'user_id'=>Auth::user()->id])->first();
		if(is_null($RowDetail))
		return Redirect::back()->withErrors("Permission Denied!");
		$file = Crypt::decrypt($fileName);
		//$php_file = $file.'.php';
		$php_file = $file;
		$MainFilename = base_path()."/resources/lang/en/$php_file";
		$langDetail = Language::find($RowDetail->language_id);
		
		$status = 0;
		$prevFileData = array();
		$PreviousRecord = LanguageTranslationFiles::where(['language_translation_id'=>$id,'file_name'=>$file])->first();
		if($PreviousRecord){
			$prevFileData = unserialize($PreviousRecord->trans_data);
			$status = $PreviousRecord->status;
		}
		else {
			### CHECK WETHE THE SELECTED LANGUAGE FILE EXIST if exits read #####
			$SelLangFile = base_path()."/resources/lang/".$langDetail->code."/$php_file";
			if(file_exists($SelLangFile)){
				$SelLangFileData 	= File::getRequire($SelLangFile);
				$prevFileData = $SelLangFileData;
			}
		}
		$DataEng 	= File::getRequire($MainFilename); ### ENGLISH DATA #####
		return view('member.language.translateeditor')
		->with('engData',$DataEng)
		->with('selLangData',$prevFileData)
		->with('fileName',$file)
		->with('RowDetail',$RowDetail)
		->with('fileName',$fileName)
		->with('status',$status)
		->with('successMsg',trans('header.text_success'))
		->with('LangDetail',$langDetail);
		
		
		
	}
	
	public function postFileData(Request $request)
	{
		
		
		$form_data = $request->except('_token','fileName','serial_number','status');
		$id = Input::get('serial_number');
		$RowDetail = LanguageTranslation::where(['id'=>$id,'user_id'=>Auth::user()->id])->first();
		$file_name = Crypt::decrypt(Input::get('fileName'));
		$LangTransFiles = new LanguageTranslationFiles();
		$PreviousRecord = LanguageTranslationFiles::where(['language_translation_id'=>$id,'file_name'=>$file_name])->first();
		if($PreviousRecord)
			$LangTransFiles = $PreviousRecord;
		
		$LangTransFiles->trans_data = serialize($form_data);
		$LangTransFiles->status = $request->status;
		if(!is_null($RowDetail)){ 
			$LangTransFiles->language_translation_id = $id;
			$LangTransFiles->file_name = $file_name;
			$LangTransFiles->save();
		}
		$response = [
				'response' => 1,
				'message' => sprintf(trans('header.text_success'),' File'),
		];
		return Response::json ( $response );
	}
	
	
	
}	
