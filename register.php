    <?php
        $title = "Register";
        require_once('header.php');
        
        define('MM_UPLOADPATH','images/Mismatch_profiles/'); // 
        
        function createSerial($length){
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
        
        if (isset($_POST['submit'])){
          
          if ($_FILES['picture']['error']==0){
              $name = MM_UPLOADPATH.$_FILES['picture']['name'];
              $filename = MM_UPLOADPATH.$_POST['username']."-".createSerial(5).".".pathinfo($_FILES['picture']['name'],PATHINFO_EXTENSION);
              //echo $filename;
              //El archivo se subio correctamente
              if(move_uploaded_file($_FILES['picture']['tmp_name'],MM_UPLOADPATH.$_FILES['picture']['name'])){
                  @unlink($_FILES['picture']['tmp_name']);
                 //El archivo se ha guardado correctamente en nuetro sitio web
                 $success = 2;
                 $successmsg2 = "<span class=success2'>El archivo se subio correctamente</span>";
              } else {
                 //Ha habido algún problema
                 $error = 4;
                 $errormsg = "<span class='error4'>Error al subir  el archivo al server...</span>";
              }
          } 
            
          if (isset($_POST['username']) && isset($_POST['firstname'])
                   && isset($_POST['lastname'])  && isset($_POST['password'])) {
            
            $user = $_POST['username'];
            $pass = sha1($_POST['password']);
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $gender = $_POST['gender'];
            $birthdate = $_POST['birthdate'];
            $city = $_POST['city'];
            $state = $_POST['state'];
            $picture = str_replace('images/Mismatch_profiles/','',$name);
            
            $sql = "INSERT INTO `users` VALUES (null,:user,:pass,0,:firstname,:lastname,:gender,:birthdate,:city,:state,:picture);";
            $stmt = $con->prepare($sql);
            
            $stmt->bindValue(':user',$user);
            $stmt->bindValue(':pass',$pass);
            $stmt->bindValue(':firstname',$firstname);
            $stmt->bindValue(':lastname',$lastname);
            $stmt->bindValue(':gender',$gender);
            $stmt->bindValue(':birthdate',$birthdate);
            $stmt->bindValue(':city',$city);
            $stmt->bindValue(':state',$state);
            $stmt->bindValue(':picture',$picture);
            
            $stmt->execute();
            
            echo 'Usuario registrado';
          } 
        }
    ?>
  
    <div class="container">
        
        <span class="error">
            <?php 
                echo $errormsg;
            ?>
        </span>
        
        <div class="row">
            
            <div class="col-md-4"></div>
            <div class="col-md-4">
            
            <form class="register" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
                <h2>Sign up</h2>
                <div class="row g-3">
                  <div class="col-sm">
                    <input type="text" class="form-control" id="username"  name="username" placeholder="Username" required>
                  </div>
                  <br/>
                  <div class="col-sm">
                    <input type="text" class="form-control" id="firstname"  name="firstname" placeholder="Firstname" required>
                  </div>
                </div>
                <br/>
                <div class="row g-3">
                  <div class="col-sm">
                    <input type="text" class="form-control" id="lastname"  name="lastname" placeholder="Lastname" required>
                  </div>
                  <br/>
                  <div class="col-sm">
                    <input type="text" class="form-control" id="city"  name="city" placeholder="City" required>
                  </div>
                </div>
                <br/>
                <div class="row g-3">
                  <div class="col-sm">
                    <input type="text" class="form-control" id="state"  name="state" placeholder="State" required>
                  </div>
                  <br/>
                  <div class="col-sm">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required><input type="checkbox" onclick="myFunction()">Show Password
                    <script>
                        function myFunction() {
                          var x = document.getElementById("password");
                          if (x.type === "password") {
                            x.type = "text";
                          } else {
                            x.type = "password";
                          }
                        }
                    </script>
                  </div>
                </div>
                <br/>
                <div class="row g-3">
                    <div class="col-sm">
                        <label for="date">Birthdate:</label>&nbsp;
                        <input type="date" name="birthdate" id="birthdate">
                        <br/><br/>
                        <p>Gender:&nbsp;
                            <input type="radio" name="gender" value="1" checked="checked"/>Male&nbsp;
                            <input type="radio" name="gender" value="2"/>Female
                        </p>
                    
                        <p>Profile picture:</p>
                        <input type="hidden" name="MAX_FILE_SIZE" value="900000"/>
                        <input type="file" name="picture" id="picture"/>
                    </div>
                </div>
                <br/>
                <div class="pushright">
                    <input type="submit" name="submit" id="submit" class="btn btn-primary" value="SIGN UP">
                </div>
            </form>
            
            </div>
            <div class="col-md-4"></div>
            
        </div>
         
    </div>
    
    <?php
        require_once('footer.php');
    ?> 