<?php

/*

  SWIFT MAILER REQUIRED
  ---------------------

  sudo apt-get install php-pear

  sudo pear channel-discover pear.swiftmailer.org

  sudo pear install swift/swift

*/


// 1) Setup swift mailer transport 
require_once 'swift_required.php';
$transport = Swift_SmtpTransport::newInstance('smtp.libero.it', 26)
  ->setUsername('nome.cognome@libero.it')
  ->setPassword('password_mail')
;
// Create the Mailer using your created Transport
$mailer = Swift_Mailer::newInstance($transport);


// 2) Determine feeds
$now = time();
$h24 = date("Y-n-j H:i:s", time() - (3600*2));
$h48 = date("Y-n-j H:i:s", time() - (3600*4));
$mysqli = new mysqli("localhost","root","CippaLippa2020","emoncms");
$result = $mysqli->query("SELECT id,userid,name FROM feeds WHERE `time`>='$h48' AND `time`<='$h24';");

$users = array();

while ($row = $result->fetch_object())
{
  if (!isset($users[$row->userid])) $users[$row->userid] = array('id'=>$row->userid, 'feeds'=>array());
  $users[$row->userid]['feeds'][] = $row->name;
}

foreach ($users as $user)
{

  $userid = $user['id'];
  $result = $mysqli->query("SELECT email FROM notify WHERE `userid` = '$userid' AND `enabled` = '1';");
  
  
  if ($result && $result->num_rows)
  {  
    $row = $result->fetch_array();
    $email = $row['email'];
    
    // Send an email
    
    $body = "<p><b><?php echo _('Hello!'); ?></b></p><p><?php echo _('The following emoncms feeds have become inactive for more than 2 hours:'); ?></p><ul>";
    foreach ($user['feeds'] as $feed)
    {
      $body .= "<li>".$feed."</li>";
    }
    $body .= "</ul>";
    $body .= "<p><i><?php echo _('This is an automated email generated by the emoncms notify module. To turn 'notify on inactive' off click on disable on the notify module page.'); ?></i></p>";
    
    // Create the message
    $message = Swift_Message::newInstance()

      // Give the message a subject
      ->setSubject(count($user['feeds'])._("emoncms feeds have become inactive"))

      // Set the From address with an associative array
      ->setFrom(array('from@address.example' => 'Emoncms'))

      // Set the To addresses with an associative array
      ->setTo(array($email))

      // Give it a body
      ->setBody($body, 'text/html')

    ;
    $result = $mailer->send($message);
  }
}




