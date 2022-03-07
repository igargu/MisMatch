<?php
    $title = "Edit my profile";
    require_once('header.php');
    
    $sql = "SELECT * FROM `users` WHERE user_id = :userid;";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(':userid',$_SESSION['user_id']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (isset($_POST['submit'])){
            
        if (isset($_POST['username']) && isset($_POST['firstname']) && isset($_POST['lastname']) 
                && isset($_POST['city']) && isset($_POST['state'])
                && isset($_POST['birthdate']) && isset($_POST['gender'])) {
            
            
            $user = $_POST['username'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $gender = $_POST['gender'];
            $birthdate = $_POST['birthdate'];
            $city = $_POST['city'];
            $state = $_POST['state'];
            
            $sql = "UPDATE `users`
                    SET user_username = :user, user_firstname = :firstname, 
                        user_lastname = :lastname, user_gender = :gender, user_birthdate = :birthdate, 
                        user_city = :city, user_state = :state
                    WHERE user_id = :user_id;";
            $stmt = $con->prepare($sql);
            
            $stmt->bindValue(':user_id',$_SESSION['user_id']);
            $stmt->bindValue(':user',$user);
            $stmt->bindValue(':firstname',$firstname);
            $stmt->bindValue(':lastname',$lastname);
            $stmt->bindValue(':gender',$gender);
            $stmt->bindValue(':birthdate',$birthdate);
            $stmt->bindValue(':city',$city);
            $stmt->bindValue(':state',$state);
            
            $stmt->execute();
            
            setcookie('username', $user, time()+86400, '/');
            
        } else {
            // Error
            $error=1;
            $errormsg = "No se pueden dejar campos vacíos";
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
            
            <form class="edit" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                <h2>Edit profile</h2>
                <div class="row g-3">
                  <div class="col-sm">
                    Username:<input type="text" class="form-control" id="username"  name="username" value="<?php echo $row['user_username'];?>" placeholder="Username" required>
                  </div>
                  <br/>
                  <div class="col-sm">
                    Firstname:<input type="text" class="form-control" id="firstname"  name="firstname" value="<?php echo $row['user_firstname'];?>" placeholder="Firstname" required>
                  </div>
                </div>
                <br/>
                <div class="row g-3">
                  <div class="col-sm">
                    Lastname:<input type="text" class="form-control" id="lastname"  name="lastname" value="<?php echo $row['user_lastname'];?>" placeholder="Lastname" required>
                  </div>
                  <br/>
                  <div class="col-sm">
                    City:<input type="text" class="form-control" id="city"  name="city" value="<?php echo $row['user_city'];?>" placeholder="City" required>
                  </div>
                </div>
                <br/>
                <div class="row g-3">
                  <div class="col-sm">
                    State:<input type="text" class="form-control" id="state"  name="state" value="<?php echo $row['user_state'];?>" placeholder="State" required>
                  </div>
                  <br/>
                </div>
                <br/>
                <div class="row g-3">
                    <div class="col-sm">
                        <label for="date">Birthdate:</label>&nbsp;
                        <input type="date" value="<?php echo explode(" ",$row['user_birthdate'])[0];?>" name="birthdate" id="birthdate">
                        <br/><br/>
                        <p>Gender:&nbsp;
                            <?php
                                if ($row['user_gender'] == 1) {
                                    echo '<input type="radio" name="gender" value="1" checked="checked"/>Male&nbsp;
                                          <input type="radio" name="gender" value="2"/>Female
                                        ';
                                } else {
                                    echo '<input type="radio" name="gender" value="1"/>Male&nbsp;
                                          <input type="radio" name="gender" value="2" checked="checked"/>Female
                                        ';
                                }
                            ?>
                        </p>
                    </div>
                </div>
                <br/>
                <div class="pushright">
                    <input type="submit" name="submit" id="submit" class="btn btn-primary" value="SAVE CHANGES">
                </div>
            </form>
            
            </div>
            <div class="col-md-4"></div>
            
        </div>

<?php
    require_once('footer.php');
?>