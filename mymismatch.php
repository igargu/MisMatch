<?php
    $title = "My Mismatch";
    require_once('header.php');
    
    
    $sql = "SELECT * FROM `mismatch_response` WHERE `user_id` = '".$_SESSION['user_id']."';";
    $resultset = $dbh -> getQuery($sql);
    $resultset->execute();
    
    $user_responses = 0;
    
    $questionnaire_answered = true;
    
    if ($resultset->rowCount() <= 0) {
        
        $questionnaire_answered = false;
        
    } else {
        
        $questionnaire_answered = true;
        
        while ($row = $resultset -> fetch()) {
            $user_responses = $user_responses + $row['response'];
        }
        
    }
    
    $sql = "SELECT * FROM `users` WHERE `user_status` = 0;";
    $resultset = $dbh -> getQuery($sql);
    $resultset->execute();
    
    $total_users = $resultset->rowCount();
    $i = 1;
    
    $other_user_responses = 0;
    
    $mistmatch_user = 0;
    $mistmatch_userid;
    
    while ($i <= $total_users) {
        
        $user_id = $i + 1;
        
        $sql = "SELECT * FROM `mismatch_response` WHERE `user_id` = '".$user_id."' AND `user_id` != '".$_SESSION['user_id']."';";
        $resultset = $dbh -> getQuery($sql);
        $resultset->execute();
        
        if ($resultset->rowCount() > 0) {
        
            while ($row = $resultset -> fetch()) {
                $other_user_responses = $other_user_responses + $row['response'];
            }
            
            $aux = $user_responses + $other_user_responses;
            
            if ($aux > $mistmatch_user) {
                
                $mistmatch_user = $aux;
                $mistmatch_userid = $user_id;
                
            }
            
        }
        
        $i++;
        
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
        
        <form class="myMismatch" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <h2>My Mismatch</h2>
            <br/>
            <?php 
                
                if ($questionnaire_answered == false) {
                    
                    echo 'Aún no has respondido el cuestionario';
                    
                } else {
                    
                    $sql = "SELECT * FROM `users` WHERE `user_id` = '".$mistmatch_userid."';";
                    $resultset = $dbh -> getQuery($sql);
                    $resultset->execute();
                    $row = $resultset -> fetch();
                    
                    echo '<h4>'.ucwords($_SESSION['username']).', your Mismatch is...</h4>';
                    echo '<br/><br/>';
                    echo '<h2>'.$row['user_firstname'].'&nbsp;'.$row['user_lastname'].'</h2><br/><br/>';
                    echo '<td><a href="/PHP/MisMatch/profile.php?Id='.$row['user_id'].'"> <img src=" images/Mismatch_profiles/'.$row['user_picture'].'" height="300"></a></td>';
                    
                    echo '<br/><br/><br/><br/><br/><br/><br/>';
                }
                
            ?>
            
            
        </div>
        <div class="col-md-12"></div>
        
    </div>

<?php
    require_once('footer.php');
?>

