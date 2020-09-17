<?php

/**
* Copyright (c) 2020 Nobile Carlos Daniel <crlsdnlnobile@gmail.com>. All rights reserved. 
* This file is part of soporteapp.
* Released under the GPL3 license
* https://opensource.org/licenses/GPL-3.0
**/

include_once __DIR__.'/src/templates/template_head.php';
include_once __DIR__.'/src/templates/template_body.php';
include_once 'app.php';

 printf('<!DOCTYPE html>');
 printf('<html lang="es">');
 $head = new template_head();
 $body = new template_body();
 print('</html>');
 $app = new App();


?>