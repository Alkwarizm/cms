<?php 

	//prevent sql injection
	function escape_string($data) {

	}

	//find all subjects
	//options[] to filter 
	function find_all_subjects($options=[]){
		global $db;
		//$visible = $options['visible'] ?? 'false'; //double coalesce operator PHP 7
		$visible = isset($options['visible']) ? $options['visible'] : 'false';

		$sql = "SELECT * FROM subjects ";
		if ($visible=='true') {
			$sql .= "WHERE visible=true ";
		}
		$sql .= "ORDER BY position ASC";
		$results = mysqli_query($db,$sql);
		// echo $sql . '<br/>';
		confirm_query_result($results);

		return $results;
	}

	//find all pages
	function find_all_pages(){
		global $db;

		$sql = "SELECT * FROM pages ";
		$sql .= "ORDER BY id ASC"; //ORDER BY subject_id ASC, position ASC;

		$results = mysqli_query($db,$sql);
		// echo $sql . '<br/>';
		confirm_query_result($results);
		return $results;
	}

	//find a single record
	//options[] to filter
	function find_subject_by_id($id, $options=[]){
		global $db;
		$visible = isset($options['visible']) ? $options['visible'] : 'false' ;
		$sql = "SELECT * FROM subjects ";
		$sql .= "WHERE id='" . db_escape($db,$id) . "' ";
		if ($visible === true) {
			$sql .= "AND visible=true";
		}
		$result = mysqli_query($db,$sql);
		$record = mysqli_fetch_assoc($result);
		mysqli_free_result($result);

		return $record;

	}
	//find a single record
	//options[] to filter
	function find_page_by_id($id, $options=[]){
		global $db;
		$visible = isset($options['visible']) ? $options['visible'] : 'false' ;

		$sql = "SELECT * FROM pages ";
		$sql .= "WHERE id='" . db_escape($db,$id) . "' ";
		if ($visible === true) {
			$sql .= "AND visible=true";
		}
		$result = mysqli_query($db, $sql);
		$record = mysqli_fetch_assoc($result);
		mysqli_free_result($result);

		return $record;
	}

	//find all pages with a particular subject_id
	function find_pages_by_subject_id($id, $options=[]){
		global $db;
		//$visible = $options['visible'] ?? 'false';
		$visible = isset($options['visible']) ? $options['visible'] : 'false';
		$sql = "SELECT * FROM pages ";
		$sql .= "WHERE subject_id='" . db_escape($db, $id) . "' ";
		if ($visible == 'true') {
			$sql .= "AND visible=true "; 
		}
		$sql .= "ORDER BY position ASC";
		$result = mysqli_query($db, $sql);
		confirm_query_result($result);

		return $result;
	}

	function count_pages_by_subject_id($id){
		global $db;
		//$visible = $options['visible'] ?? 'false';
		$visible = isset($options['visible']) ? $options['visible'] : 'false';
		$sql = "SELECT COUNT(id) FROM pages ";
		$sql .= "WHERE subject_id='" . db_escape($db, $id) . "' ";
		if ($visible == 'true') {
			$sql .= "AND visible=true "; 
		}
		$sql .= "ORDER BY position ASC";
		$result = mysqli_query($db, $sql);
		confirm_query_result($result);
		$row = mysqli_fetch_row($result);
		mysqli_free_result($result);
		$count = $row[0];

		return $count;
	}

	/* validate_subject($assoc_array[])
	** returns errors[]
	*/
	function validate_subject($subject){
		$errors = [];

		//menu name must not be blank and between 2 and 255 characters
		if (is_blank($subject['menu_name'])) {
			$errors[] = 'Name cannot be blank.';

		} elseif (!has_length($subject['menu_name'], ['min' => '2', 'max' => '255'])) {
			$errors[] = 'Name must be between 2 and 255 characters.';
		}

		/* position must be an integer
		** Must be a non-zero value
		*/
		$position_int = (int) $subject['position'];
		if ($position_int <= 0) {
			$errors[] = 'Position must be greater than zero.';
		}
		if ($position_int > 999) {
			$errors[] = 'Position must be less than 999.';
		}

		//visible must be true or false and a string
		$visible_str = (string) $subject['visible'];
		if (!has_inclusion_of($visible_str, ["0", "1"])) {
			$errors[] = 'Visible must be true or false.';
		}

		return $errors;
	}

	//insert subject
	function insert_subject($subject){
		global $db;

		//validate the input
		$errors = validate_subject($subject);
		//return the errors if there are any
		if (!empty($errors)) {
			return $errors;
		}

		shift_subject_positions(0, $subject['position']);

		$sql = "INSERT INTO subjects ";
		$sql .= "(menu_name,position,visible) ";
		$sql .= "VALUES (";
		$sql .= "'". db_escape($db, $subject['menu_name']) . "',";
		$sql .= "'". db_escape($db, $subject['position']) . "',";
		$sql .= "'". db_escape($db, $subject['visible']) . "'";
		$sql .= ")";

		//INSERT statements returns true/false
		$result = mysqli_query($db,$sql);
		if ($result) {
			return true;
		} else{
			echo mysqli_error($db);
			db_disconnect($db);
			exit;
		}
	}

	//update a subject
	function update_subject($subject){
		global $db;

		//validate the input
		$errors = validate_subject($subject);
		//return the errors if there are any
		if (!empty($errors)) {
			return $errors;
		}

		$old_subject = find_subject_by_id($subject['id']);
		$old_position = $old_subject['position'];
		shift_subject_positions($old_position, $subject['position'], $subject['id']);

		$sql = "UPDATE subjects SET ";
		$sql .= "menu_name='" . db_escape($db, $subject['menu_name']) . "',";
		$sql .= "position='" . db_escape($db, $subject['position']) . "',";
		$sql .= "visible='" . db_escape($db, $subject['visible']) . "' ";
		$sql .= "WHERE id='" . db_escape($db, $subject['id']) . "' ";
		$sql .= "LIMIT 1";
		// echo $sql;
		$result = mysqli_query($db,$sql);
		//UPDATE statements returns true/false
		if ($result) {
			return true;
		} 
		//UPDATE failed
		else {

			echo mysqli_error($db);
			db_disconnect($db);
			exit();
		}
	}
	//delete a subject
	function delete_subject($id){
		global $db;

		$old_subject = find_subject_by_id($id);
		$old_position = $old_subject['position'];
		shift_subject_positions($old_position, 0, $id);

		$sql = "DELETE FROM subjects ";
		$sql .= "WHERE id='" . db_escape($db, $id) . "' ";
		$sql .= "LIMIT 1";

		// echo $sql;
		$result = mysqli_query($db, $sql);

		if ($result) {
			return true;
		} else {
			echo mysqli_error($db);
			db_disconnect($db);
			exit;
		}
	}


	/* has_unique_page_name($assoc_array)
	** returns bool, true if unique, false if not
	*/
	function has_unique_page_name($menu_name, $current_id="0") {
		global $db;

		//handling edits, check for id

			$sql = "SELECT * FROM pages ";
			$sql .= "WHERE menu_name='" . db_escape($db, $menu_name) . "' AND ";
			$sql .= "id !='" . db_escape($db, $current_id) . "'";
			$result = mysqli_query($db, $sql);
			$page_count = mysqli_num_rows($result);
			mysqli_free_result($result);

			return $page_count === 0;
			
	}

	/* validate_page($assoc_array[])
	** returns errors
	*/
	function validate_page($page) {
		$errors = [];

		//menu name cannot be blank, contain between 2 and 255 characters
		//menu name must be unique
		if (!has_presence($page['menu_name'])) {
			$errors[] = "Name cannot be blank.";

		}elseif (!has_length($page['menu_name'], ['min' => '2'])) {
			$errors[] = "Name must be between 2 and 255 characters.";
		}

		//check for page uniqueness
		$current_id = isset($page['id']) ? $page['id'] : '0';
		if (!has_unique_page_name($page['menu_name'], $current_id)) {
			$errors[] = "The Name already exists. Use a different name.";
		}


		//position must be int and between 0 and 999
		$position_int = (int) $page['position'];
		if ($position_int <= 0) {
			$errors[] = "Position must be greater than zero.";
		}elseif ($position_int > 999) {
			$errors[] = "Position must not be greater than 999.";
		}

		//visible must true / false
		$visible_str = (string) $page['visible'];
		if (has_exclusion_of($visible_str, ["0", "1"])) {
			$errors[] = "Visible must be true or false.";
		}
		//content
		if (is_blank($page['content'])) {
			$errors[] = "Content cannot be blank.";
		}

		

		return $errors;

	}

	//insert page
	//returns errors[] or true
	function insert_page($page){
		global $db;

		//validate the $page data
		$errors = validate_page($page);
		if (!empty($errors)) {
			return $errors;
		}

		shift_page_positions(0, $page['position'], $page['subject_id']);

		$sql = "INSERT INTO pages ";
		$sql .= "(subject_id,menu_name,position,visible,content) ";
		$sql .= "VALUES (";
		$sql .= "'" . db_escape($db, $page['subject_id']) . "', ";
		$sql .= "'". db_escape($db, $page['menu_name']) . "', ";
		$sql .= "'". db_escape($db, $page['position']) . "', ";
		$sql .= "'". db_escape($db, $page['visible']) . "', ";
		$sql .= "'". db_escape($db, $page['content']) . "' ";
		$sql .= ")";
		$result = mysqli_query($db, $sql);

		if ($result) {

			return true;

		} else {
			echo mysqli_error($db);
			db_disconnect($db);
			exit;
		}
	}

	//update a page
	function update_page($page){
		global $db;

		//validate the $page data
		$errors = validate_page($page);
		if (!empty($errors)) {
			return $errors;
		}
		$old_page = find_page_by_id($page['id']);
		$old_position = $old_page['position'];
		shift_page_positions($old_position, $page['position'], $page['subject_id'], $page['id']);
		
		$sql = "UPDATE pages SET ";
		$sql .= "subject_id='" . db_escape($db, $page['subject_id']) . "', ";
		$sql .= "menu_name='" . db_escape($db, $page['menu_name']) . "', ";
		$sql .= "position='" . db_escape($db, $page['position']) . "', ";
		$sql .= "visible='" . db_escape($db, $page['visible']) . "', ";
		$sql .= "content='" . db_escape($db, $page['content']) . "' ";
		$sql .= "WHERE id='" . db_escape($db, $page['id']). "' ";
		$sql .= "LIMIT 1";
		// echo $sql;

		$result = mysqli_query($db, $sql);

		if ($result) {
			return true;
		} else {
			echo mysqli_error($db);
			db_disconnect($db);
			exit;
		}
	}

	//delete a page
	function delete_page($id){
		global $db;
		$old_page = find_page_by_id($id);
		$old_position = $old_page['position'];
		shift_page_positions($old_position, 0, $old_page['subject_id'], $id);
		$sql = "DELETE FROM pages ";
		$sql .= "WHERE id='". db_escape($db, $id) ."' ";
		$sql .= "LIMIT 1";
		$result = mysqli_query($db, $sql);

		if ($result) {
			return true;
		} else {
			echo mysqli_error($db);
			db_disconnect($db);
			exit;
		}
	}

	//handle query errors
	function confirm_query_result($results){
		if (!$results) {
			$msg = "Database query failed.";
			exit($msg);
		}
	}

	/* Admin Queries
	** CRUD
	*/


	//Validate user details
	// options to allow updating password if user set it
	function validate_user_data($user, $options=[]) {
		$errors = [];
		$password_required = $options['password_required'] ?? true;//PHP 7 null coalesce

		//first name cannot be blank, 2-255 chars
		if (is_blank($user['first_name'])) {
			$errors[] = 'First name cannot be blank';
		}
		elseif (!has_length($user['first_name'], ['min' => '2'])) {
			$errors[] = "First name must be between 2 and 255 characters";
		}

		//last name cannot be blank, 2-255 characters
		if (is_blank($user['last_name'])) {
			$errors[] = 'Last name cannot be blank';
		}
		elseif (!has_length($user['last_name'], ['min' => '2', 'max' => '255'])) {
			$errors[] = "Last name must be between 2 and 255 characters";
		}

		//email cannot be blank, must have valid format
		if (is_blank($user['email'])) {
			$errors[] = 'Email cannot be blank';
		}
		elseif (!has_length($user['email'], ['max' => '255'])) {
			$errors[] = 'Email cannot exceed 255 characters';
		}
		elseif (!has_valid_email_format($user['email'])) {
			$errors[] = 'Email must have a valid format, nobody@where.com';
		}

		//username cannot be blank, must be unique and between 8 and 255 characters
		if (is_blank($user['username'])) {
			$errors[] = 'Username cannot be blank';
		}
		elseif (!has_length($user['username'], ['min' => '8', 'max' => '255'])) {
			$errors[] = 'Username must be between 8 and 255 characters';
		}
		elseif (has_length($user['username'], ['min' => '8'])) {
			$user_id = isset($user['id'])? $user['id'] : '0';
			if (!has_unique_username($user['username'], $user_id)) {
				$errors[] = 'Username already taken';
			}
		}

		if ($password_required === true) {
			//Password not blank, must have valid format
			if (is_blank($user['password'])) {
				$errors[] = 'Password cannot be blank';
			}
			elseif (is_blank($user['conf_password'])) {
				$errors[] = 'Confirm password cannot be blank';
			}
			elseif (!has_length($user['password'], ['min' => '12'])) {
				$errors[] = 'Password must contain atleast 12 characters';
			}
			elseif (!preg_match('/[A-Z]/', $user['password'])) {
				$errors[] = 'Password must contain at least 1 uppercase, 1 lowercase, 1 symbol and a number';
			}
			elseif (!preg_match('/[a-z]/', $user['password'])) {
				$errors[] = 'Password must contain at least 1 uppercase, 1 lowercase, 1 symbol and a number';
			}
			elseif (!preg_match('/[0-9]/', $user['password'])) {
				$errors[] = 'Password must contain at least 1 uppercase, 1 lowercase, 1 symbol and a number';
			}
			elseif (!preg_match('/[^A-Za-z0-9\s]/', $user['password'])) {
				$errors[] = 'Password must contain at least 1 uppercase, 1 lowercase, 1 symbol and a number';
			}
			elseif ($user['password'] !== $user['conf_password']) {
				$errors[] = 'Password does not match';
			}
		}
		

		return $errors;

	}

	/* Username is unique
	** returns bool, true if unique, false if nots
	*/
	function has_unique_username($username, $current_id='0') {
		global $db;

		$sql = "SELECT * FROM admins ";
		$sql .= "WHERE username='" . db_escape($db, $username) . "' ";
		$sql .= "AND id!='" . db_escape($db, $current_id) . "'";
		$result = mysqli_query($db, $sql);
		$username_count = mysqli_num_rows($result);
		mysqli_free_result($result);

		return $username_count === 0;

	}

	// Add a user
	//TODO hash password before insert 
	function insert_user($user) {
		global $db;

		//validate user details
		$errors = validate_user_data($user);
		if (!empty($errors)) {
			return $errors;
		}

		$hashed_password = password_hash($user['password'], PASSWORD_BCRYPT);

		$sql = "INSERT INTO admins ";
		$sql .="(first_name, last_name, email, username, hashed_password) ";
		$sql .= "VALUES ( ";
		$sql .= "'" . db_escape($db, $user['first_name']) . "', ";
		$sql .= "'" . db_escape($db, $user['last_name']) . "', ";
		$sql .= "'" . db_escape($db, $user['email']) . "', ";
		$sql .= "'" . db_escape($db, $user['username']) . "', ";
		$sql .= "'" . db_escape($db, $hashed_password) . "' ";
		$sql .= " )";

		$result = mysqli_query($db, $sql);
		if ($result) {
			
			return true;			
		} else {
			echo mysqli_error($db);
			db_disconnect($db);
			exit();
		}
	}

	//Retrieve a user
	function find_user_by_id($id) {
		global $db;

		$sql = "SELECT * FROM admins ";
		$sql .= "WHERE id='". db_escape($db, $id) ."'";

		$result = mysqli_query($db, $sql);
		confirm_query_result($result);

		return $result;


	}
	function find_all_usernames() {
		global $db;
		
		$sql = "SELECT username FROM admins";
		$results = mysqli_query($db, $sql);
		confirm_query_result($results);

		return $results;
		

	}
	function find_all_users() {
		global $db;

		$sql = "SELECT * FROM admins";
		$sql .= "";
		$results = mysqli_query($db, $sql);
		confirm_query_result($results);

		return $results;
	}
	function find_user_by_username($username) {
		global $db;
		$sql = "SELECT * FROM admins ";
		$sql .= "WHERE username='" . db_escape($db, $username) . "' ";
		$sql .= "LIMIT 1";

		$result = mysqli_query($db, $sql);
		$user = mysqli_fetch_assoc($result);
		confirm_query_result($result);

		return $user;
	}

	//Update a user
	// return bool if successful and error if not
	function update_user($user) {
		global $db;

		//only update password if user set a password
		$password_sent = !is_blank($user['password']);
		$errors = validate_user_data($user, ['password_required' => $password_sent]);

		if (!empty($errors)) {
			
			return $errors;
		}
		$hashed_password = password_hash($user['password'], PASSWORD_BCRYPT);

		$sql = "UPDATE admins SET ";
		$sql .= "first_name='" .db_escape($db, $user['first_name']) . "', ";
		$sql .= "last_name='" .db_escape($db, $user['last_name']) . "', ";
		$sql .= "email='" .db_escape($db, $user['email']) . "', ";
		if ($password_sent === true) {
			$sql .= "hashed_password='" .db_escape($db, $hashed_password) . "', ";
		}
		$sql .= "username='" .db_escape($db, $user['username']) . "' ";
		$sql .= "WHERE id='" . db_escape($db, $user['id']) . "' ";
		$sql .= "LIMIT 1";

		$result = mysqli_query($db, $sql);

		if ($result) {

			return true;
		} else {
			echo mysqli_error($db);
			db_disconnect($db);
			exit();
		}
	}

	//Delete a user 
	function delete_user($id) {
		global $db;

		$sql = "DELETE FROM admins ";
		$sql .= "WHERE id='" . db_escape($db, $id) . "' ";
		$sql .= "LIMIT 1";

		$result = mysqli_query($db, $sql);
		if ($result) {
			return true;
		} else {
			echo mysqli_error($db);
			db_disconnect($db);
			exit();
		}
	}

	function shift_subject_positions($start_pos, $end_pos, $current_id=0) {
		global $db;

		if ($start_pos == $end_pos) { return;}

		$sql = "UPDATE subjects ";
		if ($start_pos == 0) {
			# new item, +1 to items greater than $end_pos
			$sql .= "SET position = position + 1 ";
			$sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
		}elseif ($end_pos == 0) {
			# delete item, -1 from items greater than $start_pos
			$sql .= "SET position = position - 1 ";
			$sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
		}elseif ($start_pos < $end_pos) {
			# move later, -1 from items between (including $end_pos)
			$sql .= "SET position = position - 1 ";
			$sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
			$sql .= "AND position <= '" . db_escape($db, $end_pos) . "' ";
		}elseif ($start_pos > $end_pos) {
			# move earlier, +1 to items between (including $end_pos)
			$sql .= "SET position = position + 1 ";
			$sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
			$sql .= "AND position < '" . db_escape($db, $start_pos) . "' ";
		}
		# Exclude the current_id in the SQL WHERE clause
		$sql .= "AND id != '" . db_escape($Db, $current_id) . "' ";

		$result = mysqli_query($db, $sql);
		# for UPDATE statemenst, $result is true/false
		if ($result) {
			return true;
		} else {
			echo mysqli_error($db);
			db_disconnect($db);
			exit();
		}
	}

	function shift_page_positions($start_pos, $end_pos, $subject_id, $current_id=0) {
		global $db;
		if($start_pos == $end_pos) { return; }

		$sql = "UPDATE pages ";
		if ($start_pos == 0) {
			# add new item, +1 to items greater than the $end_pos
			$sql .= "SET position = position + 1 ";
			$sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
		} elseif ($end_pos == 0) {
			# delete an item, -1 from items greater than $start_pos
			$sql .= "SET position = position - 1 ";
			$sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
		} elseif ($start_pos < $end_pos) {
			# move later, - 1 to items greater than $start_pos (including $end_pos,ie. between the $end_pos)
			$sql .= "SET position = position - 1 ";
			$sql .= "WHERE position >= '" . db_escape($db, $start_pos) . "' ";
			$sql .= "AND position < '" . db_escape($db, $end_pos) . "' ";
		} elseif ($start_pos > $end_pos) {
			# move earlier, +1 to items greater than $end_pos (including $start_pos)
			$sql .= "SET position = position + 1 ";
			$sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
			$sql .= "AND position < '" . db_escape($db, $start_pos) . "' ";
		}
		#Exclude the current_id from the WHERE clause, use the current subject_id
		$sql .= "AND id!= '" . db_escape($db, $current_id) . "' ";
		$sql .= "AND subject_id ='" . db_escape($db, $subject_id) . "' ";
		$result = mysqli_query($db, $sql);
		if ($result) {
			return true;
		}else {
			echo mysqli_error($db);
			db_disconnect($db);
			exit();
		}

	}


 ?>