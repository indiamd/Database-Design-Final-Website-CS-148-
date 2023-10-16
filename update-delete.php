<?php include 'top.php';

$sql = 'SELECT pmkArtId, fnkArtId, pmkInterestId, fldName, fnkEmail, pmkEmail, fldFirstName, fldLastName
FROM tblArtBuyer
JOIN tblArt ON pmkArtId=fnkArtId
JOIN tblBuyer ON pmkEmail=fnkEmail
ORDER BY fldLastName';

$donationId= (isset($_GET['artId'])) ? (int) htmlspecialchars($_GET['artId']) : 0;
$data = '';
$artBuyers = $thisDatabaseReader->select($sql, $data);

$action= (isset($_GET['action'])) ? (int) htmlspecialchars($_GET['action']) : 0;


?>

<main>
<h2>Update/Delete</h2>
<table>
<?php
        if (is_array($artBuyers)){
            print '<tr>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Art</th>
            <th>Email</th>
            <th></th>
            <th></th>
            </tr>';
            foreach($artBuyers as $artBuyer){
                print '<tr>';
                print '<td>' . $artBuyer['fldLastName'] . '     </td>';
                print '<td>' . $artBuyer['fldFirstName'] . '     </td>';
                print '<td>' . $artBuyer['pmkEmail'] . '     </td>';
                print '<td>' . $artBuyer['fldName'] . '     </td>';
                print '<td> <a href="insert.php?intId=' . $artBuyer['pmkInterestId'] .'&action=1"  class="updateBtn">Update</a></td>';
                print '<td> <a href="insert.php?intId=' . $artBuyer['pmkInterestId'] .'&action=2"  class="delBtn">Delete</a></td>';
                print '</tr>';
            }
        }
    ?>
</table>
</main>

<?php
include '../footer.php';

print '</body>';

?>