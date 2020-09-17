<?php

/**
* Copyright (c) 2020 Nobile Carlos Daniel <crlsdnlnobile@gmail.com>. All rights reserved. 
* This file is part of soporteapp.
* Released under the GPL3 license
* https://opensource.org/licenses/GPL-3.0
**/


include_once 'ImapConnection.php';
include_once 'BodyMessages.php';
include_once 'SendMail.php';
include_once  __DIR__.'/config/config.php';

    class GenerateTicketHelpController {

        public $code;

        public function getCode() {

            $conn = new mysqli(HOSTDB, USERDB, PASSWDDB, DATABASE);
            $query = "SELECT idticket FROM ticket ORDER BY idticket DESC LIMIT 1";
            $hash = 'N000000';

            if( $res = $conn->query($query) ) {

               while( $obj = $res->fetch_object() ) {
                $this->code = $hash . $obj->idticket;
               }
            }
           
            $conn->close();
            return $this->code;   
     
        }

        public function GenerateTicket($subject, $since) {

            $conn = new mysqli(HOSTDB, USERDB, PASSWDDB, DATABASE);
            $imap = new ImapConnection('gmail', USERNAME, PASSWD);

            if($imap->conn === false){
     
                throw new Exception(imap_last_error());
            }
           
            $emails = $imap->search_mail($subject, $since);

            if(!empty($emails)) { 

                $cod = $this->getCode();

                    foreach($emails as $email){
                        
                        $overview = imap_fetch_overview($imap->conn, $email, 0);
                        $overview = $overview[0];    
                        $message = imap_fetchbody($imap->conn, $email, 1, FT_PEEK);
                
                        $q = 'SELECT idtype_help,message FROM type_help WHERE subject="'. strtoupper($overview->subject) . '" and  person_info_id=(SELECT idperson_info from person_info where account="' . $overview->from . '" )'; 
                       
                        if( $res = $conn->query($q) ) {
                    
                            $nrows = $res->num_rows;
                                
                            if( $nrows === 1 ) {
   
                                    $cod = $this->getCode();
                                    $obj = $res->fetch_object();
                                    $id  = $obj->idtype_help; 
                                    $res->free();
                                    $qq = "SELECT idticket FROM ticket where type_help_id={$id}";

                                    if ( $res = $conn->query($qq) ) {

                                        $nrows = $res->num_rows;

                                        if ($nrows == 0) {
                                            $res->free();
                                            $query = 'CALL addticket("' . $cod . '", "NO",' . $id . ')';
                                            $res = $conn->query($query);
                                        }

                                     //   else  echo 'No se ha generado ningun ticket' . PHP_EOL;
                       
                                    }
                            }
                        }
                    }    
                }

           // else echo 'No se ha recibido ningun mail' . PHP_EOL ;
                  
            $conn->close();
            $imap->close();       
        }

        public function Response_mail_ticket() {

            $conn = new mysqli(HOSTDB, USERDB, PASSWDDB, DATABASE);
            $query = "SELECT rt.idresponse_ticket,th.subject,p.account FROM response_ticket rt JOIN type_help th ON rt.ticket_type_help_id=th.idtype_help JOIN person_info p ON th.person_info_id = p.idperson_info";
        
            $array_id = array();

            if ($res = $conn->query($query)) {
                while ( $obj = $res->fetch_object() ) {
                    $to = explode(" ", $obj->account);
                    $s = array("<",">");
                    $a = str_replace($s,"",$to[2]);

                    $body_messages = new BodyMessages();
                    $sender = new SendMail($a,"", 'No contestar este mensaje.', $body_messages->automaticGenerateTicket);
                    $sender->send_mail();
                    
                    array_push($array_id, ($obj->idresponse_ticket));
                }
                $res->free_result();
            }

            foreach ( $array_id as $_id ) {
            
                $q = "DELETE FROM response_ticket WHERE idresponse_ticket={$_id}";
                 $res = $conn->query($q);
                  
            }

            $conn->close();
        }
    }

?>    