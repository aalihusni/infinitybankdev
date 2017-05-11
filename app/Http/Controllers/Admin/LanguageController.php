<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Input;
use Config;
use Validator;
use DB;
use Crypt;
use File;
use App\Settings;
use App\Model\Language;
use App\Model\LanguageTranslation;
use Response;
use App\User;
use App\Http\Requests\admin\LangTranslationRequest;
use App\Model\LanguageTranslationFiles;
use App\Http\Requests\admin\LanguageRequest;

class LanguageController extends Controller {
	
	private function list_files($mydirectory,$filetype) {
		// directory we want to scan
		$dircontents = scandir($mydirectory);
		// list the files
		$files = array();
		foreach ($dircontents as $file) {
			$extension = pathinfo($file, PATHINFO_EXTENSION);
			if ($extension == $filetype) {
				$files[] = $file;
			}
		}
		return $files;
	}
		
	public function index()
	{
		
		$dir    = base_path().'/resources/lang/en';
		
		$langFilesArr = $this->list_files($dir, 'php');
		$filesArr = array();
		$i=1;
		foreach($langFilesArr as $flist)
		{
			$filesArr[] = (object)['sn'=>$i,'filename'=>$flist];
			$i++;
		}
		return view('admin.system.language.index')
				->with('languages',Language::orderBy('sort_order','asc')->get())
		->with('fileList',$langFilesArr)
		->with('lists',$filesArr);
		
	}
	
	public function getDetail()
	{
		$id = Input::get('lang_id');
		$Language = Language::find($id);
		return Response::json(['id'=>$id,'name'=>$Language->name,'code'=>$Language->code,'status'=>$Language->status,
				'sort_order'=>$Language->sort_order,'image'=>$Language->image
		]);
	}
	
	public function postSaveLanguage(LanguageRequest $request)
	{
		$Language = Language::findOrNew($request->language_id);
		$Language->name = $request->name;
		$Language->image = $request->image;
		$Language->sort_order = $request->sort_order;
		$code = strtolower($request->code);
		if($request->language_id !=1){
			$Language->code = $code;
			$Language->status = $request->status;
		}
		$result = $Language->save();
		
		### CREATE LANGUAGE FOLDER AND ###
		/*
		if(!$request->language_id && $result){
			$newdir    = base_path().'/resources/lang/'.$code;
			$MainDir    = base_path().'/resources/lang/en';
			if (mkdir($newdir, 0755, true)) {
				$langFilesArr = $this->list_files($MainDir, 'php');
				foreach($langFilesArr as $fileName)
				{
					
					$fileDir = $newdir.'/'.$fileName;
					if (!File::exists($fileDir)){
						fopen($fileDir,"w");
						$srcfile= $MainDir.'/'.$fileName;
						$dstfile= $newdir.'/'.$fileName;
						copy($srcfile, $dstfile);
					}
				}
			}
		}*/
		### CREATE LANGUAGE FOLDER ###
		$response = [
				'response' => 1,
				'message' => 'Modified Successfully'
		];
		return Response::json ( $response );
	}
	
	public function getFileData($fileName,$langCode)
	{
		
		
		$file = Crypt::decrypt($fileName);
		//$file = $file.'.php';
		$filename = base_path()."/resources/lang/$langCode/$file";
		$folderPath = base_path()."/resources/lang/$langCode/";
		
		$dir    = base_path().'/resources/lang/en';
		$langFilesArr = $this->list_files($dir, 'php');
		
		$DataEng 	= File::getRequire(base_path().'/resources/lang/en/'.$file);
		$ca = File::getRequire(base_path().'/resources/lang/cn/auth.php');
		//$languages = File::directories(base_path().'/resources/lang/'); ### LOAD ALL DIRECTORY
		foreach($DataEng as $key => $value)
		{
			//echo $key.' VAL '.$value.'<br>';
			//if(key_exists($key, $ca))
			//echo 'EN '.$key.' CN'.$ca[$key].'<br>';
				//else echo 'EN '.$key.' CN<br>';
			//echo "$key => $value<br>";
		}
		//chmod($folderPath, 0777);
		$SelLangData = array();
		if (File::exists($filename))
		{
			$SelLangData 	= File::getRequire($filename);
		}
		return view('admin.system.language.viewfile')
		->with('languages',Language::all())
		->with('mainData',$DataEng)
		->with('selLangData',$SelLangData)
		->with('langCode',$langCode)
		->with('fileName',$file)
		->with('LangDetail',Language::where(['code'=>$langCode])->first());
		
		
		
	}
	
	public function postFileData(Request $request)
	{
		$langCode =  $request->code;
		$validateCode = Language::where(['code'=>$langCode])->first();
		if($validateCode){
			$text =  "<?php \n return [\n";
			$fileName =  $request->fileName;
			$langData = $request->langData;
			$filename = base_path()."/resources/lang/$langCode/$fileName";
			if (!File::exists($filename))
			{
				$file = fopen($filename,"w");
			}
			$text .= $langData;
			$text .=  "\n]\n?>";
			$fh = fopen($filename, 'w');
			fwrite($fh, "");
			file_put_contents($filename, $text, FILE_APPEND);
		}
	}
	
