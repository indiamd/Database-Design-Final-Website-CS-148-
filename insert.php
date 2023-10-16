<?php include 'top.php';
  
function getData($field) {
   if (!isset($_POST[$field])) {
       $data= "";
   }
   else{
       $data = trim($_POST[$field]);
       $data = htmlspecialchars($data);
   }
   return $data;
}
 
function verifyAlphaNum($testString) {
   return (preg_match ("/^([[:alnum:]]|-|\.| |\'|&|;|#)+$/", $testString));
}

$artId= (isset($_GET['artId'])) ? (int) htmlspecialchars($_GET['artId']) : 0;
 
$firstName= '';
$lastName= '';
$email= '';
$method= '';
$comments= '';
$artId=0;
$action =0;
$interestId=0;
$enteredBy = $netId;

$saveData = true;

 
 if(isset ($_POST['btnSubmit'])){
    $interestId= (isset($_POST['intId'])) ? (int) htmlspecialchars($_POST['intId']) : 0;
    $action= (isset($_POST['action'])) ? (int) htmlspecialchars($_POST['action']) : 0;
}
else{
    $interestId= (isset($_GET['intId'])) ? (int) htmlspecialchars($_GET['intId']) : 0;
    $action= (isset($_GET['action'])) ? (int) htmlspecialchars($_GET['action']) : 0;
}
$interestId= (isset($_GET['intId'])) ? (int) htmlspecialchars($_GET['intId']) : 0;
$action= (isset($_GET['action'])) ? (int) htmlspecialchars($_GET['action']) : 0;


//for listing in select list
$sqlArt = 'SELECT fldName, pmkArtId 
FROM tblArt';

$dataArt = '';
$artList = $thisDatabaseReader->select($sqlArt, $dataArt);

//and for populating form with record info
$sqlArt2 = 'SELECT pmkArtId, fldName, fnkEmail, pmkInterestId, fnkArtId, fldMethod, fldComments, fldFirstName, fldLastName, pmkEmail
FROM tblArtBuyer
JOIN tblArt ON pmkArtId = fnkArtId
JOIN tblBuyer ON pmkEmail = fnkEmail
WHERE pmkInterestId= ?
ORDER BY pmkInterestId';

$dataArt2 = array($interestId);
$artList2 = $thisDatabaseReader->select($sqlArt2, $dataArt2);

//print $thisDatabaseReader->displayQuery($sqlArt, $dataArt);

//set non-default values from records
if ($interestId !=0){
    if (is_array($artList2)){
        foreach($artList2 as $art){
            if ($interestId == $art['pmkInterestId']){
                $firstName= $art['fldFirstName'];
                $lastName= $art['fldLastName'];
                $email= $art['fnkEmail'];
                $method= $art['fldMethod'];
                $comments = $art['fldComments'];
            }
        }
    }
}



?>
 
<main>
<article class="contact">
<section class=validate>

<h2> <?php 
    if ($action == 1) {
        print 'Update';
    }
    else if ($action== 2){
        print 'Delete';
    } 
    else {
        print 'Insert';
        } ?>
    Art Interest Info</h2>
    

