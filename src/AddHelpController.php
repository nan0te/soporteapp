<?php
/**
* Copyright (c) 2020 Nobile Carlos Daniel <crlsdnlnobile@gmail.com>. All rights reserved. 
* This file is part of soporteapp.
* Released under the GPL3 license
* https://opensource.org/licenses/GPL-3.0
**/

include_once 'databaseconnection.php';
include_once 'ImapConnection.php';
include_once  __DIR__.'/config/config.php';

    class AddHelpController {
 
        public function AddHelpBySubject($subject, $since) {
            
            $conn = new mysqli(HOSTDB, USERDB, PASSWDDB, DATABASE);
            $imap = new ImapConnection('gmail', USERNAME, PASSWD);
            

            $emails = $imap->search_mail_unanswered($subject, $since);

            if(!empty($emails)) { 

                    foreach($emails as $email){
                        
                        $overview = imap_fetch_overview($imap->conn, $email, 0);
                        $overview = $overview[0];    
                        $message = imap_fetchbody($imap->conn, $email, 1, FT_PEEK);
                        
                        $q = 'SELECT idtype_help FROM type_help th JOIN person_info p ON th.person_info_id = p.idperson_info WHERE p.account="' . $overview->from . '" AND th.subject="' . strtoupper($overview->subject) . '"';
                        
                        if ( $result = $conn->query($q) ) {
                            $nrows = $result->num_rows;
                    
                            if( $nrows === 0 ) {
                                $stmt = $conn->prepare("CALL addhelp(?, ?, ?)");
                                $stmt->bind_param('sss', $from, $sub, $msg);
                                
                                $from = $overview->from;
                                $sub = strtoupper($overview->subject);
                                $msg = $message;

                                $stmt->execute();
                            }
                        }
                                         
                    }    
            }

          //  else echo 'No hay email nuevos' . PHP_EOL ;
                  
            $conn->close();
            $imap->close();
        }

        public function AddHelpByMessage($subject, $since) {
                 
            $conn = new mysqli(HOSTDB, USERDB, PASSWDDB, DATABASE);        
            $imap = new ImapConnection('gmail', USERNAME, PASSWD);

            $emails = $imap->search_mail_unanswered_byBody($subject, $since);

            if(!empty($emails)) { 

                    foreach($emails as $email){
                        
                        $overview = imap_fetch_overview($imap->conn, $email, 0);
                        $overview = $overview[0];    
                        $message = imap_fetchbody($imap->conn, $email, 1, FT_PEEK);

                        $q = "SELECT idtype_help FROM type_help th JOIN person_info p ON th.person_info_id = p.idperson_info WHERE p.account={$overview->from} AND th.message=" . $message;
                         
                        if ( $result = $conn->query($q) ) {
                            $nrows = $result->num_rows;
                            if( $nrows === 0 ) {
                                $stmt = $conn->prepare("CALL addhelp(?, ?, ?)");
                                $stmt->bind_param('sss', $from, $sub, $msg);
                                
                                $from = $overview->from;
                                $sub = strtoupper($overview->subject);
                                $msg = $message;

                                $stmt->execute();
                            }
                        }
                    }    
                }

          //  else  echo 'No hay email nuevos' . PHP_EOL ;
                  
            $conn->close();
            $imap->close();
        }
    }
?>