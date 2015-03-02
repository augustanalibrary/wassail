<?PHP
  //This function will automatically load any class definition files that aren't already loaded when
  //an object is created
function __autoload($classname)
{
  if(file_exists(INSTALL_DIR.'include/classes/'.strtolower($classname).'.php'))
    require_once(INSTALL_DIR.'include/classes/'.strtolower($classname).'.php');
  else if(function_exists('DOMPDF_autoload'))
    DOMPDF_autoload($classname);
}

function cleanGPC($input)
{
  return (get_magic_quotes_gpc()) ? stripslashes($input) : $input;
}


function generateQueryString()
{
  $ret_val[0] = (isset($_GET['o'])) ? $_GET['o'] : 'id';
  $ret_val[1] = (isset($_GET['d'])) ? $_GET['d'] : 'desc';

  return $ret_val;
}


//********************************
//Function: dumpArray
//Purpose: to print out an array/object in a readable form
//         and to display from what line in what file, the function
//         was called
//********************************
function dumpArray($p_array,$force_on_top=FALSE)
{
  $backtrace = debug_backtrace();
  $file = $backtrace[0]['file'];
  $line = $backtrace[0]['line'];


  if($force_on_top)
    echo '<div style = "z-index:10000;position:absolute;top:0;background-color:#fff;">';

  echo '<pre>';
  echo "File: $file<br />";
  echo "Line: $line<br />";
  print_r($p_array);
  echo '</pre>';

  if($force_on_top)
    echo '</div>';
}



/********************
 * Function: prePrint()
 * Purpose: To print the passed argument wrapped in <pre> tags
 * Parameters: (string) $to_print: the string to print
 */
function prePrint($to_print)
{
  $backtrace = debug_backtrace();
  $file = $backtrace[0]['file'];
  $line = $backtrace[0]['line'];

  echo <<<OUTPUT
<pre>
<strong>File: </strong>$file
<strong>Line: </strong>$line

$to_print
</pre>
OUTPUT;
}

####
# Function: _jsonEncode
# Purpose: To encode a variable into json format
# Arguments: $encodeMe: the variable to convert into JSON format
#            $encodeAs : the name of the variable to save $var1 as.  
#                        REQUIRED if $encodeMe is not an array
# Usage: 
#   echo _jsonEncode('test','var1');// outputs: {"var1":test"}
#   echo _jsonEncode(TRUE,'var1');  // outputs: {"var1":1}
#   echo _jsonEncode(123,'var1');   // outputs: {"var1":123}
#   echo _jsonEncode(array('orange'=>1,'blue'=>2,'green'=>3));  // outputs: {"orange":1,"blue":2,"green":3}
# 
# Author: Dylan Anderson
# License: GPLv3
####
function myJsonEncode($encodeMe,$encodeAs=FALSE){
	$output = '{';
	
	if(is_array($encodeMe)){
		foreach($encodeMe as $key=>$value){
			$output .= $key.':';
			
			if(is_array($value)){
				$function = __FUNCTION__;
				$output .= $function($value);
			}
			
			else if(is_numeric($value))
				$output .= $value;

			else
				$output .= '"'.str_replace('"','\"',$value).'"';
			
			$output .= ',';
		}
		$output = rtrim($output,',').'}';
	}
	else if(strlen($encodeAs)){
		if(is_numeric($encodeMe))
			$output .= '"'.$encodeAs.'":'.$encodeMe.'}';
		else if(is_bool($encodeMe)){
			$encode_value = ($encodeMe) ? 1 : 0;
			$output .= '"'.$encodeAs.'":'.$encode_value.'}';
		}
		else if(is_string($encodeMe))
			$output .= '"'.$encodeAs.'":'.str_replace('"','\"',$encodeMe).'"}';
	}
	else
		$output = FALSE;

	return($output);
}




?>