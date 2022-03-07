<?php
    $title = "View Profiles";
    require_once('header.php');
    
    $sql = "SELECT * FROM `users` WHERE `user_status` = '0' ORDER BY `user_firstname` ASC LIMIT 6;";
    $resultset = $dbh -> getQuery($sql);
    $affectedrows = $resultset -> rowCount();
        if ($affectedrows == 0){
            $error = 2;
            $errormsg = "<span class='error'>No profiles</span>";
        }
?>

<div class="container">
        
    <span class="error">
        <?php 
            echo $errormsg;
        ?>
    </span>
    
    <div class="row">
        
        <div class="col-md-12"></div>
        <div class="col-md-12">
          
        <form class="view">
          <h2>Last profiles</h2>
          <table class="table">
            <?php
            // echo '<tr><td>'.$row['user_username'].'</td></tr>';
              $cont = 0;
              while($row = $resultset -> fetch()){
                if ($cont == 3) {
                    echo '<tr></tr>';
                    $cont = 0;
                  }
                  if (empty($row['user_picture'])){
                    echo'<td><a href="/PHP/MisMatch/profile.php?Id='.$row['user_id'].'"> <img src=" images/Mismatch_profiles/noProfilePicture.png" height="230"></a> '.$row['user_firstname'].' '.$row['user_lastname'].'</td>';
                  }else {
                    echo'<td><a href="/PHP/MisMatch/profile.php?Id='.$row['user_id'].'"> <img src=" images/Mismatch_profiles/'.$row['user_picture'].'" height="230"></a> '.$row['user_firstname'].' '.$row['user_lastname'].'</td>';
                  }
                  $cont++;
              }
            ?>
          </table>
          
        </form>
        
        </div>
        <div class="col-md-12"></div>
        
    </div>


<?php
    require_once('footer.php');
?>