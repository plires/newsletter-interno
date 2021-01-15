<?php

include('../includes/config.inc');
include('con.php');
require '../vendor/autoload.php';

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$data = json_decode(file_get_contents("php://input"), TRUE);
$id = $data['id'];

$sql = "SELECT * FROM newsletters WHERE id = '$id'";
$stmt = $db->prepare($sql);
$stmt->execute();
$newsletter = $stmt->fetch(PDO::FETCH_ASSOC);
include('../includes/emails/contacts/template-envio-cliente.inc.php');

$sql = "SELECT email FROM users";
$stmt = $db->prepare($sql);
$stmt->execute();
$emails = $stmt->fetchAll(PDO::FETCH_ASSOC);

$mail = new PHPMailer(true);

try {
  //Server settings
  // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
  // $mail->SMTPDebug = 2; //Alternative to above constant
  $mail->isSMTP();                                            // Send using SMTP
  $mail->Host       = SMTP;                    // Set the SMTP server to send through
  $mail->SMTPAuth   = true;                              // Enable SMTP authentication
  $mail->Username   = USER_SMTP;                     // SMTP username
  $mail->Password   = PASS_SMTP;                               // SMTP password
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
  $mail->Port       = EMAIL_PORT;                               // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
  $mail->CharSet = EMAIL_CHARSET;

  $mail->SMTPOptions = array(
      'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
      )
  );

  //From
  $mail->setFrom(EMAIL_SENDER_SHOW, NAME_SENDER_SHOW);

  //ReplyTo
  $mail->addReplyTo(EMAIL_ADD_REPLY_TO, NAME_ADD_REPLY_TO);

  //To
  foreach ($emails as $email) {
  	$mail->addAddress($email['email']);     // Add a recipient
  }

  // Content
  $mail->isHTML(true);                                  // Set email format to HTML
  $mail->Subject = EMAIL_SUBJECT;
  $mail->Body    = $body;
  $mail->AltBody = 'Verifique un nuevo newsletter Vistage para completar.';

  $send = $mail->send();
	echo json_encode($send);
} catch (Exception $e) {
	echo json_encode(false);
}

?>