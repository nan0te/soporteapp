
<?php 
/**
* Copyright (c) 2020 Nobile Carlos Daniel <crlsdnlnobile@gmail.com>. All rights reserved. 
* This file is part of soporteapp.
* Released under the GPL3 license
* https://opensource.org/licenses/GPL-3.0
**/

    class db {

        protected $connection;
	    protected $query;
        protected $show_errors = TRUE;
        protected $query_closed = TRUE;
        public $query_count = 0;
        public $result;
        public $nrows;
        
        public function __construct($dbhost, $dbuser, $dbpass, $dbname, $charset) {
            $this->connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
            if ($this->connection->connect_error) {
                $this->error('Failed to connect to MySQL/MariaDB - ' . $this->connection->connect_error);
            }
            $this->connection->set_charset($charset);
            
        }

        public function exec_query($query) {
                 
            $this->result = $this->connection->query($query); 
            if(!$this->result) { 
                echo "query failed: (" . $this->connection->errno . ") " . $this->connection->error; 
            }
            $this->nrows = $this->result->num_rows;
            return $this->result->fetch_object();
        }

        public function call_procedure($query) {
            $this->query = $this->connection->query($query); 
            if(!$this->query) { 
                echo "query failed: (" . $this->connection->errno . ") " . $this->connection->error; 
            }

        }

        public function lastInsertID() {
            return $this->connection->insert_id;
        }

        public function numRows() {
            $this->query->store_result();
            return $this->query->num_rows;
        }

        public function close() {
            return $this->connection->close();
        }
    }



?>