<?PHP

class QuestionList
{
  private $DB;
  private $order_column;
  private $order_dir;
  private $list = FALSE;


  function __construct($order_column = 'id',$order_dir = 'desc')
  {
    $this->DB = DBi::getInstance();
    $this->setOrderColumn($order_column);
    $this->setDirection($order_dir);
  }

  function setDirection($dir = 'asc')
  {
    $this->order_dir = ($dir == 'asc') ? 'asc' : 'desc';
  }

  function setOrderColumn($column = 'id')
  {
    switch($column)
    {
      case 'text':
	$this->order_column = 'plaintext';
	break;
      case 'date':
	$this->order_column = 'date_added';
	break;
      case 'tags':
	$this->order_column = 'tags';
	break;
      default:
	$this->order_column = 'id';
	break;
    }
  }

  function getList()
  {
    if(!$this->list)
      $this->buildList();

    return $this->list;
  }

  function buildList()
  {
    $instance_id = $_SESSION['instance_id'];

    $query = <<<SQL
SELECT
      question.id as id,
      question.text as text,
      question.plaintext,
      question.date_added as date_added,
      question.tags as tags,
      question.asked as asked,
      answer.id as answer_id,
      answer.text as answer_text,
      answer.position
FROM
      question
LEFT JOIN
      answer
ON
      answer.question_id = question.id
WHERE
      question.instance_id = $instance_id
ORDER BY
      $this->order_column $this->order_dir,
      position asc
SQL;

    $result = $this->DB->execute($query,'retrieving question list');
    if(!$result)
      $this->list = FALSE;
    else if($this->DB->numRows($result))
    {
      while($row = $this->DB->getData($result))
      {
      	$this->list[$row['id']]['id'] = $row['id'];
      	$this->list[$row['id']]['text'] = $row['text'];
      	$this->list[$row['id']]['plaintext'] = $row['plaintext'];
      	if(strlen($row['tags']))
      	{
      	  $tags = explode(TAG_DELIMITER,trim($row['tags']));
      	  sort($tags);
      	}
      	else
      	  $tags = array();

      	$this->list[$row['id']]['tags'] = $tags;
      	$this->list[$row['id']]['date_added'] = $row['date_added'];
      	$this->list[$row['id']]['asked'] = $row['asked'];
      	if(!is_null($row['answer_text']))
      	  $this->list[$row['id']]['answers'][$row['answer_id']] = $row['answer_text'];
      	
      	/* retrieve category text */
      	$query = <<<SQL
SELECT
	  id,
	  text
FROM
	  category,
	  question_category
WHERE
	  category.id = question_category.category_id AND
	  question_id = $row[id]
ORDER BY
      	  category.text asc
SQL;
      	$cat_result = $this->DB->execute($query,"retrieving category text for question #$row[id]");
      	if($cat_result)
      	  while($cat_row = $this->DB->getData($cat_result))
      	  {
      	    $this->list[$row['id']]['categories'][$cat_row['id']] = $cat_row['text'];
      	  }


          if(Auth::rightWriteUnconditional()){

            /* retrieve template text */
            $query = <<<SQL
SELECT
  `id`,
  `name`
FROM
  `template`,
  `question_template`
WHERE
  `question_id` = $row[id] AND
  `template_id` = `id`
ORDER BY
  `id`
SQL;
            $tpl_result = $this->DB->execute($query,"retrieving templates for question #$row[id]");
            if($tpl_result){
              $tpl = array();
              while($tpl_row = $this->DB->getData($tpl_result))
              {
                $tpl[$tpl_row['id']] = $tpl_row['name'];
              }
              $this->list[$row['id']]['templates'] = $tpl;
            }


            /* Retrieve year/term stats
             * This query retrieves the number of unique respondERS
             * To retrieve the number of unique responsES, replace the count
             * clause with: count(*) as `count`
             */
            $query = <<<SQL
SELECT
  `school_year`,
  `term`,
  count(distinct(response_id)) as `count`
FROM
  `response`
WHERE
  `question_id` = $row[id] 
GROUP BY
  `school_year`,
  `term` 
ORDER BY
  `school_year`,
  `term`
SQL;
 
            $stat_result = $this->DB->execute($query,"retrieving stats for question #$row[id]");

            global $QUESTIONNAIRE_TERMS; //set in config.php
            if($stat_result){
              $stat = array();
              $term_totals = array_combine($QUESTIONNAIRE_TERMS,array(0,0,0,0));

/*
              if($row['id'] == '3962' && $stat_result){
                echo "<pre>$query</pre>";
                echo $this->DB->numRows($stat_result);
                echo '<br />';
                exit();
              }
*/
              while($stat_row = $this->DB->getData($stat_result))
              {               
                if(!isset($stat[$stat_row['school_year']]))
                    $stat[$stat_row['school_year']] = array('Total'=>0);

                $term = $QUESTIONNAIRE_TERMS[$stat_row['term']];

                $stat[$stat_row['school_year']][$term] = $stat_row['count'];
                $stat[$stat_row['school_year']]['Total'] += $stat_row['count'];
                $term_totals[$term] += $stat_row['count'];
              }
              $stat['Total'] = $term_totals;
              $stat['Total']['Total'] = array_sum($term_totals);
              $this->list[$row['id']]['stats'] = $stat;
            }// if $stat_result
          }// if rightWriteUnconditional
      }
    }
    else
      $this->list = array();
  }
}

?>