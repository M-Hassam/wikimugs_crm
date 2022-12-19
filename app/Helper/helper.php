<?php 

/**
* @return current route
*
**/
function currentRoute(){
	return Route::currentRouteName();
}

/**
* @param file to save file in storage $file
* @param directory to create directory in uploads folder  $dir
* @return file stored in directory
*
**/
function uploadFile($file, $dir)
{
	$directory = public_path().'/uploads/'.$dir;
	if(!is_dir($directory)){
		mkdir($directory,0777,true);
	}

	$extension = $file->getClientOriginalExtension();
	$file_name = rand(10000,99999).'-'.time().'.'.$extension;
	$file->move($directory, $file_name);
	return $file_name;
}

/**
* @param file for delete $file
* @param $dir to check imaage exists or not
* @return boolean true or false
*/
function deleteFile($file, $dir)
{
	if(is_file(public_path().'\\'.$dir.'\\'.$file)){
		unlink(public_path().'\\'.$dir.'\\'.$file);
		return true;
	}
	return false;
}

/**
* @param App\Models\Model $model
* @return int serial no of model $serial_no
*
**/
function getSerialNo($model)
{
	$serial_no = '1023561';
	$u_id = $model::orderBy('id','desc')->first(['id','serial_no']);
	if(isset($u_id->serial_no)){
		$serial_no = $u_id->serial_no+1;
	}
	return $serial_no;
}

/**
* @return formatted date
*
**/
function formattedDate($date){
	$f_date = !is_null($date) ? date('d-m-Y',strtotime($date)) : "---";
	return $f_date;
}

/**
* @return formatted date
*
**/
function formattedTimeDate($date){
	$f_date = !is_null($date) ? date('d-m-Y h:i:s',strtotime($date)) : "---";
	return $f_date;
}


?>