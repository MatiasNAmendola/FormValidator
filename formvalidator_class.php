<?php
/*--------------------------------------------------------------------------
The base for this version of FormValidator class has originated from a tutorial :
http://www.melonfire.com/community/columns/trog/article.php?id=119
---------------------------------------------------------------------------------
This version of a FormValidator class is written by Petar Fedorovsky 30.05.2012
Please retain this credit when displaying this code online.
----------------------------------------------------------------------------*/

/* 
$fv->isEmpty("name", "Please enter a name"); 
$fv->isNumber("age","Please enter a valid age"); 
$fv->isWithinRange("age", "Please enter an age within the numeric range 1-99", 1, 99); 
$fv->isCharLenght("prezime", "Prezime must have between 2 and 30 characters.",2,30); 
$fv->isEmailAddress("email", "Please enter a valid e-mail.");
$fv->isAlpha("ime", "a name can only consist of letters."); 
$fv->isString
$fv->isEqual ('pass', 'repass', 'Your passwords do not match!');
$fv->isIntiger
$fv->isFloat
insertErrorList('Some message')//insert error in the list - used for custom checking instead of creating a new funtion
//to use batch check youre fieldnames bust have letter in their names; names cant be 1,2,3,4.
$fv->batchFields(array("filedesc", "filedesc2"), "isEmpty", "You must fill out required fields."); //isEmpty, isString, isNumber,isAlpha, isEmailAddress, isInteger, isFloat
$fv->batchFields(array("filedesc"=>"your message for the first field", "filedesc2"=>"your message for the second field"), "isEmpty", "You must fill out required fields.");
$fv->batchFields(array("realname" =>"u must insert a real name",
                       "username" =>"u must insert a username",
                       "email" =>"u must insert a  email"), "isEmpty", "You must fill out required fields.");
-------------------------------------------
USAGE EXAMPLE:
// include class
include("formvalidator_class.php");
// instantiate object
$fv = new FormValidator();
//set method
$fv->setMethod('post');
// perform validation
$fv->isEmpty("name", "Please enter a name"); 
$fv->isNumber("age","Please enter a valid age"); 
$fv->isWithinRange("age", "Please enter an age within the numeric range 1-99", 1, 99); 
//if u want to insert your own check after first round of checks have passed ok
if (!($fv->isError())){

if the fields passed previous checks preform your check
$fv->isEmailAddress("email", "Please enter a valid e-mail.");
}
//check if there are errors if there are, store them in the var. 
if ($fv->isError()){
$errors = $fv->getErrorList();
}else{
// do something useful with the data
echo "Data OK";
}
and now on a place where u want to echo the errors
if($errors){
echo "<ul>";
foreach ($errors as $e){
echo "<li>" . $e['msg'];
}   
echo "</ul>";
}else{
//display a sucess message to user
}
 */

//////////////////////////////////////
class FormValidator{
	// protected variables 
	protected $_errorList;
	protected $_method;
	// Constructor - reset error list
	function __construct(){
		$this->resetErrorList();
	}
	
 	protected function _getValue($field){
	if($this->_method == 'post'){
		$field = trim($_POST[$field]);
	}else{
		$field = trim($_GET[$field]);
	}
	return $field;
	} 

	//set get or post method
	function setMethod( $val){
	$this->_method = $val;
	}
	
	
	// reset the error list
	function resetErrorList(){
		$this->_errorList = array();
	}
	
        //returns true if all fields are intigers
        protected function isIndexed($array){
            $flag='';
            foreach ($array as $key => $v) {
                if(!(is_int($key))){
                    $flag = 1;
                }
                
            }
            if($flag == 1){
                    return FALSE;
                }else{
                    return TRUE;
                }
        }

        

        // return the current list of errors
	function getErrorList(){
		return $this->_errorList;
	}

	//insert error in the list
    //used for custom checking instead of creating a new funtion
        function insertErrorList($msg){
		$this->_errorList[] = array("msg" => $msg);
	}
	
	// check whether any errors have occurred in validation
	// returns Boolean
	function isError(){
		if (sizeof($this->_errorList) > 0){
			return true;
			}else{
			return false;
			}
	}

