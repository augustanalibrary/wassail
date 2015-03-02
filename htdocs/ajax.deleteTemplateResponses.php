<?PHP
$require_right = 'write';
require_once('setup.php');
$id = $_GET['id'];
$ResponseList = new ResponseList();
$entries = $ResponseList->loadEntriesForTemplate($id);
$error = FALSE;
foreach($entries[0]['individual'] as $response_id)
{
  $Response = new Response($response_id);
  if(!$Response->delete())
    $error = $Response->error;
}
/* Output gets interpreted as a JSON object */
if($error)
  echo '{ "success": false, "error": "'.$error.'"}';
else
  echo '{"success": true}';