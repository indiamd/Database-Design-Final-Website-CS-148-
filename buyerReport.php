<?php 
include 'top.php';


$sqlBuyer = 'SELECT pmkArtId, fldName, fldFirstName, fnkArtId, fnkEmail, fldLastName, pmkEmail, fldEnteredBy, fldMethod
FROM tblArtBuyer
JOIN tblArt ON pmkArtId=fnkArtId
JOIN tblBuyer ON pmkEmail=fnkEmail
ORDER BY fldLastName';

$dataBuyer = '';
$buyer = $thisDatabaseReader->select($sqlBuyer, $dataBuyer);

print '<main>';

print '<h2>Records</h2>';

if (is_array($buyer)){
    print '<table>
    <tr>
    <th>Last Name</th>
    <th>First Name</th>
    <th>Email</th>
    <th>Art Piece</th>
    <th>Delivery Method</th>
    <th>Edited/Entered By</th>
    </tr>';

    foreach($buyer as $person){
        print '<tr>';
        print '<td>' . $person['fldLastName'] . '</td>';
        print '<td>' . $person['fldFirstName'] . '</td>';
        print '<td>' . $person['pmkEmail'] . '</td>';
        print '<td>' . $person['fldName'] . '</td>';
        print '<td>' . $person['fldMethod'] . '</td>';
        print '<td>' . $person['fldEnteredBy'] . '</td>';
        print '</tr>';
    }
    print '</table>';
}

print '</main>';

include '../footer.php';

print '</body>';
?>