	//multi fields check
        function batchFields($fieldlist,$method, $msg=null){
            $er="";
            if(is_array($fieldlist)){
                if($this->isIndexed($fieldlist)){
                    foreach ($fieldlist as $value) {
                    if(($this->$method($value, "", TRUE ) == FALSE)){
                        $er = 1;
                    }
                }
                //message to user
                    if($er == 1){
                        $this->insertErrorList($msg);
                return FALSE;
                    }else{
                return TRUE;
                    }
                }else{
                    foreach ($fieldlist as $key => $value) {
                        if($this->$method($key, $value)){
                            $er = 1;
                        }
                    }
                    //message to user
                    if($er){                        
                        return FALSE;
                    }else{
                        return TRUE;
                    }
                }
                
                
            }
        }
	// check whether input is empty
	function isEmpty($field, $msg, $inner=FALSE){
		$value = $this->_getValue($field);
		if (trim($value) == ""){
                    if($inner==FALSE){
                        $this->_errorList[] = array("field" => $field,
		"value" => $value, "msg" => $msg);
		return false;
                    }else{
                        return false;
                    }
		
		}else{
		return true;
		}
	}
	// check whether input is a string
	function isString($field, $msg, $inner=FALSE){
		$value = $this->_getValue($field);
		if(!is_string($value)){
		 if($inner==FALSE){
                        $this->_errorList[] = array("field" => $field,
		"value" => $value, "msg" => $msg);
		return false;
                    }else{
                        return false;
                    }
		
		}else{
		return true;
		}
	}
	// check whether input is a number
	function isNumber($field, $msg, $inner=FALSE){
		$value = $this->_getValue($field);
		if(!is_numeric($value)){
		if($inner==FALSE){
                        $this->_errorList[] = array("field" => $field,
		"value" => $value, "msg" => $msg);
		return false;
                    }else{
                        return false;
                    }
		
		}else{
		return true;
		}
	}
	// check whether input is alphabetic
	function isAlpha($field, $msg, $inner=FALSE){
		$value = $this->_getValue($field);
		$pattern = "/^[a-zA-Z]+$/";
		if(preg_match($pattern, $value)){
		return true;
		}else{
		if($inner==FALSE){
                        $this->_errorList[] = array("field" => $field,
		"value" => $value, "msg" => $msg);
		return false;
                    }else{
                        return false;
                    }
		}
	}
	// check whether input is a valid email address
	function isEmailAddress($field, $msg, $inner=FALSE){
		$value = $this->_getValue($field);
		$pattern ="/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,4}$/";
		if(preg_match($pattern, $value)){
		return true;
		}else{
		if($inner==FALSE){
                        $this->_errorList[] = array("field" => $field,
		"value" => $value, "msg" => $msg);
		return false;
                    }else{
                        return false;
                    }
		}
	}
	//check if the character lenght is ok
	function isCharLenght($field, $msg, $min, $max){
		$value = $this->_getValue($field);
		if(strlen(trim($value))>$max || strlen(trim($value))<$min) {
			$this->_errorList[] = array("field" => $field, "value" => $value, "msg" => $msg);
			return false;
		}else{
		return true;
		}
	}
	//check if field1 is equal to field2
	function isEqual ($field1, $field2, $msg){
		$value1 = $this->_getValue($field1);
		$value2 = $this->_getValue($field2);
		//echo $value1;
		//echo $value2;
		if($value1 != $value2){
			$this->_errorList[] = array("field" => $field1, "value" => $value1, "msg" => $msg);
			return false;
		}else{
		return true;
		}
	}
	// check whether input is an integer
	function isInteger($field, $msg, $inner=FALSE){
		$value = $this->_getValue($field);
		if(!is_integer($value)){
		if($inner==FALSE){
                        $this->_errorList[] = array("field" => $field,
		"value" => $value, "msg" => $msg);
		return false;
                    }else{
                        return false;
                    }
		
		}else{
		return true;
		}
	}
	// check whether input is a float
	function isFloat($field, $msg, $inner=FALSE){
		$value = $this->_getValue($field);
		if(!is_float($value)){
		if($inner==FALSE){
                        $this->_errorList[] = array("field" => $field,
		"value" => $value, "msg" => $msg);
		return false;
                    }else{
                        return false;
                    }
		
		}else{
		return true;
		}
	}
	// check whether input is within a valid numeric range
	function isWithinRange($field, $msg, $min, $max){
		$value = $this->_getValue($field);
		if(!is_numeric($value) || $value < $min || $value >	$max){
		$this->_errorList[] = array("field" => $field,
		"value" => $value, "msg" => $msg);
		return false;
		}else{
		return true;
		}
	}

}
?>