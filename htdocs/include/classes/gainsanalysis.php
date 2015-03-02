<?PHP

class GainsAnalysis
{
  private $Report1;
  private $Report2;
  private $error;

  function __construct()
  {
    $this->Report1 = new Report();
    $this->Report2 = new Report();
    $this->DB = DBi::getInstance();
  }

  function setParameters($set,$templates,$courses,$years,$terms,$types)
  {
    $this->{"Report$set"}->setParameters($templates,$courses,$years,$terms,$types);
  }

  function getData()
  {
    $report1Data = $this->Report1->getData();
    $report2Data = $this->Report2->getData();
    $compare_data = array();

	if(is_array($report1Data))
	{
		foreach($report1Data as $question_id=>$question_data)
		{
		  /* Only work on questions in both data sets */
		  if(isset($report2Data[$question_id]))
		  {
		$compare1 = $question_data;
		$compare2 = $report2Data[$question_id];
	
		$compare_data[$question_id]['text'] = $compare1['question_text'];
		foreach($compare1['answers'] as $answer_id=>$answer_properties)
		{
		  $count1 = $answer_properties['count'];
		  $percentage1 = $answer_properties['percentage'];
		  /* error squashing in case $answer_id is 0 not set in data set 2 */
		  $count2 = (isset($compare2['answers'][$answer_id])) ? $compare2['answers'][$answer_id]['count'] : 0;
		  $percentage2 = (isset($compare2['answers'][$answer_id])) ? $compare2['answers'][$answer_id]['percentage'] : 0;
		  $count_diff = $count2 - $count1;
		  $percentage_diff = $percentage2 - $percentage1;
		  $correct = (isset($answer_properties['correct'])) ? $answer_properties['correct'] : FALSE;
		  
		  $compare_data[$question_id]['answers'][$answer_id] = array('text'=>$answer_properties['text'],
										 'count1'=>$count1,
										 'percentage1'=>$percentage1,
										 'count2'=>$count2,
										 'percentage2'=>$percentage2,
										 'count_diff'=>$count_diff,
										 'percentage_diff'=>$percentage_diff,
										 'correct'=>$correct);
		}
		$compare_data[$question_id]['count1'] = $question_data['count'];
		$compare_data[$question_id]['count2'] = $report2Data[$question_id]['count'];
		  }
		}
    }
    if(count($compare_data) == 0)
    {
      $this->error = "The two parameter sets have no questions in common.";
      return FALSE;
    }
    else
      return $compare_data;
  }

  function dataAsCSV(&$data)
  {
    $ret_val = '"question id","question text","answer id","answer text","set 1 percentage","set 1 total responses","set 2 percentage", "set 2 total responses","percentage difference","total differences"'."\n";
    foreach($data as $question_id=>$question)
    {
      //pattern taken from Template Lite's 'escape' modifier
      $question_text = trim(strip_tags(preg_replace('%(?<!\\\\)"%','\\"',$question['text'])));
      $count1 = $question['count1'];
      $count2 = $question['count2'];
      
      foreach($question['answers'] as $answer_id=>$answer)
      {
	$answer_text = trim(strip_tags(preg_replace('%(?<!\\\\)"%','\\"',$question['text'])));
	$count1 = $answer['count1'];
	$count2 = $answer['count2'];
	$percentage1 = $answer['percentage1'];
	$percentage2 = $answer['percentage2'];
	$percentage_diff = $answer['percentage_diff'];
	$count_diff = $answer['count_diff'];

	$ret_val .= <<<LINE
"$question_id","$question_text","$answer_id","$answer_text","$percentage1","$count1","$percentage2","$count2","$percentage_diff","$count_diff"\n
LINE;
	
      }
    }

    return $ret_val;
  }

  function __get($name)
  {
    return $this->{$name};
  }
}

?>