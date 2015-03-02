<?PHP
$require_login = FALSE;
require_once('setup.php');

$upload_max_filesize = ini_get('upload_max_filesize').'B';//ini settings don't have the 'B'


$tpl->assign(array('hide_navigation'=>TRUE,
		   'hide_legend'=>TRUE,
		   'load_tooltip'=>FALSE,
       'upload_max_filesize'=>$upload_max_filesize));

/* This var gets modified by possible conditions below */
$tpl->assign('title','Welcome');


/* Import the id of the form we're working on */
$identifier = $_GET['id'];

$WebForm = new WebForm($identifier);
$tpl->assign('id',$WebForm->id);
if($WebForm->public)
    $tpl->assign('public',TRUE);

/* Handle form submission */
if(isset($_POST['login']) && !$WebForm->login($_POST['password']))
{
  $tpl->assign('error_message',$WebForm->error);
  $tpl->display("web_form.login.tpl");
  exit();
}

/* Display form if necessary */
if(isset($_SESSION['form']) && $_SESSION['form'] == $identifier)
{
  $tpl->assign(array(	'file_request'=>$WebForm->file_request,
					 	   'file_count'=>$WebForm->file_count,
               'confirmation'=>$WebForm->confirmation,
               'title'=>'Web Form: '.$WebForm->template_name,
		     			'template_name'=>$WebForm->template_name));

  if($WebForm->loadQuestions())
  {
    $tpl->assign('questions',$WebForm->questions);
      
    /* If POSTed, check */
    if(isset($_POST['submit']))
    {
		        if($WebForm->checkPost())
      {
		if($WebForm->submit())
		{
		  $tpl->assign('title','Web Form completed');

      /* Compile their answers */
      $responses = array();
      foreach($WebForm->questions as $q_id=>$question){
        $responses[$q_id] = array('question_text'=>$question['text'],'position'=>$question['position'],'answer_text'=>'');

        // simply record qualitative text
        if($question['type'] == 'qualitative'){
          $responses[$q_id]['answer_text'] = $_POST['q_'.$q_id];
        }

        // find the text of quantitative answers
        else{
          $answers = array();
          $posted_answers = $_POST['q_'.$q_id];
          if(is_array($posted_answers)){
            foreach($_POST['q_'.$q_id] as $answer_id){
              $answers[] = $question['answers'][$answer_id];
            }
    
            $answer_text = implode(', ',$answers);
          }
          else{
            $answer_text = $question['answers'][$posted_answers];
          }
          $responses[$q_id]['answer_text'] = $answer_text;
        }
      }
      $tpl->assign('answers',$responses);
		  $tpl->display("web_form.finished.tpl");
		}
		else
		{
		  $tpl->assign(array('success'=>FALSE,
					 'message'=>$WebForm->error));
		  $tpl->display("web_form.form.tpl");
		}
      }
      else
      {
		$tpl->assign(array('success'=>FALSE,
				   'message'=>$WebForm->error));
		$tpl->display("web_form.form.tpl");
      }
    }
    else
      $tpl->display("web_form.form.tpl");
  }
  else
    $tpl->assign('error_message',$WebForm->error);

}
else
{
	$tpl->assign('intro',$WebForm->intro);
  $tpl->display("web_form.login.tpl");
}
?>