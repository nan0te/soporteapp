<?php 

/**
* Copyright (c) 2020 Nobile Carlos Daniel <crlsdnlnobile@gmail.com>. All rights reserved. 
* This file is part of soporteapp.
* Released under the GPL3 license
* https://opensource.org/licenses/GPL-3.0
**/


class ImapConnection {
    
    protected $mail;
    protected $account;
    protected $passwd;
    public $conn;

    public function __construct($mail, $account, $passwd) {
        
        $this->mail = $mail;
        $this->account = $account;
        $this->passwd = $passwd;
        
        switch ($mail) {
            case 'gmail':
                $this->mail = '{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX'; 
        }

        $this->conn = imap_open($this->mail, $this->account, $this->passwd);
 
        if($this->conn === false){
     
            throw new Exception(imap_last_error());
        }
            
         return $this->conn;
    }

  

    
    public function search_mail_unanswered($subject, $since) {
        
        $time = ' -' . $since . 'days';
        $search = 'UNANSWERED SUBJECT "'. $subject . '" SINCE "' . date("j F Y", strtotime($time)) . '"';
        $emails = imap_search( $this->conn, $search);

        if (empty($emails) ) {
            $subject = strtolower($subject);
            $search = 'UNANSWERED SUBJECT "'. $subject . '" SINCE "' . date("j F Y", strtotime($time)) . '"';
            $emails = imap_search($this->conn, $search);
        }

       else if (empty($emails) ) {
            $subject = ucwords($subject);
            $search = 'UNANSWERED SUBJECT "'. $subject . '" SINCE "' . date("j F Y", strtotime($time)) . '"';
            $emails = imap_search($this->conn, $search);
        }

        return $emails;
    }
    public function search_mail_unanswered_byBody($body, $since) {
        
        $time = ' -' . $since . 'days';
        $search = 'UNANSWERED BODY "'. $body . '" SINCE "' . date("j F Y", strtotime($time)) . '"';
        $emails = imap_search( $this->conn, $search);

        if (empty($emails) ) {
            $subject = strtolower($body);
            $search = 'UNANSWERED SUBJECT "'. $body . '" SINCE "' . date("j F Y", strtotime($time)) . '"';
            $emails = imap_search($this->conn, $search);
        }

        else if (empty($emails) ) {
            $subject = ucwords($body);
            $search = 'UNANSWERED SUBJECT "'. $body . '" SINCE "' . date("j F Y", strtotime($time)) . '"';
            $emails = imap_search($this->conn, $search);
        }

        return $emails;
    }

    public function search_mail($subject, $since) {
        
        $time = ' -' . $since . 'days';
        $search = 'SUBJECT "'. $subject . '" SINCE "' . date("j F Y", strtotime($time)) . '"';
        $emails = imap_search( $this->conn, $search);

        if (empty($emails) ) {
            $subject = strtolower($subject);
            $search = 'SUBJECT "'. $subject . '" SINCE "' . date("j F Y", strtotime($time)) . '"';
            $emails = imap_search($this->conn, $search);
        }

        else if (empty($emails) ) {
            $subject = ucwords($subject);
            $search = 'SUBJECT "'. $subject . '" SINCE "' . date("j F Y", strtotime($time)) . '"';
            $emails = imap_search($this->conn, $search);
        }

        return $emails;
    }


 public function close() {
        imap_close($this->conn);
    }
}

?>