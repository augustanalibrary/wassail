<?PHP
# This file is called from the template page.  It generates a list of active web forms for the passed template ID

$require_right = 'write_unconditional';
require_once('setup.php');

$DB = DBi::getInstance();
$id = $DB->escape(cleanGPC($_GET['id']));

$query = <<<SQL
SELECT
	`id`,
	`name`
FROM
	`web_form`
WHERE
	`template_id` = '$id'
SQL;

$result = $DB->execute($query,'retrieving web forms for a template');
if($result)
{
	$results = array();
	if($DB->numRows($result))
	{
		while($row = $DB->getData($result))
		{
			$results[] = array(	'id'=>$row['id'],'name'=>$row['name']);
		}
	}
	$tpl->assign('forms',$results);
	$tpl->display('ajax.web_form.tpl');
	
	exit();
}
else
{
	echo $DB->getError();
	exit();
}

?>