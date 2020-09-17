<?php

/**
* Copyright (c) 2020 Nobile Carlos Daniel <crlsdnlnobile@gmail.com>. All rights reserved. 
* This file is part of soporteapp.
* Released under the GPL3 license
* https://opensource.org/licenses/GPL-3.0
**/

include_once './src/AplicationAddHelpController.php';
include_once './src/ResponseEmailController.php';
include_once './src/AplicationGenerateTicketHelp.php';
include_once './src/GetTicketController.php';

  class App {

    public function __construct() {

        $appAddHelp = new AplicationAddHelpController();
        $appAddHelp->Run();

        $responseMails = new ResponseEmailController();
        $responseMails->ResponseEmail();

        $appgthc = new AplicationGenerateTicketHelp();
        $appgthc->Run();

        echo '<script type="text/javascript">
        window.location = "http://localhost/soporteapp/tickets/tickets.php"
        </script>';
        die();
     
        
    }
  }
 
?>
