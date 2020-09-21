<?php 
/**
* Copyright (c) 2020 Nobile Carlos Daniel <crlsdnlnobile@gmail.com>. All rights reserved. 
* This file is part of soporteapp.
* Released under the GPL3 license
* https://opensource.org/licenses/GPL-3.0
**/

include_once 'Subjects.php';
include_once 'GenerateTicketHelpController.php';

    class AplicationGenerateTicketHelp {

        public function Run(){

            $getsub = new Subjects();
            $appgthc = new GenerateTicketHelpController();
            $array = $getsub->arr_subject;
    
            foreach ($array as $subject) {
                $appgthc->GenerateTicket($subject, '1');  
            } 
            $appgthc->Response_mail_ticket();
        }
    }
?>