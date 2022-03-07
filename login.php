    <?php
        $title = "Login";
        require_once('header.php');
            
        if (!func::checkLogin($con)) {
            
            if (isset($_POST['submit'])){
            
                if (isset($_POST['username']) && isset($_POST['password'])) {
                    $user = $_POST['username'];
                    $pass = sha1($_POST['password']);
                    
                    $sql = "SELECT * FROM `users` WHERE `user_username` = :user AND `user_password` = :pass;";
                    
                    $stmt = $con->prepare($sql);
                    
                    $stmt->bindValue(':user',$user);
                    $stmt->bindValue(':pass',$pass);
                    
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($row && $row['user_id'] > 0){
                        $remember = 0;
                        if (isset($_POST['rememberMe'])) {
                            $remember = 1;
                        }
                        func::recordSession($con,$row['user_id'],$user,$remember);
                        // Redirigimos a index.php
                        header('location:index.php');
                    } else {
                        // Error
                        $error=1;
                        $errormsg = "Usuario o contraseña no válidas";
                    }
                    
                } else {
                    // Error
                    $error=1;
                    $errormsg = "El usuario no existe";
                }
            } 
            
        } else {
            // Redirigimos a index.php
            header('location:index.php');
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
                
                <form class="login" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                    <h2>Login Form</h2>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="username"  name="username" placeholder="Username" required>
                        <label for="floatingInput">Username</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        <br/><input type="checkbox" class="form-check-input" id="showPassword" name="showPassword" onclick="myFunction()">Show password
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
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div class="form-container">
                        <div class="mb-3 form-check  mt30">
                            <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
                            <label class="form-check-label" for="exampleCheck1">Remember Me</label>
                        </div>
                        <div class="">
                            <i class="bi bi-arrow-bar-right">&nbsp;</i><a href="register.php" class="link-info">Sign Up</a>
                        </div>
                    </div>
                    <div class="pushright">
                        <input type="submit" name="submit" id="submit" class="btn btn-primary" value="LOG IN">
                    </div>
                </form>
            
            </div>
            <div class="col-md-4"></div>
        </div>
         
    </div>
    
    <?php
        require_once('footer.php');
    ?> 