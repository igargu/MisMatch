<?php
    $title = "Questionnaire";
    require_once('header.php');
    
    $sql = "SELECT * FROM mismatch_response WHERE `user_id` = '".$_SESSION['user_id']."';";
    $resultset = $dbh -> getQuery($sql);
    $resultset->execute();
    
    $resultados = false;
    $updateQuestionResponseId = array();
    
    if ($resultset->rowCount() <= 0) {
    
    $sql = "SELECT * FROM mismatch_topic;";
    $resultset = $dbh -> getQuery($sql);
    
      while ($row = $resultset -> fetch()) {
      
        $sql = "INSERT INTO mismatch_response VALUES (null,".$_SESSION['user_id'].",".$row['topic_id'].",0);";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        
      } 
    
    }else {
      
      $sql = "SELECT * FROM mismatch_response WHERE `user_id` = '".$_SESSION['user_id']."';";
      $resultset = $dbh -> getQuery($sql);
      $resultset->execute();
    
      $questionResponseId = array();
      while($row = $resultset -> fetch()) {
        array_push($questionResponseId,$row['response']);
      }
      $resultados = true;
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
        <div class="col-md-12">
        
        <form class="questionary" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
          <?php
            $sql = "SELECT name, category_id FROM mismatch_category;";
            $resultset1 = $dbh -> getQuery($sql);
          ?>
            <h2>Questionnaire</h2>
            <?php
            $cont = 1;
            $cont1 = 0;
            $cont2 = 0;
            
            $key = 1;
            $val = 0;
            
            $row1 = $resultset1 -> fetch();
              while ($cont1 < 3) {
                echo '
                  <div class="row g-3">
                  ';
                  while ($cont2 < 2)  {
                    echo '
                      <div class="col-sm">
                        <fieldset>
                            <legend>'.$row1['name'].'</legend>
                            ';
                            $sql2 = "SELECT * FROM mismatch_topic WHERE `category_id` LIKE '".$row1['category_id']."';";
                            $resultset2 = $dbh -> getQuery($sql2);
                            while ($row2 = $resultset2 -> fetch()) {
                              if ($resultados){
                                
                                  echo '
                                  <div class="form-check">
                                    <label class="form-check-label label_questionnaire" for="flexCheckDefault">
                                      '.$row2['name'].':
                                    </label>';
                                      if($row2['topic_id']==$key && $questionResponseId[$val]==1) {
                                        
                                        echo '<input type="radio" id="radio_questionnaire_love" name="radio_questionnaire_'.str_replace(' ','_',$row2['name']).'" value="1" checked><label for="radio_questionnaire_love">&nbsp;&nbsp;Love&nbsp;&nbsp;</label>';
                                      } else {
                                        echo '<input type="radio" id="radio_questionnaire_love" name="radio_questionnaire_'.str_replace(' ','_',$row2['name']).'" value="1" ><label for="radio_questionnaire_love">&nbsp;&nbsp;Love&nbsp;&nbsp;</label>';
                                      }
                                      
                                      if($row2['topic_id']==$key && $questionResponseId[$val]==2) {
                                        
                                        echo '<input type="radio" id="radio_questionnaire_hate" name="radio_questionnaire_'.str_replace(' ','_',$row2['name']).'" value="2" checked><label for="radio_questionnaire_hate">&nbsp;&nbsp;Hate&nbsp;&nbsp;</label>';
                                      } else {
                                        echo '<input type="radio" id="radio_questionnaire_hate" name="radio_questionnaire_'.str_replace(' ','_',$row2['name']).'" value="2" ><label for="radio_questionnaire_hate">&nbsp;&nbsp;Hate&nbsp;&nbsp;</label>';
                                      }
                                echo '
                                   </div>
                                ';
                                
                              } else {
                                echo '
                                <div class="form-check">
                                  <label class="form-check-label label_questionnaire" for="flexCheckDefault">
                                    '.$row2['name'].':
                                  </label>
                                  <input type="radio" id="radio_questionnaire_love" name="radio_questionnaire_'.str_replace(' ','_',$row2['name']).'"><label for="radio_questionnaire_love">&nbsp;&nbsp;Love&nbsp;&nbsp;</label>
                                  <input type="radio" id="radio_questionnaire_hate" name="radio_questionnaire_'.str_replace(' ','_',$row2['name']).'"><label for="radio_questionnaire_hate">&nbsp;&nbsp;Hate&nbsp;&nbsp;</label>
                                </div>
                              ';
                              }
                              $key++;
                              $val++;
                            }  
                            echo'
                        </fieldset>
                      </div>';
                      $row1 = $resultset1 -> fetch();
                      $cont++;
                      if ($cont > 5){
                        echo'<div class="col-sm"></div>';
                        break;
                      }
                      $cont2++;
                  }
                  $cont2 = 0;
                      echo'
                  </div>
                  <br/>
                ';
                $cont1++;
              }
            ?>
            <div class="pushright">
                <input type="submit" name="submit" id="submit" class="btn btn-primary" value="SAVE QUESTIONNAIRE">
            </div>
        </form>
        
        </div>
        <div class="col-md-4"></div>
        
    </div>

<?php
    
    if (isset($_POST['submit'])) {
      
      $respuestas = '';
      
      $sql = "SELECT * FROM `mismatch_response` WHERE `topic_id` = 1 AND `user_id` = '".$_SESSION['user_id']."';";
      $resultset = $dbh -> getQuery($sql);
      $resultset->execute();
      $row = $resultset -> fetch();
      
      $key = $row['response_id'];
      $val = 0;
        
      $sql2 = "SELECT name FROM mismatch_topic WHERE `category_id`;";
      $resultset2 = $dbh -> getQuery($sql2);
      
      $i = 0;
      
      while ($i < 25) {
        
        $row2 = $resultset2 -> fetch();
        
        if (isset($_POST['radio_questionnaire_'.str_replace(' ','_',$row2['name']).''])) {
        
          if ($_POST['radio_questionnaire_'.str_replace(' ','_',$row2['name']).''] == 1) {
            
            array_push($updateQuestionResponseId,1);
            
          }elseif ($_POST['radio_questionnaire_'.str_replace(' ','_',$row2['name']).''] == 2) {
            
            array_push($updateQuestionResponseId,2);
            
          }
          
          $respuestas = 'Tus respuestas han sido enviadas, ¡refresca la página para verlas!';
        
        } else {
          
          $respuestas = 'No puedes dejar campos vacíos';
          
        }
        
        $i++;
        
      }
      
      $arrayLength = count($updateQuestionResponseId);
        
      while($val < $arrayLength) {
        
        $sql = "UPDATE mismatch_response SET `response` = '".$updateQuestionResponseId[$val]."' WHERE `response_id` = '".$key."' AND `user_id` = '".$_SESSION['user_id']."';";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        
        $key++;
        $val++;
        
      }
      
      echo $respuestas;
      
    }
    
    require_once('footer.php');
?>