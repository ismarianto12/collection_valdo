<?php
class Error extends Controller{
	
	function __construct(){
		parent::Controller();
	}
	
	function index(){
		echo "Javascript Engine is not Loaded, Please check u'r browser setting!! <br/>";
		die("Contact Your System Administrator if you Don't Understand how to get rid this error");
	}
}
?>