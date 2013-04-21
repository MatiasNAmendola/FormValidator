<?php
//dependencies
require_once 'formvalidator_class.php';
/* ------INITIALIZATION--------
// include class
include("file_upload_validation.php");
// instantiate object
$fuv = new FileUploadValidator();
//method is automaticly set to post, but u can set it to get using setMethod() property NOTE: image checking functions will not work as it is imposible to upload a file using get.
$fuv->noFile("upload_field_name", "Please select a file before upload"); //checks if there is a file in the temp dir
$size= 5*1048576;//size of a file in MB
$fuv->isSize("upload_field_name", $size, "file size(bytes) is to big");// checks if the size is ok
$fuv->isType("upload_field_name", 'gif|jpg|png', "wrong file type"); //checks if the file of the right type is uploaded use| (pipe) as a delimiter
$fuv->noError("upload_field_name", "There was an error during the file upload process, try again later. If the error persists, contact the webmaster."); // checks if the upload has been sucessfull.
*/
class FileUploadValidator extends FormValidator{
    
    //constructor class
    function __construct(){
		parent::__construct();
        $this->setMethod('post');
	}
	
	function _getValue($field, $subfield=NULL){
		if($this->_method == 'post'){
			if($subfield==NULL){
						$field = $_POST[$field];
					   }else{
						$field = $_FILES[$field][$subfield];
					}   
		}else{
			$field = $_GET[$field];
		}
		return $field;
	} 
    
    protected function _removeTmpFile($field,$subfield){
        if(file_exists($subfield)){
            unlink($_FILES[$field][$subfield]);
        }
    }
    function noFile($field, $msg){
        $value = $this->_getValue($field,'tmp_name');
		if (!$value){
		$this->_errorList[] = array("field" => $field,
		"value" => $value, "msg" => $msg);
		return false;
		}else{
		return true;
		}
        
    }
    //1MB = 1048576 bytes
    function isSize($field, $size, $msg){
        $value = $this->_getValue($field,'size');
		if ($value > $size){
		$this->_errorList[] = array("field" => $field,
		"value" => $value, "msg" => $msg);
                $this->_removeTmpFile($field, 'tmp_name');
		return false;
		}else{
		return true;
		}
        }    
     //mozda napraviti check dali fajl postoji prije micanja
        function isType($field, $type, $msg){
        $value = $this->_getValue($field,'name');
        if (!preg_match("/.(".$type.")$/i", $value)){
		$this->_errorList[] = array("field" => $field,
		"value" => $value, "msg" => $msg);
                $this->_removeTmpFile($field, 'tmp_name');
		return false;
		}else{
		return true;
		}
        }  
        
     function noError($field, $msg){
        $value = $this->_getValue($field,'error');
		if ($value != 0){
		$this->_errorList[] = array("field" => $field,
		"value" => $value, "msg" => $msg);
		return false;
		}else{
		return true;
		}   
     }

}
?>
