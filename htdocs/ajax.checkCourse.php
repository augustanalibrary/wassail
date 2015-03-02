<?PHP
$require_right = 'write';
require_once('setup.php');

$DB = DBi::getInstance();

$field = ($_GET['type'] == 'number') ? 'number' : 'name';
$value = ($_GET['type'] == 'number') ? $_GET['number'] : $_GET['name'];
$value = $DB->escape(cleanGPC($value));

$query = <<<SQL
SELECT
 *
FROM
 course
WHERE
 $field = '$value'
SQL;

$result = $DB->execute($query,"checking for pre-existence of course based on $field");
if($result && $DB->numRows($result) == 0)
  echo 1;
?>