<?php
    if ($interestId !=0){
        print '<p class = "back"><a href= https://idavis1.w3.uvm.edu/cs148/final/admin/update-delete.php> Back </a></p>';
    }

        if(isset($_POST['btnSubmit'])) {

            if(DEBUG){
                print '<p>POST array: </p><pre>';
                print_r($_POST);
                print '</pre>';
            }

 
            //sanitize data
            $firstName= getData("txtFirstName");
            $lastName= getData("txtLastName");
            $email= filter_var($_POST['txtEmail'], FILTER_SANITIZE_EMAIL);
            $artId= getData("lstArt");
            $method= getData("radMethod"); 
            $comments= getData('txtComments');
            
 
   //validate data
 
   if ($firstName =="") {
       print '<p class="feedback"> *Please enter your first name</p>';
       $saveData=false;
   }
   else if(!verifyAlphaNum($firstName)){
       print '<p class="feedback"> *Please use letters/numbers only in your response </p>';
       $saveData=false;
   }
 
   if ($lastName =="") {
       print '<p class="feedback"> *Please enter your last name</p>';
       $saveData=false;
   }
   else if(!verifyAlphaNum($lastName)){
       print '<p class="feedback"> *Please use letters/numbers only in your response';
       $saveData=false;
   }
 
   if ($email =="" OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
       print '<p class="feedback"> *Please enter a valid email </p>';
       $saveData=false;
   }
 
   if ($method =="") {
       print '<p class="feedback"> *Please select a pickup method </p>';
       $saveData=false;
   }
 
 
   if ($saveData){
       //updating
       if ($action==1){
           try{
            $sql = 'UPDATE tblArtBuyer SET ';
            $sql .= 'fnkEmail = ?, ';
            $sql .= 'fldMethod = ?, ';
            $sql .= 'fldComments = ?,';
            $sql .= 'fldEnteredBy = ? ';
            $sql .= 'WHERE pmkInterestId = ?';

            $data = array();
            $data[] = $email;
            $data[] = $method;
            $data[] = $comments;
            $data[] = $enteredBy;
            $data[] = $interestId;

            $thisDatabaseWriter->update($sql, $data);

            if (DEBUG) {
                print $thisDatabaseReader->displayQuery($sql, $data);
            }

            $sql2 = 'UPDATE tblBuyer SET ';
            $sql2 .= 'fldFirstName = ?, ';
            $sql2 .= 'fldLastName = ?, ';
            $sql2 .= 'WHERE pmkEmail = ?';

            $data2 = array();
            
            $data2[] = $firstName;
            $data2[] = $lastName;
            $data2[] = $email;

            $thisDatabaseWriter->update($sql2, $data2);

            if(DEBUG) {
                print $thisDatabaseReader->displayQuery($sql2, $data2);
            }

            print '<p class=feedback>Your record has been updated!</p>';
        }
        catch (PDOException $e){
            print '<p class="mistake"> </p>';   
        }
           
       }
    

        //if deleting
        else if ($action == 2){
            try{
                $sql = 'DELETE FROM tblArtBuyer WHERE pmkInterestId = ?';

                $data = array($interestId);
                $thisDatabaseWriter->delete($sql, $data);

                if (DEBUG) {
                    print $thisDatabaseReader->displayQuery($sql, $data);
                }

                print '<p class=feedback>Your record has been deleted!</p>';
            }
            catch (PDOException $e){
                print '<p class="mistake"></p>';   
            }
        }


        //if inserting
        else{
            try{
                $sql = 'INSERT INTO tblArtBuyer SET ';
                $sql .= 'fnkArtId = ?, ';
                $sql .= 'fnkEmail = ?, ';
                $sql .= 'fldMethod = ?, ';
                $sql .= 'fldComments = ?, ';   
                $sql .= 'fldEnteredBy = ?';


                $data = array();
                $data[] = $artId;
                $data[] = $email;
                $data[] = $method;
                $data[] = $comments;
                $data[] = $enteredBy;

                $thisDatabaseWriter->insert($sql, $data);


                if (DEBUG) {
                    print $thisDatabaseReader->displayQuery($sql, $data);
                }

                $sql2 = 'INSERT INTO tblBuyer SET ';
                $sql2 .= 'pmkEmail = ?, ';
                $sql2 .= 'fldFirstName = ?, ';
                $sql2 .= 'fldLastName = ?';

                $sql2 .= 'ON DUPLICATE KEY UPDATE ';
                $sql2 .= 'fldFirstName = ?, ';
                $sql2 .= 'fldLastName = ?';

                $data2 = array();
                $data2[] = $email;
                $data2[] = $firstName;
                $data2[] = $lastName;

                $data2[] = $firstName;
                $data2[] = $lastName;

                $thisDatabaseWriter->insert($sql2, $data2);

                if(DEBUG) {
                    print $thisDatabaseReader->displayQuery($sql2, $data2);
                }

                print '<p class=feedback>Thank you for your interest!</p>';
            }
            catch (PDOException $e){
                print '<p class="mistake"></p>';   
            }
        }


        }
    }


