<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------
 *
 * dDebug Helper
 *
 * Outputs the given variable(s) with formatting and location
 *
 * @access    public
 * @param    mixed    - variables to be output
 */
if ( ! function_exists('dDebug'))
{
    function dDebug()
    {
        list($callee) = debug_backtrace();

        $args = func_get_args();

        $total_args = func_num_args();

        echo '<div class="row" style="padding-top: 60px;"><div class="col-md-12"><fieldset style="background: #fefefe !important; border:2px blue solid; padding:15px">';
        echo '<legend style="background:blue; color:white; padding:5px;">'.$callee['file'].' at line: '.$callee['line'].'</legend><pre><code>';

        $i = 0;

        foreach ($args as $arg)
        {
            echo '<strong>Debug #' . ++$i . ' of ' . $total_args . '</strong>: ' . '<br>';

            var_dump($arg);
        }

        echo "</code></pre></fieldset></div></div><br>";
    }
} 

function pre($data)
{
	echo '<pre>';
	print_r($data);
	echo '</pre>';
}

function getDateTime()
{
	// return date('Y-m-d H:i:s');
	$now = new DateTime();
	// $now->setTimezone(new DateTimezone('Asia/Kuala_Lumpur'));
	return $now->format('Y-m-d H:i:s');
}

function getTodayDate()
{
	// return date('Y-m-d');
	$now = new DateTime();
	// $now->setTimezone(new DateTimezone('Asia/Kuala_Lumpur'));
	return $now->format('Y-m-d');
}

function db_date($date)
{
	return date('Y-m-d',strtotime($date));
}

function db_time($time)
{
	return date('H:i:s',strtotime($time));
}

function view_date($date)
{
	return date('d-m-Y',strtotime($date));
}

function view_time($date)
{
	return date('h:i A',strtotime($date));
}

function view_time2($date)
{
	return date('G:i',strtotime($date));
}

function show_datetime($date){
	return view_date($date).' / '.view_time($date);
}

function yesterday_date($today_date)
{
	return date('Y-m-d',strtotime($today_date.' -1 day'));
}

function db_time_1_sec($date)
{
	return date('H:i:s',strtotime($date." -1 seconds"));
}

function db_time_add_1_sec($date)
{
	return date('H:i:s',strtotime($date." +1 seconds"));
}

function display_datetime($show_type='DATETIME', $datetime) {
	
	$output_datetime = '';
	
	if ( strtoupper($show_type) == 'DATETIME' ) {
		
		if ( empty($datetime) || $datetime == NULL || $datetime == '0000-00-00 00:00:00' ) {
			$output_datetime = '';
		} else {
			$output_datetime = date('d/m/Y H:i:s', strtotime($datetime));
		}
		
	} else if ( strtoupper($show_type) == 'DATETIME2' ) {
		
		if ( empty($datetime) || $datetime == NULL || $datetime == '0000-00-00 00:00:00' ) {
			$output_datetime = '';
		} else {
			$output_datetime = date('d/m/Y H:i A', strtotime($datetime));
		}
		
	} else if ( strtoupper($show_type) == 'DATETIME3' ) {
		
		if ( empty($datetime) || $datetime == NULL || $datetime == '0000-00-00 00:00:00' ) {
			$output_datetime = '';
		} else {
			$output_datetime = date('d/m/Y', strtotime($datetime));
		}
		
	} else if ( strtoupper($show_type) == 'DATETIME4' ) {
		
		if ( empty($datetime) || $datetime == NULL || $datetime == '0000-00-00 00:00:00' ) {
			$output_datetime = '';
		} else {
			$output_datetime = date('jS \of F Y', strtotime($datetime));
		}
		
	} else if ( strtoupper($show_type) == 'DATE' ) {
		
		if ( empty($datetime) || $datetime == NULL || $datetime == '0000-00-00' ) {
			$output_datetime = '';
		} else {
			$output_datetime = date('d/m/Y', strtotime($datetime));
		}
		
	} else if ( strtoupper($show_type) == 'TIME' ) {
		
		if ( empty($datetime) || $datetime == NULL || $datetime == '00:00:00' ) {
			$output_datetime = '';
		} else {
			$output_datetime = date('H:i A', strtotime($datetime));
		}
		
	} else if ( strtoupper($show_type) == 'DB_DATE' ) {
		
		if ( empty($datetime) || $datetime == NULL || $datetime == '0000-00-00' ) {
			$output_datetime = NULL;
		} else {
			$output_datetime = date('Y-m-d', strtotime($datetime));
		}
		
	} else if ( strtoupper($show_type) == 'DB_DATETIME' ) {
		
		if ( empty($datetime) || $datetime == NULL || $datetime == '0000-00-00 00:00:00' ) {
			$output_datetime = NULL;
		} else {
			$output_datetime = date('Y-m-d H:i:s', strtotime($datetime));
		}
		
	} else {
		
		if ( empty($datetime) || $datetime == NULL || $datetime == '0000-00-00 00:00:00' ) {
			$output_datetime = '';
		} else {
			$output_datetime = date('d/m/Y H:i:s', strtotime($datetime));
		}
		
	}
	
	return $output_datetime;
}

