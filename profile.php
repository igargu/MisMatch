<?php
    $title = "Opposites Atracks!";
    require_once('header.php');
    
    $sql = "SELECT * FROM `users` WHERE user_id = :userid;";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(':userid',$_GET['Id']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container">
        
        <span class="error">
            <?php 
                echo $errormsg;
            ?>
        </span>
        
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-12">
            <form class="profile" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
              <div class="profile_picture">
                <img src="images/Mismatch_profiles/<?php echo $row['user_picture'];?>" height="350">
              </div>
              <div>
                <h2>Profile</h2>
                <div class="row g-3">
                  <div class="col-sm">
                    Username:<input type="text" class="form-control" id="username"  name="username" value="<?php echo $row['user_username'];?>" readonly>
                  </div>
                  <br/>
                  <div class="col-sm">
                    Firstname:<input type="text" class="form-control" id="firstname"  name="firstname" value="<?php echo $row['user_firstname'];?>" readonly>
                  </div>
                </div>
                <br/>
                <div class="row g-3">
                  <div class="col-sm">
                    Lastname:<input type="text" class="form-control" id="lastname"  name="lastname" value="<?php echo $row['user_lastname'];?>" readonly>
                  </div>
                  <br/>
                  <div class="col-sm">
                    City:<input type="text" class="form-control" id="city"  name="city" value="<?php echo $row['user_city'];?>" readonly>
                  </div>
                </div>
                <br/>
                <div class="row g-3">
                  <div class="col-sm">
                    State:<input type="text" class="form-control" id="state"  name="state" value="<?php echo $row['user_state'];?>" readonly>
                  </div>
                  <br/>
                  <div class="col-sm">
                    Birthdate:<input type="text" class="form-control" id="birthdate" name="birthdate" value="<?php echo explode(" ",$row['user_birthdate'])[0];?>" readonly>
                  </div>
                </div>
                <br/>
                <div class="row g-3">
                    <div class="col-sm">
                        <p>Gender:&nbsp;
                            <?php
                                if ($row['user_gender'] == 1) {
                                    echo 'Male';
                                } else {
                                    echo 'Female';
                                }
                            ?>
                        </p>
                    </div>
                </div>
              </div>
            </form>
            </div>
            <div class="col-md-4"></div>
        </div>

<?php
    require_once('footer.php');
?>