?>
</section>
 
 
<form action ="#"
   method= "POST">


        <input type= "hidden" name="intId" value="<?php print $interestId ?>"> 
        <input type= "hidden" name="artId" value="<?php print $artId?>">
        <input type= "hidden" name="enteredBy" value="<?php print $enteredBy?>">
 
<fieldset class="text">
   <legend>Enter Your information:</legend>
   <p>
   <label for="txtFirstName"> First Name: </label>
   <input type="text" name="txtFirstName" id="txtFirstName" <?php if ($action ==2){print 'readonly';}?> value= "<?php print $firstName; ?>">
   </p>
   <p>
   <label for="txtLastName"> Last Name:</label>
   <input type="text" name="txtLastName" id="txtLastName" <?php if ($action ==2){print 'readonly';}?> value= "<?php print $lastName; ?>">
   </p>
   <p>
   <label for="txtEmail" class="emailLabel"> Email: </label>
   <input type="text" name="txtEmail" id="txtEmail" <?php if ($action>0){print 'readonly';}?> value= "<?php print $email; ?>">
   </p>
</fieldset>  
 
<fieldset class= "selectList">
        <legend>Art Piece:</legend>
        <p>
        <select name= "lstArt" size="36" <?php if ($action ==2){print 'readonly';}?>>
            <?php
            if (is_array($artList)){
                foreach($artList as $art){
                    print '<option ';
                    print 'value="' . $art['pmkArtId']. '" ';
                    if ($artId == $art['pmkArtId']) {
                        print 'selected';
                    }  
                    print '>'; 
                    print $art['fldName'] .'</option>';
                }
            }
            ?>
            </select>
        </p>
 </fieldset>

 
<fieldset class="radio">  
   <legend>How would you like to take home your art:</legend>
   <p>
       <input type="radio" name="radMethod" id="pickup" <?php if ($action==2){print 'readonly';}?> value="pickup" <?php if ($method == "pickup") print 'checked'; ?>>
       <label for="pickup">Live in the area and can pick it up</label>
   </p>
   <p>
       <input type="radio" name="radMethod" id="dropoff" <?php if ($action==2){print 'readonly';}?> value="dropoff" <?php if ($method == "dropoff") print 'checked'; ?>>
       <label for="dropoff">Live in the area and need it dropped off</label>
   </p>
   <p>
       <input type="radio" name="radMethod" id="ship" <?php if ($action ==2){print 'readonly';}?> value="ship" <?php if ($method == "ship") print 'checked'; ?>>
       <label for="ship">Live out of the area and need it shipped</label>
   </p>
   <p>
       <input type="radio" name="radMethod" id="other" <?php if ($action ==2){print 'readonly';}?> value="other" <?php if ($method == "other") print 'checked'; ?>>
       <label for="other">Other</label>
   </p>
</fieldset>

    
<fieldset class= "textArea">
   <legend>Comments</legend>
   <p>
       <textarea name="txtComments" rows="4" cols="30"><?php print $comments?></textarea>
   </p>
</fieldset>
 
<fieldset>
            <p class="submit">
                <input type="submit" value=
                <?php if($action==1){
                    print '"Update"';
                }
                elseif($action==2){
                    print '"Delete"';
                }
                else{
                    print '"submit" ';
                } ?>
                name="btnSubmit">
            </p>
        </fieldset>
 
 
</form>
</article>
</main>
 
<?php include '../footer.php'; ?>
 
</body>
 