function display_number_format($show_type='INTEGER', $number) {
	
	if ( strtoupper($show_type) == 'INTEGER' ) {
		$output_number = number_format($number);
		
	} else if ( strtoupper($show_type) == 'DECIMAL' ) {
		$output_number = number_format($number, 2);
	
	} else {
		$output_number = number_format($number);
	}
	
	return $output_number;
}

function shuffle_name($name = '')
{
	$alpa = 'abcdefghijklmnopqrstuvwxyz1234567890';
	$str = str_shuffle($alpa);
	$strrun = substr($str,0,5);
	$pName = $strrun.date('H').$name;
	
	return $pName;
}

function date_range_array($strDateFrom,$strDateTo)
{
    $aryRange=array();

    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2), substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2), substr($strDateTo,8,2),substr($strDateTo,0,4));

    if ($iDateTo>=$iDateFrom)
    {
        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
        while ($iDateFrom<$iDateTo)
        {
            $iDateFrom+=86400; // add 24 hours
            array_push($aryRange,date('Y-m-d',$iDateFrom));
        }
    }
    return $aryRange;
}

function encryptor($action, $string)
{
	$output = false;

	$encrypt_method = "AES-256-CBC";
	//pls set your unique hashing key
	$secret_key = 'MuD4w@71pR0j3cT';
	$secret_iv = 'MuD4w@71pR0j3cT';

	// hash
	$key = hash('sha256', $secret_key);

	// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	$iv = substr(hash('sha256', $secret_iv), 0, 16);

	//do the encyption given text/string/number
	if( $action == 'encrypt' )
	{
		$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
		$output = base64_encode($output);
	}
	else if( $action == 'decrypt' )
	{
		//decrypt the given text/string/number
		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	}

	return $output;
}

function return_empty($val)
{	
	return empty($val) ? '' : $val;
}

function remove_space_and_tab($string)
{
	$string = str_replace('`',"'",$string);
	$string = preg_replace('/\s+/S', " ", $string);

	return $string;
}

function generate_random_code($length = 3, $category = 1) 
{
	//-------------------------------------------------
	//category : 
	// 1 = alphabets upper
	// 2 = alphabets lower 
	// 3 = alphabets mix
	// 4 = alphanumeric upper 
	// 5 = alphanumeric lower
	// 6 = alphanumeric mix
	// 7 = numeric
	//-------------------------------------------------
	
	//#Reference - https://gist.github.com/karlgroves/5227409
	$randstr = "";
	srand((double) microtime(TRUE) * 1000000);
	//our array add all letters and numbers if you wish
	
	// 1 = alphabets upper
	if ( $category == 1 )
	{
		$alphanumeric_chars = array(
			'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 
			'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 
			'U', 'V', 'W', 'X', 'Y', 'Z');
	}
	// 2 = alphabets lower 
	else if ( $category == 2 )
	{
		$alphanumeric_chars = array(
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 
			'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 
			'u', 'v', 'w', 'x', 'y', 'z');
	}
	// 3 = alphabets mix
	else if ( $category == 3 )
	{
		$alphanumeric_chars = array(
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 
			'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 
			'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 
			'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 
			'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 
			'Y', 'Z');
	}
	// 4 = alphanumeric upper 
	else if ( $category == 4 )
	{
		$alphanumeric_chars = array(
			'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 
			'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 
			'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2', '3', 
			'4', '5', '6', '7', '8', '9');
	}
	// 5 = alphanumeric lower
	else if ( $category == 5 )
	{
		$alphanumeric_chars = array(
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 
			'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 
			'u', 'v', 'w', 'x', 'y', 'z', '0', '1', '2', '3', 
			'4', '5', '6', '7', '8', '9');
	}
	// 6 = alphanumeric mix
	else if ( $category == 6 )
	{
		$alphanumeric_chars = array(
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 
			'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 
			'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 
			'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 
			'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 
			'Y', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', 
			'9');
	}
	// 7 = numeric
	else if ( $category == 7 )
	{
		$alphanumeric_chars = array(
			'0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
	}
	
	for ($rand = 0; $rand <= $length; $rand++) {
		$random = rand(0, count($alphanumeric_chars) - 1);
		$randstr .= $alphanumeric_chars[$random];
	}
	return $randstr;
}

function create_folder($filename)
{
	if (!file_exists($filename))
	{
		mkdir($filename, 0777);
		$result = 1;
		//success create directory
		if ( file_exists($filename) )
		{
			$result = 0;
		} 
		//fail need to call this function back (recursive)
		else 
		{
			create_folder($filename);
		}
	}
	//already exist
	else 
	{
		$result = 0;
	}
	
	return $result;
}

function format_namecode($name, $code='')
{
	return $name . ( !empty($code) ? ' ('.$code.')' : '' );
}

function encryptor_multiple(&$val, $fn, $action)
{
	$val = encryptor($action, $val);
}
	
?>