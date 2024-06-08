<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'sendEmail')
{
    // SMTP ayarlarınızı buraya ekleyin
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
$mail->Host       = 'mail.kurumsaleposta.com'; // SMTP sunucu adresi
$mail->SMTPAuth   = true;
$mail->Username   = 'support@munllc.com.tr'; // SMTP kullanıcı adı (mail adresi)
$mail->Password   = 'MunllCmrt126'; // SMTP şifre
$mail->Port       = 587; // SMTP port numarası


        // E-posta bilgilerini ayarlayın
        $to = 'support@munllc.com.tr';
        $subject = 'Munllc Contact Form';

        // Gönderen bilgilerini alın
        $fromEmail = $_REQUEST['con_email'];
        $fromName = $_REQUEST['con_fname'] . ' ' . $_REQUEST['con_lname'];

        // Başlığı ve içeriği oluşturun
        $message = "First Name: ".$_REQUEST['con_fname']. "<br />";
        $message .= "Last Name: ".$_REQUEST['con_lname']. "<br />";
        $message .= "Email: ".$_REQUEST['con_email']. "<br />";
        $message .= "Phone: ".$_REQUEST['con_phone']. "<br />";
        $message .= "Message: ".$_REQUEST['con_message']. "<br />";

        // E-posta gönderme işlemini gerçekleştirin
        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        if ($mail->send()) {
            $send_arr['response'] = 'success';
            $send_arr['message'] = 'Your message has been sent.';
        } else {
            $send_arr['response'] = 'error';
            $send_arr['message'] = 'Your message could not be sent. Please try again later.';
        }
    } catch (Exception $e) {
        $send_arr['response'] = 'error';
        $send_arr['message'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }

    echo json_encode($send_arr);
    exit;
}
?>
