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


    class ResponseEmailController {

        public $a;

        public function getAccount($account) {

                $to = explode(" ",$account);
                $delete_str = array("<",">");
                $this->a = str_replace($delete_str,"",$to[2]);
                return $this->a;

        }

        public function ResponseEmail(){

            $conn = new mysqli(HOSTDB, USERDB, PASSWDDB, DATABASE);
         
            $query = "SELECT tt.subject,p.account,r.idresponse FROM response r JOIN type_help tt ON r.type_help_idtype_help = tt.idtype_help JOIN person_info p ON tt.person_info_id= p.idperson_info";
            $array_id = array();

            if ( $res = $conn->query($query) ){

                $body_messages = new BodyMessages();
                 
                while ( $obj = $res->fetch_object() ) {

                    $to = explode(" ", $obj->account);
                    $s = array("<",">");
                    $a = str_replace($s,"",$to[2]);

                        switch( $obj->subject ) {   
                            case "INGRESAR":          
                                $sender = new SendMail($a,'file.pdf', $obj->subject ,$body_messages->automaticresponse);
                                $sender->send_mail_attachment();  
                            break;
                            case "SUBIR TAREA":    
                                $sender = new SendMail($a,'file.pdf', $obj->subject ,$body_messages->automaticresponse);
                                $sender->send_mail_attachment(); 
                            break;
                            case "CORREGIR TAREA":                
                                $sender = new SendMail($a,'file.pdf', $obj->subject ,$body_messages->automaticresponse);
                                $sender->send_mail_attachment(); 
                            break;
                            case "ENVIAR MENSAJE":
                                $sender = new SendMail($a,'file.pdf', $obj->subject ,$body_messages->automaticresponse);
                                $sender->send_mail_attachment(); 
                            break;                                      
                        }
                    array_push($array_id, ($obj->idresponse));
                   
                }
                $res->free_result();
            }

            foreach ( $array_id as $_id ) {

                $query = "DELETE FROM response WHERE idresponse={$_id}";
                $res = $conn->query($query);
                            
            }
            $conn->close();
        }
    }


?>