<?php

// Add a leading '/' if not present 
function url_for($script_path){
	if($script_path[0] !== '/'){
		$script_path = '/' . $script_path;
		
	}
	return WWW_ROOT . $script_path;

}

function h($string =''){
	return htmlspecialchars($string);
}
function u($string =''){
	return urlencode($string);
}


//Set the HTTP header for error request
function error_404(){
	return header($_SERVER['SERVER_PROTOCOL'] . '404 Not Found');
	exit();
}

function error_500(){
	return header($_SERVER['SERVER_PROTOCOL'] . '500 Internal Server Error');
	exit();
}

//Set redirects
function redirect_to($location){
	return header('Location: ' . $location);
	exit();
}

//returns bool for the request used to access a page
function request_is_post(){
	return $_SERVER['REQUEST_METHOD'] == 'POST' ;
}

function request_is_get(){
	return $_SERVER['REQUEST_METHOD'] == 'GET';
}

/* display_errors(array)
** returns output(string(html with errors))
*/
function display_errors($errors=[]) {
	$output = '';
	// var_dump($errors);
	if (!empty($errors)) {
		$output .= "<div class=\"errors\">Please fix the following errors.";
		$output .= "<ul>";
		foreach ($errors as $error) {
			$output .= "<li>" . h($error) . "</li>";
		}
		$output .= "</ul></div>";
	}
	return $output;
}

// Status messages
// function get_session_message() {
// 	if (isset($_SESSION['message']) && $_SESSION['message'] != '') {
// 		$msg = $_SESSION['message'];
// 		$_SESSION['message'] = '';

// 		return $msg;
// 	}
	
// }

function get_session_message() {

	if (isset($_SESSION['message']) && $_SESSION['message'] != '') {
		$msg = $_SESSION['message'];

		return $msg;
	}
}

// Display status message
function display_session_message() {
	$msg = get_session_message();
	if (!is_blank($msg)) {
		return '<div id="message">' . h($msg) . '</div>';
	}
}

//Delete session message
function clear_session_message() {
	unset($_SESSION['message']);
}



?>