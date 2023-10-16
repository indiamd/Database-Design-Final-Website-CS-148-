<nav class="admin-nav">

    <a class="<?php
    if (PATH_PARTS['filename']=="insert"){
        print 'activePage';
    }
    ?>" href="insert.php">Insert New</a>

    <a class="<?php
    if (PATH_PARTS['filename']=="update"){
        print 'activePage';
    }
    ?>" href="update-delete.php">Update/Delete</a>

    <a class="<?php 
        if (PATH_PARTS['filename']=="buyerReport"){
            print 'activePage';
        }
        ?>" href="buyerReport.php">Buyer Report</a>

<a class="<?php 
        if (PATH_PARTS['filename']=="artReport"){
            print 'activePage';
        }
        ?>" href="artReport.php">Art Report</a>

</nav>

