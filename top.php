<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content= "India Davis">
        <meta name="description" content="cs 148">

        <title>CS 148</title>

        <link rel = "stylesheet"
            href = "../css/custom.css?version=<?php print time(); ?>"
            type = "text/css">
        <link rel = "stylesheet" media = "(max-width:800px)"
            href = "../css/custom-tablet.css?version=<?php print time(); ?>"
            type = "text/css">
        <link rel = "stylesheet" media = "(max-width:600px)"
            href = "../css/custom-phone.css?version=<?php print time(); ?>"
            type = "text/css">
        
            
    

    <?php
            include '../lib/constants.php';

            require_once(ADMIN_LIB_PATH . '/Database.php');

            $thisDatabaseReader = new Database('idavis1_reader', DATABASE_NAME);
            $thisDatabaseWriter = new Database('idavis1_writer', DATABASE_NAME);

            $netId = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");
           

            $sql = 'SELECT pmkNetId
            FROM tblAdminInfo
            WHERE pmkNetId=?';

            $data = array($netId);
            $admins = $thisDatabaseReader->select($sql, $data);

            $adminStatus= false;

            if (is_array($admins)){
                foreach ($admins as $admin){
                    if ($netId == $admin['pmkNetId']){
                        $adminStatus = true;
                    }
                }
            }


        if ($adminStatus == false){
            print "Sorry you do not have permission to view this page";
            die();
        }

            print '</head>';



            print '<body class="grid-layout" id= "' . PATH_PARTS ['filename'] . '">';

            print '<!-- ***** START OF BODY ***** -->';

                print PHP_EOL;

            include 'header.php';
            print PHP_EOL;

            include 'nav.php';
            print PHP_EOL;
            
            print '<p class="exit_button"> <a href="../index.php">Exit Admin Mode</a></p>';
        ?>