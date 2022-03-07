<?php

    class DBConnection{
        
        private $host = DB_HOST;
        private $user = DB_USER;
        private $pass = DB_PASS;
        private $dbname = DB_NAME;
        
        private $dbh;
        
        private $error = '';
        
        public function __construct(){
            // Set DSN
            $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname;
            // Set options
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            // Create a new PDO instance
            try{
                $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            }
            // Catch any errors
            catch(PDOException $e){
                $this->error = $e->getMessage();
                echo $this->error;
            }
            return $this->error;
        }
        
        //Cierra la conexión la BBDD
        public function __destruct(){
            $this -> dbh = NULL;
        }
        
        public function __toString() {
            return $this->error;
        }
        
        public function getCon() {
            return $this->dbh;
        }
        
        /**Function getQuery
        *Ejecuta un consulta que devuelve un resultset
        *@param sql string sentencia con la consulta sql tipo SELECT
        *@return resultset array asociativo con las tuplas y campos devueltos por la consulta
        */
        public function getQuery($sql){ //getter para las consultas que devuelven un resultset
            try{
                $resultset = $this->dbh->query($sql);
                $resultset->setFetchMode(PDO::FETCH_ASSOC);
            }catch(PDOException $e){
                echo __LINE__ . $e->getMessage();
            }
            return $resultset;
        }
        
        /**Function runQuery
        *Ejecuta una consulta de tipo INSERT, UPDATE o DELETE
        *@param sql string sentencia con la consulta sql tipo INSERT, UPDATE o DELETE
        *@return num_tuplas int número de tuplas afectadas por la consulta
        */
        public function runQuery($sql){ //getter para las consultas que devuelven un nº de filas afectadas
            $num_tuplas = 0;
            try{
                $num_tuplas = $this->dbh->exec($sql);
            }catch(PDOException $e){
                echo __LINE__ . $e->getMessage();
            }
            return $num_tuplas;
        }
        
    }

?>

