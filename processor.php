<?php
echo '<pre>';
print_r($_POST);
echo '</pre>';
// include class
include("formvalidator_class.php");
// instantiate object
$fv = new FormValidator();
// perform validation
$fv->isEmpty("name", "Please enter a name"); 
$fv->isCharLenght("name", "Name must be between 2 and 10 characters",2,10);
$fv->isEmpty("nameb", "Please enter a name2"); 
$fv->isEqual("nameb","name","nameb is not equal to name");
$fv->isNumber("age","Please enter a valid age"); 
$fv->isWithinRange("age", "Please enter an age within the numeric range 1-99", 1, 99); 
$fv->isEmpty("sex", "Please enter your sex"); 
$fv->isEmpty("stype", "Please select one of the listed sandwich types"); 
$fv->isEmpty("sfill", "Please select one or more of the listed sandwich fillings");
if ($fv->isError()){
$errors = $fv->getErrorList();
echo "<b>The operation could not be performed because one or
more error(s) occurred.</b> <p> Please resubmit the form after making
the following changes:";
echo "<ul>";
foreach ($errors as $e){
echo "<li>" . $e['msg'];
}
echo "</ul>";
}else{
// do something useful with the data
echo "Data OK";
}
?>
