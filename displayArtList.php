<?php include 'top.php';

//initialize
$action = (isset($_GET['display'])) ? (int) htmlspecialchars($_GET['display']) : 0;

$sql = 'SELECT pmkArtId, fldType, fldName, fldImage, fldHeight 
FROM tblArt
WHERE fldType = "Drawing"
ORDER BY fldHeight';

$data = '';
$drawings = $thisDatabaseReader->select($sql, $data);

$sql2 = 'SELECT pmkArtId, fldName, fldType, fldImage, fldWidth
FROM tblArt
WHERE fldType = "Painting"
ORDER BY fldWidth';

$data2 = '';
$paintings = $thisDatabaseReader->select($sql2, $data2);

$sql3 = 'SELECT pmkArtId, fldName, fldType, fldImage, fldImage2
FROM tblArt
WHERE fldType = "Sculpture"
ORDER BY fldName';

$data3 = '';
$sculptures = $thisDatabaseReader->select($sql3, $data3);


?>

<main>
    <?php   

      if ($action == 1){
          print '<h2 class="gallery">Gallery </h2>
      
          <section class="pagenav">
          <p><a href="#drawings">Drawings</a></p>
          <p><a href="#paintings">Paintings</a></p>
          <p><a href="#boxes">Sculpture Boxes</a></p>
          </section>  
      
          
          <p class="toTop"><a href="https://idavis1.w3.uvm.edu/cs148/final/displayArtList.php?display=1#gallery">Back to Top</a></p>

          <article>
          <h3 class="headings" id="drawings">Drawings</h3>';
          print '<section class = "drawings">';
          if (is_array($drawings)){
            foreach($drawings as $drawing){
                print '<figure>
                <div class="container">
                  <img alt ="' . $drawing['fldName'] . '" src ="images/'. $drawing['fldImage'] . '">
                  <div class="overlay">
                    <div class="txt"><a href ="displayArtPiece.php?artId='. $drawing['pmkArtId'] .'">View</a></div>
                  </div>
                </div>';
                print '<figcaption>' . $drawing['fldName'] . '</figcaption></figure>';
            }
        }
        print '</section>';

          print '<h3 class="headings" id="paintings">Paintings</h3>';
          print '<section class = "paintings">';
          if (is_array($paintings)){
            foreach($paintings as $painting){
                print '<figure>
                <div class="container">
                <img alt ="' . $painting['fldName'] . '" src ="images/'. $painting['fldImage'] . '">
                <div class="overlay">
                <div class="txt">
                <a href ="displayArtPiece.php?artId='. $painting['pmkArtId'] . '">View
                </a></div>
                </div>
              </div>';
                print '<figcaption>' . $painting['fldName'] . '</figcaption></figure>';
            }
        }
        print '</section>';

          print '<h3 class="headings" id="boxes">Sculpture Boxes</h3>';
          print '<section class = "boxes">';
          if (is_array($sculptures)){
            foreach($sculptures as $sculpture){
                print '<figure>
                <div class="container">
                <img alt ="' . $sculpture['fldName'] . '" src ="images/'. $sculpture['fldImage'] . '">
                <div class="overlay">
                <div class="txt">
                <a href ="displayArtPiece.php?artId='. $sculpture['pmkArtId'] .'">View
                </a></div>
                </div>
              </div>';
                print '<figcaption>' . $sculpture['fldName'] . '</figcaption></figure>';
            }
        }  
        print '</section>';
          print '</article>';
          
        
      }

      else if ($action == 2){
            print '<h2>Drawings </h2> 
            <p class="back-gallery"><a href="gallery.php">Back</a></p>
            <article class="gallery">';
            print '<section class = "drawings">';
          if (is_array($drawings)){
            foreach($drawings as $drawing){
              print '<figure>
              <div class="container">
                <img alt ="' . $drawing['fldName'] . '" src ="images/'. $drawing['fldImage'] . '">
                <div class="overlay">
                  <div class="txt"><a href ="displayArtPiece.php?artId='. $drawing['pmkArtId'] .'">View</a></div>
                </div>
              </div>';
              print '<figcaption>' . $drawing['fldName'] . '</figcaption></figure>';
            }
           }
           print '</section>';
           print '</article>';

        }

     else if ($action ==3){
        print '<h2>Paintings</h2>
        <p class="back-gallery"><a href="gallery.php">Back</a></p>
        <article>';
        print '<section class = "paintings">';
        if (is_array($paintings)){
          foreach($paintings as $painting){
            print '<figure>
            <div class="container">
            <img alt ="' . $painting['fldName'] . '" src ="images/'. $painting['fldImage'] . '">
            <div class="overlay">
            <div class="txt">
            <a href ="displayArtPiece.php?artId='. $painting['pmkArtId'] . '">View
            </a></div>
            </div>
          </div>';
            print '<figcaption>' . $painting['fldName'] . '</figcaption></figure>';
          }
        
        }
        print '</section>';
        print '</article>'; 
      }

      else{
        print '<h2>Sculpture Boxes</h2>
        <p class="back-gallery"><a href="gallery.php">Back</a></p>
        <article>';
        print '<section class = "boxes">';
        if (is_array($sculptures)){
          foreach($sculptures as $sculpture){
            print '<figure>
            <div class="container">
            <img alt ="' . $sculpture['fldName'] . '" src ="images/'. $sculpture['fldImage'] . '">
            <div class="overlay">
            <div class="txt">
            <a href ="displayArtPiece.php?artId='. $sculpture['pmkArtId'] .'">View
            </a></div>
            </div>
          </div>';
            print '<figcaption>' . $sculpture['fldName'] . '</figcaption></figure>';
          }
          
          print '</section>';
          print '</article>';
      }
    }

    ?>          
        


</main>
<?php
include 'footer.php';
?>
</body>

