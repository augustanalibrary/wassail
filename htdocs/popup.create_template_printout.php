<?PHP
$require_right = 'read';
require_once('setup.php');

$template_id = $_GET['id'];


/* Do work if the user hasn't requested the printout yet */
if(!isset($_POST['generate-pdf']) && !isset($_POST['generate-code']))
{
  $tpl->assign(array('hide_legend'=>TRUE,
		     'template_id'=>$template_id));
  $tpl->display('popup.create_template_printout.tpl');
}
else
{
  /* If the user has requested the printout, generate the HTML (the PDF is rendered
   * from the HTML)
  */

  $tpl->assign(array('header'=>cleanGPC($_POST['header']),
		     'footer'=>cleanGPC($_POST['footer'])));


  /* Assign the questions of the Template (big T), to the template (little t) */
  $Template = new Template($template_id);
  foreach($Template->questions as $Question)
  {
    if($Question->answers_exist)
    {
      foreach($Question->answers as $Answer)
      {
		$answers[] = $Answer->text;
      }
    }
    else
      $answers = FALSE;

    $questions[] = array('type'=>$Question->type,
			 	'text'=>$Question->text,
			 	'answers'=>$answers,
				'opt_out'=>$Question->opt_out);
    unset($answers);
  }


  $tpl->assign(array('title'=>'Generate Template printout',
		     'hide_iconbar'=>TRUE,
		     'questions'=>$questions));


  /* Generate the code to display, but don't display it yet */
  ob_start();
  $tpl->display('popup.display_template_printout.tpl');
  $code = ob_get_clean();


  /* If the user wants a PDF, give them the PDF */
  if(isset($_POST['generate-pdf']))
  {
    require_once('include/dompdf/dompdf_config.inc.php');
    $dompdf = new DOMPDF();
    $dompdf->set_paper('letter','landscape');
    $dompdf->load_html($code);
    $dompdf->render();

    //$dompdf->stream doesn't set the Pragma header & IE7 craps out if it's not set
    header("Pragma: public");
    $dompdf->stream('WASSAIL template- '.$Template->name.'.pdf');
    exit();
  }
  
  /* Otherwise, display the code as generated */
  else
    echo $code;
}

?>