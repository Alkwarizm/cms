<?php
ob_start(); //output buffering
session_start(); //turn on session

/* Defining paths(Directory) CONSTANTS
* dirname()-> returns the path to the parent directory
* __FILE__ returns the full path and filename of the file
*/
define('PRIVATE_PATH', dirname(__FILE__)); //returns dir private equivalent to __DIR__(full dir paths)
define('PROJECT_PATH', dirname(PRIVATE_PATH));	//returns dev.php
define('PUBLIC_PATH', PROJECT_PATH . '/public');
define('SHARED_PATH', PRIVATE_PATH . '/shared');

/* Assign URL to a php constant
*No need to add the domain
*
*/
$public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;//get the pos of the end of the 'public' in the URL to the current script.
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end); //get the URL to the public as a str
define('WWW_ROOT', $doc_root); //set webroot with public


require_once('functions.php');
require_once('database.php');
require 'validate_functions.php';
require 'query_functions.php';
require 'auth_functions.php';

$db = db_connect();
$errors = [];

 ?>