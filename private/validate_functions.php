<?php 
	/* is_blank('abc')
	** validate data presence
	** uses trim() so empty spaces don't count
	** uses === to avoid false positives
	** better than empty() which considers "0" to be empty
	*/
	function is_blank($value){
		return !isset($value) || trim($value) === '';
	}

	/* has_presence('abcd')
	** validate data presence
	** reverse of is_blank
	** 
	*/
	function has_presence($value){
		return !is_blank($value);
	}

	/* has_length_greater_than('abcd', 3)
	** validate string length
	** spaces count towards length
	** use trim() if spaces should not count
	*/
	function has_length_greater_than($value, $min){
		$length = strlen($value);
		return $length > $min;
	}

	/* has_length_less_than('abcd', 8)
	** validate string length
	** spaces count towards length
	** use trim() if spaces should not count
	*/
	function has_length_less_than($value, $max){
		$length = strlen($value);
		return $length < $max;
	}

	/* has_length_exactly('abcd', 4)
	** validate string length
	** spaces count towards length
	** use trim() if spaces should not count
	*/
	function has_length_exactly($value, $exact){
		$length = strlen($value);
		return $length == $exact;
	}

	/* has_length('abcd', ['min' => '3', 'max' => '8', 'exact' => '6'])
	** validate string length
	** combines functions_greater_than, _less_than, _exactly
	** spaces count towards length
	** use trim() if spaces should not count
	*/
	function has_length($value, $options){
		if (isset($options['min']) && !has_length_greater_than($value, $options['min'] - 1)) {
			return false;
		}
		elseif (isset($options['max']) && !has_length_less_than($value, $options['max'] + 1)) {
			return false;
		}
		elseif (isset($options['exact']) && !has_length_exactly($value, $options['exact'])) {
			return false;
		}
		else{
			return true;
		}
	}

	/* has_inclusion_of(2, [2,3,4,5])
	** validate inclusion in a set
	*/
	function has_inclusion_of($value, $set){
		return in_array($value, $set);
	}

	/* has_exclusion_of(2, [3,4,5,6])
	** validate exclusion from a set
	*/
	function has_exclusion_of($value, $set){
		return !has_inclusion_of($value, $set);
	}

	/* has_string('nobodynowhere.com', '.com')
	** validate inclusion of character(s)
	** strpos returns string start position of false
	** uses !== to prevent position 0 from being considered false
	** strpos() is faster than preg_match() if you want to check if one string is contained in another
	*/
	function has_string($value, $required_string){
		return strpos($value, $required_string) !== false;
	}

	/* has_valid_email_format('nobody@nowhere.com')
	** validate correct format for email addresses
	** format:: [chars]@[chars].[2+ letters]
	** preg_match is helpful, uses a regular expression
	** returns 1 for a match, 0 for no match (bool)
	*/
	function has_valid_email_format($value){
		$email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
		return preg_match($email_regex, $value) === 1; 
	}

	/* has_valid_password_format('abcd')
	** atleast 1 uppercase char, 1 lowercase char, 1 number, 1 symbol
	** returns bool, true if valid, false if not
	*/
	function has_valid_password_format($value) {
		$password_regex = '/\A[A-Z0-9]+[a-z0-9]\Z/';
		return preg_match($password_regex, $value) === 1;
	}






 ?>