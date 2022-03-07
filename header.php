<?php
    require_once('functions.php');
    require_once('settingsDB.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <title>MistMatch - <?php echo $title ?></title>
  </head>
  <body>
      
    <?php
    /*
        if (isset($_SERVER['PHP_AUTH_USER'])){
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo'Texto para mandar si el usuario pulsa el boton Cancel'; exit;
        } else {
            echo "<p>Hello {$_SERVER['PHP_AUTH_USER']}</p>";
            echo"<p>You entered {$_SERVER['PHP_AUTH_PW']} as your password.</p>";
        }
    */
    /*
    $sql = "SELECT * FROM `users` WHERE user_id = :userid;";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(':userid',$_SESSION['user_id']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);*/
    
    ?>
   
   <div class="container-fluid" >
        <div class="row">
           <header>
                <div class="logo"><!--Hello /*<?php echo $row['user_firstname']?>*/--></div> 
                <nav>
                    <?php
                        // $logged = func::checkLogin($con);
                        $logged = func::checkLogin($con);
                        $script = $_SERVER['PHP_SELF'];
                        //echo "Script: ".$script; 
                        if ( $script == '/PHP/MisMatch/login.php' || $script == '/PHP/MisMatch/register.php' || $script == '/PHP/MisMatch/view.php'
                                || $script == '/PHP/MisMatch/edit.php' || $script == '/PHP/MisMatch/question.php' || $script == '/PHP/MisMatch/mymismatch.php'
                                || $script == '/PHP/MisMatch/profile.php' ||  $script == '/PHP/MisMatch/index.php' && $logged==true) {
                            $url="location.href='index.php'";
                            $value="Home";
                            //echo $url; exit;
                        }
                         if ( $script == '/PHP/MisMatch/index.php' && $logged==false) {
                            $url="location.href='login.php'";
                            $value = 'Log in';
                            //echo $url; exit;
                        }
                        echo '<button onclick='.$url.' class="btn btn-primary" type="submit">'. $value .'</button>&nbsp;';
                        if ( $logged ) { ?>
                             <button onclick="location.href='view.php'" class="btn btn-primary" type="submit">View Profiles</button>&nbsp; 
                             <button onclick="location.href='edit.php'" class="btn btn-primary" type="submit">Edit my profile</button>&nbsp; 
                             <button onclick="location.href='question.php'" class="btn btn-primary" type="submit">Questionnaire</button>&nbsp; 
                             <button onclick="location.href='mymismatch.php'" class="btn btn-primary" type="submit">My Mismatch</button>&nbsp; 
                             <button onclick="location.href='logout.php'" class="btn btn-primary" type="submit">Log out</button> 
                        <?php
                        }
                       
                    ?>
                     
                </nav>
           </header>   
        </div>
    </div>