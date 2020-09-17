<?php

/**
* Copyright (c) 2020 Nobile Carlos Daniel <crlsdnlnobile@gmail.com>. All rights reserved. 
* This file is part of soporteapp.
* Released under the GPL3 license
* https://opensource.org/licenses/GPL-3.0
**/

include_once  __DIR__.'/config/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-6.1.7/src/Exception.php';
require 'PHPMailer-6.1.7/src/PHPMailer.php';
require 'PHPMailer-6.1.7/src/SMTP.php';

    class SendMail {

        private $host = HOST;
        private $SMTPAuth = SMTPAuth;
        private $username = USERNAME;
        private $passwd = PASSWD;
        private $port = PORT;

        private $from = FROM;
        private $to;
        private $filepath = PATH;
        private $namefile;
        private $subject;
        private $body;
        private $mail;
       
        public function __construct($to,$file,$subject,$body){

                $this->to = $to;
                $this->subject = $subject;
                $len = strlen($file);
                $this->namefile = $file;
                
                $this->body = $body;
                $this->mail = new PHPMailer(true);
               
        }

        public function send_mail_attachment() {

            try {

                $this->mail->isSMTP();                                           
                $this->mail->Host       = $this->host;                    
                $this->mail->SMTPAuth   = $this->SMTPAuth;                                   
                $this->mail->Username   = $this->username;                     
                $this->mail->Password   = $this->passwd;                               
                $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
                $this->mail->Port       = $this->port;                                    

      
                $this->mail->setFrom($this->username, 'institution/company name');
                $this->mail->addAddress($this->to, 'name to');
                
                
                $pdf = $this->filepath . $this->namefile;
                $this->mail->addAttachment( $pdf );
                
                
                $this->mail->isHTML(true);                                 
                $this->mail->Subject = $this->subject;
                $this->mail->Body    = $this->body;
                $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $this->mail->send();
               // echo 'Message has been sent';
            } catch (Exception $e) {
               // echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
            }
            
        }

        public function send_mail() {

            try {

                $this->mail->isSMTP();                                           
                $this->mail->Host       = $this->host;                    
                $this->mail->SMTPAuth   = $this->SMTPAuth;                                   
                $this->mail->Username   = $this->username;                     
                $this->mail->Password   = $this->passwd;                               
                $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
                $this->mail->Port       = $this->port;                                    

                $this->mail->setFrom($this->username, 'institution/company name');
                $this->mail->addAddress($this->to, 'name to');
                   
                $this->mail->isHTML(true);                                 
                $this->mail->Subject = $this->subject;
                $this->mail->Body    = $this->body;
                $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $this->mail->send();
              //  echo 'Message has been sent';
            } catch (Exception $e) {
              //  echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
            }
            
        }
    }