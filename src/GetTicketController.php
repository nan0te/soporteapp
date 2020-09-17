<?php 

include_once __DIR__.'/config/config.php';


    class GetTicketController {

        public function tojson() {

            $conn = new mysqli(HOSTDB, USERDB, PASSWDDB, DATABASE);
            
            $query = "SELECT t.idticket, ti.code, p.account, th.subject, th.message, ti.state, tl.date from ticket t JOIN ticket_info ti ON t.ticket_info_id = ti.idticket_info JOIN ticket_log tl ON t.ticket_log_id = tl.idticket_log JOIN type_help th ON t.type_help_id = th.idtype_help JOIN person_info p ON t.type_help_person_info_id = p.idperson_info";
            $result = $conn->query($query);
            $dbdata = array();

            while ( $row = $result->fetch_assoc() ) {
                $dbdata[] = $row;
            }

            print_r(json_encode($dbdata));
        }
    }
?>