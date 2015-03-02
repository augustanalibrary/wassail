<?PHP
$require_right = 'write';
require_once('setup.php');

$id = $_POST['id'];
$Template = new Template($id);

$questions = @$Template->questions;

if(is_array($questions) && count($questions) > 0)
{
  foreach($Template->questions as $Question)
  {
    $question_texts[] = $Question->text;
  }
  $tpl->assign('questions',$question_texts);
  $tpl->display('ajax.template_questions.tpl');
}
else
  echo "There are no questions associated with this template.";
?>
