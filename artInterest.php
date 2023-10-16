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

 
$firstName= '';
$lastName= '';
$email= '';
$method= '';
$comments= '';
$enteredBy = 'online';

$saveData = true;

 
if(isset ($_POST['btnSubmit'])){
    $artId= (isset($_POST['artId'])) ? (int) htmlspecialchars($_POST['artId']) : 0;
}
else{
    $artId= (isset($_GET['artId'])) ? (int) htmlspecialchars($_GET['artId']) : 0;
}


$sql = 'SELECT pmkArtId, fldName
FROM tblArt
Where pmkArtId= ? ';

$data = array($artId);

$artToBuy= $thisDatabaseReader->select($sql, $data);


?>
 
<main>
<article class="contact">
<section class=validate>
<?php
        if (is_array($artToBuy)){
            foreach($artToBuy as $art){
                print '<h2>Interest form for ' . $art['fldName'] . '</h2>';
            }
        }

        if(isset($_POST['btnSubmit'])) {
            if (DEBUG){
                print '<p>POST array: </p><pre>';
                print_r($_POST);
                print '</pre>';
        }

            
            //sanitize data
            $firstName= getData("txtFirstName");
            $lastName= getData("txtLastName");
            $email= filter_var($_POST['txtEmail'], FILTER_SANITIZE_EMAIL);
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
 
   if ($lastName ==" ") {
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

   if($thisDatabaseWriter->insert($sql, $data)){
       print '<p> success</p>';
   }


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

    $to = $email;
                    $from = 'Bob Davis Art Portfolio <idavis1@uvm.edu>';
                    $subjcet = 'Bob Davis Art Contact';

                    $mailMessage = '<p style="font: 14pt serif;"> Thank you for your interest with Bob Davis art. He will reach out to you shortly about your desired artwork!</p>';

                    $headers = "MIME_Version: 1.0\r\n";
                    $headers .= "Content-type: text/html; charset=utf-8\r\n";
                    $headers .= "From: " . $from. "r\n";

                    $mailSent = mail($to, $subject, $mailMessage, $headers);
                    

    if(DEBUG) {
        print $thisDatabaseReader->displayQuery($sql2, $data2);
    }

    print '<p class=feedback>Thank you for your interest!</p>';
   }
}

?>
</section>

<p class = "back"><a href= <?php print 'https://idavis1.w3.uvm.edu/cs148/final/displayArtPiece.php?artId=' . $artId;?>>Back</a></p>

<form action ="<?php print PHP_SELF; ?>" id="frmInterest" method= "POST">

    <input type= "hidden" name="artId" value="<?php print $artId ?>"> 
    <input type= "hidden" name="enteredBy" value="<?php print $enteredBy?>">

<fieldset class="text">
   <legend>Enter Your information:</legend>
   <p>
   <label for="txtFirstName"> First Name: </label>
   <input type="text" name="txtFirstName" id="txtFirstName" value= "<?php print $firstName; ?>">
   </p>
   <p>
   <label for="txtLastName"> Last Name:</label>
   <input type="text" name="txtLastName" id="txtLastName"  value= "<?php print $lastName; ?>">
   </p>
   <p>
   <label for="txtEmail" class="emailLabel"> Email: </label>
   <input type="text" name="txtEmail" id="txtEmail" value= "<?php print $email; ?>">
   </p>
</fieldset>  
 
 
 
 
<fieldset class="radio">  
   <legend>How would you like to take home your art:</legend>
   <p>
       <input type="radio" name="radMethod" id="pickup" value="pickup" <?php if ($method == "pickup") print 'checked'; ?>>
       <label for="pickup">Live in the area and can pick it up</label>
   </p>
   <p>
       <input type="radio" name="radMethod" id="dropoff" value="dropoff" <?php if ($method == "dropoff") print 'checked'; ?>>
       <label for="dropoff">Live in the area and need it dropped off</label>
   </p>
   <p>
       <input type="radio" name="radMethod" id="ship" value="ship" <?php if ($method == "ship") print 'checked'; ?>>
       <label for="ship">Live out of the area and need it shipped</label>
   </p>
   <p>
       <input type="radio" name="radMethod" id="other" value="other" <?php if ($method == "other") print 'checked'; ?>>
       <label for="other">Other</label>
   </p>
</fieldset>

    
<fieldset class= "textArea">
   <legend>Comments</legend>
   <p>
       <textarea name="txtComments" rows="4" cols="30"><?php print $comments?></textarea>
   </p>
</fieldset>
 
<p class="submit">
<input type="submit" value="submit" name="btnSubmit">
</p>
 
 
</form>
</article>
</main>
 
<?php include 'footer.php'; ?>
 
</body>
 
