<?php
    class func {
        /*
         * Function that checks if a user is logged in
         * @dbh DBConecction Instance
         */
        public static function checkLogin($con) {
            if (!isset($_SESSION)) {
                ini_set( 'session.cookie_httponly',1);
                session_start();
            }
            if (isset($_COOKIE['user_id'])&&isset($_COOKIE['token'])&&isset($_COOKIE['serial'])) {
                $user_id = $_COOKIE['user_id'];
                $token = $_COOKIE['token'];
                $serial = $_COOKIE['serial'];
                
                $query = "SELECT * FROM sessions WHERE session_userid = :userid AND session_token = :token AND session_serial = :serial;";
                $stmt = $con->prepare($query);
                $stmt->execute(array(':userid' => $user_id, ':token' => $token, ':serial' => $serial));
                
                if ($stmt->rowCount() > 0) {
                    $token = func::createSerial(40);
                    
                    setcookie('$token', $token, time()+86400, '/');
                    
                    $sql = "DELETE FROM `sessions` WHERE `session_userid` = :session_userid;";
                    $stmt = $con->prepare($sql);
                    $stmt->bindValue(':session_userid',$user_id);
                    $stmt->execute();
                    
                    func::createSession($_COOKIE['user_id'],$_COOKIE['username'],$_COOKIE['token'],$_COOKIE['serial']);
                    
                    $sql = "INSERT INTO `sessions` VALUES (null,:session_token,:session_serial,:session_date,:session_userid); ";
                    
                    $stmt = $con->prepare($sql);
                    
                    $stmt->bindValue(':session_token',$token);
                    $stmt->bindValue(':session_serial',$serial);
                    $stmt->bindValue(':session_date',date('Y-m-d'));
                    $stmt->bindValue(':session_userid',$user_id);
                    
                    $stmt->execute();
                    
                    return true;
                }
                
            } else {
                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];
                    $token = $_SESSION['token'];
                    $serial = $_SESSION['serial'];
                    
                    $query = "SELECT * FROM sessions WHERE session_userid = :userid AND session_token = :token AND session_serial = :serial;";
                    $stmt = $con->prepare($query);
                    $stmt->execute(array(':userid' => $user_id, ':token' => $token, ':serial' => $serial));
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($row > 0) {
                        return true;
                    }
                }
            }
            
            return false;
        }
        
        public function createCookies($user_id,$username,$token,$serial) {
            // Crear Cookie
            setcookie('user_id', $user_id, time()+86400, '/');
            setcookie('username', $username, time()+86400, '/');
            setcookie('token', $token, time()+86400, '/');
            setcookie('serial', $serial, time()+86400, '/');
            
            /*
            // Acceder a la Cookie
            echo $_COOKIE['Prueba'];
            */
        }
        
        public function deleteCookies() {
            // Borrar Cookie
            setcookie('user_id', null, time()-3600, '/');
            setcookie('username', null, time()-3600, '/');
            setcookie('token', null, time()-3600, '/');
            setcookie('serial', null, time()-3600, '/');
        }
        
        public static function createSerial($length) {
            $frase = "El1Ho2Mb3Re4De5Ne6Gr7Oh8Ui9Aa0Tr1Av2Es3De4Ld5Es6Ie7Rt8Oy9El0P1iS2tO3l4Er5Oi6Ba7En8Po9Sd0Ee1L";
            $serial = '';
            $s = '';
            mt_srand (time());
            for ($i = 1; $i <= $length; $i++){
                $num = mt_rand(1, 20);
                $s = substr($frase, $num, 1);
                $serial = $serial . $s;
            }
            return $serial;
        }
        
        public static function createSession($user_id,$username,$token,$serial) {
            //session_start();
            
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['token'] = $token;
            $_SESSION['serial'] = $serial;
        }
        
        public static function recordSession($con,$user_id,$username,$rememberMe) {
            // Borrar si existe la sesisón del usuario en la tabla SESSIONS
            $sql = "SELECT * FROM `sessions` WHERE `session_userid` = :session_userid;";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':session_userid',$user_id);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $sql = "DELETE FROM `sessions` WHERE `session_userid` = :session_userid;";
                $stmt = $con->prepare($sql);
                $stmt->bindValue(':session_userid',$user_id);
                $stmt->execute();
            }
            // Creamos un nuevo token y serial
            $token = func::createSerial(40);
            $serial = func::createSerial(40);
            // Si ha chequeado rememberMe hacemos la sesión persistente
            if ($rememberMe == 1) {
                func::createCookies($user_id,$username,$token,$serial);
            }    
            // Creamos la sesión
            func::createSession($user_id,$username,$token,$serial);
            // Grabamos la nueva sesión en la BBDD
            $sql = "INSERT INTO `sessions` VALUES (null,:session_token,:session_serial,:session_date,:session_userid); ";
            
            $stmt = $con->prepare($sql);
            
            $stmt->bindValue(':session_token',$token);
            $stmt->bindValue(':session_serial',$serial);
            $stmt->bindValue(':session_date',date('Y-m-d'));
            $stmt->bindValue(':session_userid',$user_id);
            
            $stmt->execute();
        }
    }