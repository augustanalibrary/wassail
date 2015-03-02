<?PHP
$require_right = 'account';
require_once('setup.php');

$DB = DBi::getInstance();

$ret_val = array();
$instance_id = $DB->escape($_GET['id']);
$instance_name = $DB->escape($_GET['name']);

$query = <<<SQL
UPDATE
  instance
SET
  name = '$instance_name'
WHERE
  id = '$instance_id'
SQL;
$result = $DB->execute($query,'updating instance name');
if(!$result)
{
  $ret_val['ok'] = FALSE;
  $ret_val['error'] = $DB->getError();
}
else
  $ret_val['ok'] = TRUE;

echo myJSONEncode($ret_val);

?>