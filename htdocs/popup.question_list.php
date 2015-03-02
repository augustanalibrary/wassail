<?PHP
  /**********
   * File: popup.question_list.php
   *
   * This file generates a list of questions in pretty, readable form.
   * A $_GET variable must be passed named 'return'.  This variable must contain the id
   * of the element in the parent window that opens this file.  JS will populate
   * that field with the id of the clicked question
   *
   */

require_once('setup.php');

/* $_GET['return'] contains the id of the element in the parent window 
 * in where to put the clicked question id
 */
$return = $_GET['return'];
$order_column = (isset($_GET['o'])) ? $_GET['o'] : 'id';
$order_dir = (isset($_GET['d'])) ? $_GET['d'] : 'desc';

$QuestionList = new QuestionList($order_column,$order_dir);
$list = $QuestionList->getList();

$tpl->assign(array('title'=>'Question list',
		   'load_editor'=>FALSE,
		   'list'=>$list,
		   'order_column'=>$order_column,
		   'order_dir'=>$order_dir,
		   'hide_legend'=>TRUE));
$tpl->display('popup.question_list.tpl');
?>