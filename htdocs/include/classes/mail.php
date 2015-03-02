<?PHP

class Mail
{
  function send($to,$message);
  {
    if(is_array($to))
      $to = implode(',',$to);

    mail('$to','WASSAIL2 message',$message);
  }
}
?>