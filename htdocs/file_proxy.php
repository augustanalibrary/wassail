<?PHP
##
# This file is used as a proxy to allow users of WASSAIL to download files uploaded by respondents, without the uploaded file being available in the web root
#

require('setup.php');

$file = $_GET['file'];
$file_path = UPLOAD_DIR.'responses/'.$file;
if(realpath($file_path) == $file_path)
{
	header("Content-type:application/octet-stream");
	header('Content-Disposition: attachment; filename="'.$file.'"');
	readfile($file_path);
}
else
{
	echo 'Unable to load file.';
}

exit();
?>