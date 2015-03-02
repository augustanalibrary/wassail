<?PHP
$require_right = 'read';
require_once('setup.php');

$QuestionList = new QuestionList($_GET['o'],$_GET['d']);
$list = $QuestionList->getList();

header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: private',false);
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="WASSAIL_questions_'.date('d-m-y').'.csv');
//header('Content-Length: '.strlen($csv_data));

echo '"question id","question text","answer id","answer text"'."\n";

foreach($list as $id=>$question)
{
  $question_text = trim(strip_tags(preg_replace('%(?<!\\\\)"%','\\"',$question['text'])));

  if(isset($question['answers']))
  {
    foreach($question['answers'] as $answer_id=>$answer_text)
    {
      //regex pattern taken from Template Lite "escape" modifier function
      $answer_text = trim(strip_tags(preg_replace('%(?<!\\\\)"%','\\"',$answer_text)));
      
      echo <<<ROW
"$id","$question_text","$answer_id","$answer_text"

ROW;
    }
  }
  else
    echo <<<ROW
"$id","$question_text","","N/A: Qualitative question"

ROW;
}

?>