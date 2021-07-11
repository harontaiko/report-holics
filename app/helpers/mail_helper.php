<?php

/**
 * @param phpmailers 
 */

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../public/mail/src/Exception.php';
require '../public/mail/src/PHPMailer.php';
require '../public/mail/src/SMTP.php';

class Mail
{

    /**
     * @param constructs
     */
    private $receiver_address;
    private $receiver_name;

    /**
     * send forgot password link
     */
    public function __construct($receiver_address, $receiver_name)
    {
        $this->receiver_name = $receiver_name;
        $this->receiver_address = $receiver_address;
    }

    /**
     * reset password email
     */
    public function SendResetPasswordLink($reset_token)
    {


        $mail = new PHPMailer(true);

        try {
            //SMTP SERVER CONFIGURATION
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = MAIL_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USERNAME; //email account
        $mail->Password = MAIL_PASS;             //secure password 
        $mail->SMTPSecure = MAIL_SMTP;                //default encryption
        $mail->Port = MAIL_PORT;

        //recipients
        $mail->setFrom(MAIL_USERNAME, SITENAME);  //from who, email, Name
        $mail->addAddress($this->receiver_address);                    //to who  
        $mail->addReplyTo(MAIL_USERNAME, SITENAME);             //email to reply to  

        $reset_pwd_link = URLROOT .'/users/verify/' . $reset_token . '/' . $this->receiver_address . '';
        //content
        $mail->isHTML(true);
        $mail->Subject = 'Reset Password Daily Report';
        $mail->Body = 'Greetings from holics ent, 😟 we are sorry you lost you password, to continue please verify your email address by .<br><br>
                    clicking this link or copying it to your browser :
                    ' . $reset_pwd_link . '<br><br>
                    if you dont use this link within 3 hours, it will expire. To get a new link please resend the link.
                    <br>
                    <br>
                    Best Regards,
                    Holicsent';

        $mail->send();
        } catch (Exception $e) {
            echo $e->getMessage(); //Boring error messages from anything else!
        }
   
    }


}