	public function translationRequest(LanguageTranslation $langTrans)
	{
		
		
		$langArr = array();
		$allData = array();
		$i =1;
		foreach (Language::where('id','>',1)->orderBy('sort_order','asc')->get() as $lang)
		{
			$langArr[]=$lang;
			$langTransReqs = $lang->LanguageTranslationRequest;
			
			$lists = array();
			foreach ($langTransReqs as $list)
			{
				$files = explode(',', $list->files);
				
				foreach ($files as $file)
				{
					$hasRecord = 1;
					$translationStatus = LanguageTranslationFiles::where(['language_translation_id'=>$list->id,'file_name'=>$file])->pluck('status');
					if(is_null($translationStatus))
					{
						$translationStatus = 0;
						$hasRecord = 0;
					}
					
					if($translationStatus==2)
						$css = 'success';
					elseif($translationStatus==1)
						$css = 'warning';
					elseif($translationStatus==3)
						$css = 'danger';
					elseif($translationStatus==4)
						$css = 'danger';
					else $css = 'info';
					
					$lists[] = (object)array('id'=>$list->id,'filename'=>$file,'status'=>$list->status,'alias'=>$list->alias,
							'user_id'=>$list->user_id,'code'=>$list->code,'translationStatus'=>Config::get('settings.translationStaus')[$translationStatus],
							'name'=>$list->name,'language_id'=>$list->language_id,'image'=>$list->image,'created_at'=>$list->created_at,
							'cssname'=>$css,'hasRecord'=>$hasRecord
					);
				}
			}
			$allData[] = (object)['langDetail'=>$lang,'lists'=>$lists,'sn'=>$i];
			$i++;
		}
		
		$dir    = base_path().'/resources/lang/en';
		$langFilesArr = $this->list_files($dir, 'php');
		$filesArr = array();
		$i=1;
		foreach($langFilesArr as $flist)
		{
			if($flist == 'validation.php')
				continue;
			$filesArr[] = (object)['sn'=>$i,'filename'=>$flist];
		}
		
			
		$lists = $langTrans->getAll();
		return view('admin.system.language.requests')
		->with('langFiles',array_chunk($filesArr, 5))
		->with('languages',array_chunk($langArr,4))
		->with('AllLists',$allData)
		->with('lists',$lists);
	}
	public function getDetailTransRequest($fileName,$id)
	{
	
			$RowDetail = LanguageTranslation::where(['id'=>$id])->first();
			$file = Crypt::decrypt($fileName);
			$php_file = $file;
			$MainFilename = base_path()."/resources/lang/en/$php_file";
			
			$textMainData = "";
			foreach (file($MainFilename) as $lineTxt)
			{
					$textMainData .= $lineTxt . "<br>";
			}
			$status = 0;
			$PreviousRecord = LanguageTranslationFiles::where(['language_translation_id'=>$id,'file_name'=>$file])->first();
			$langDetail = Language::find($RowDetail->language_id);
			if($PreviousRecord) {
				$translatedData = $PreviousRecord->trans_data;
				$status = $PreviousRecord->status;
				$translatedData = unserialize($PreviousRecord->trans_data);
				$lines = "##### File Directory resources/lang/".$langDetail->code."/".$file."  #####"."\n\n";
				foreach( $translatedData as $index => $line )
				{
					$lines .= "'$index'". "=>". "\"".$line."\",". "\n";
				}
				$translatedData = $lines;
			}
			
			return view('admin.system.language.transdetail')
			->with('mainData',$textMainData)
			->with('translatedData',$translatedData)
			->with('RowDetail',$RowDetail)
			->with('fileName',$fileName)
			->with('status',$status)
			->with('successMsg',trans('header.text_success'))
			->with('LangDetail',$langDetail);
	
	
	
	}
	
	
	public function updateTransFile()
	{
	
		$fileName = Input::get('fileName');
		$id = Input::get('serial_number');
		$staus = Input::get('status');
		$fileName = Crypt::decrypt($fileName);
		$Row = LanguageTranslationFiles::where(['language_translation_id'=>$id,'file_name'=>"$fileName"])->first();
	
		$RowDetail = LanguageTranslation::where(['id'=>$id])->first();
		$langDetail = Language::find($RowDetail->language_id);
		
	
		if($Row) {
			$Row->status = Input::get('status');
				/*
			if($staus==3){
					
				$translatedData = unserialize($Row->trans_data);
				$lines = "\n";
				foreach( $translatedData as $index => $line )
				{
					$lines .= "'$index'". " => ". "\"".$line."\"". ",\n";
				}
	
				$LangDir    = base_path().'/resources/lang/'.$langDetail->code;
				//$dir_writable = substr(sprintf('%o', fileperms($LangDir)), -4); ### FILE PERMISSION ####
	
				$fileDir = $LangDir.'/'.$Row->file_name;
				if (!File::exists($fileDir)){
					fopen($fileDir,"w");
				}
	
				$text =  "<?php \n return [\n";
				$text .= $lines;
				$text .=  "\n];\n?>";
				file_put_contents($fileDir, $text);
					
			} */
			$Row->save();
		}
		$response = [
				'response' => 1,
				'message' => sprintf(trans('header.text_success'),' File'),
		];
		return Response::json ( $response );
	
	}
	
	
	public function postLangTranslationReq(LangTranslationRequest $request)
	{
		$User = User::find ( Input::get ( 'filter_id' ) );
		$language_id = Input::get('language_id');
		$LanguageTranslation = LanguageTranslation::hasRecords(['user_id'=>$User->id,'status'=>[0,1],'language_id'=>$language_id]);
		$lang_files = implode(',', Input::get('lang_files'));
		if($LanguageTranslation)
		{
		}else{
			$LanguageTranslation = new LanguageTranslation();
			$LanguageTranslation->language_id = $language_id;
			$LanguageTranslation->user_id =  Input::get ( 'filter_id' );
		}
		$LanguageTranslation->files = $lang_files;
		$id = $LanguageTranslation->save();
		
		$response = [
				'response' => 1,
				'message' => 'Added Successfully'
		];
		return Response::json ( $response );
	}
}	
