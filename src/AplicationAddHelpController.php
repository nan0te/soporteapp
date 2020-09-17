<?php 
/**
* Copyright (c) 2020 Nobile Carlos Daniel <crlsdnlnobile@gmail.com>. All rights reserved. 
* This file is part of soporteapp.
* Released under the GPL3 license
* https://opensource.org/licenses/GPL-3.0
**/

include_once 'Subjects.php';
include_once 'AddHelpController.php';

    class AplicationAddHelpController {

        public function Run(){

            $getsub = new Subjects();
            $appAddHelp = new AddHelpController();
            $array = $getsub->arr_subject;
    
            foreach ($array as $subject) {
               
                $appAddHelp->AddHelpBySubject($subject, '1');
                $appAddHelp->AddHelpByMessage($subject, '1');
            } 
        }
    }
?>