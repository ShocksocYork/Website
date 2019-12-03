<?php

date_default_timezone_set('Etc/UTC');

/*This php mailer class handles discord requests. It's fairly simple to understand. Basically the site
uses googles SMTP services for sending emails using the PHPMailer package from github all located
included in the '/PHPmailer' folder.
$msg contains the message sent, $email & $name are the emails and names of the person submitting.

Additional error checks such as the check for the @york.ac.uk are located in the HTML index.html file for simplicty.
Be aware this mailer class is by no means perfect. The site dosen't have SMTPAuth so we can't check if the email
address is actually correct or notonly if it has the @york.ac.uk. Luckily we have a list of the members of shocksoc
to help with that*/



// Edit this path if PHPMailer is in a different location.
require './PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;
$mail->isSMTP();

/*
 * Server Configuration
 */

$email = $_POST['email'] ;
$name = $_POST['name'] ;

//Splits email out from @ to get the user id.
list($user, $domain) = explode('@', $email);

$msg =
"Request to join discord server from Shocksoc.org from..." . "\r\n" .
"First Name: " . $name . "\r\n" .
"Email: " . $email . "\r\n" .
"user id: " . $user;

$mail->Host = 'smtp.gmail.com'; // Which SMTP server to use.
$mail->Port = 587; // Which port to use, 587 is the default port for TLS security.
$mail->SMTPSecure = 'tls'; // Which security method to use. TLS is most secure.
$mail->SMTPAuth = true; // Whether you need to login. This is almost always required.
$mail->Username = "shocksocweb@gmail.com"; // Your Gmail address.
$mail->Password = "enessgvxbpdostbi"; // Your Gmail login password or App Specific Password.

$mail->setFrom('autoreply@shocksoc.org', 'Shocksoc.org Autoreply');
$mail->addReplyTo('shocksocweb@gmail.com', 'Shocksoc Email Handler');
$mail->addAddress('shocksocweb@gmail.com', 'Shocksoc Email Handler');

$mail->Subject = "Discord join request from user: " . $user; // The subject of the message.

// Choose to send either a simple text email...
$mail->Body = $msg; // Set a plain text body.

//Checks that the user is using a @york.ac.uk email email_address

// ... or send an email with HTML.
//$mail->msgHTML(file_get_contents('contents.html'));
// Optional when using HTML: Set an alternative plain text message for email clients who prefer that.  //$mail->AltBody = 'This is a plain-text message body';

// Optional: attach a file
//$mail->addAttachment('images/phpmailer_mini.png');
if ($mail->send()) {
  header('Location: thankyoudiscord.html');
  exit;
} else {
  echo "Mailer Error: " . $mail->ErrorInfo;
}
