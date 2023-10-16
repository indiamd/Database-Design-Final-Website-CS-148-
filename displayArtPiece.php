<?php include 'top.php';

//initialize variables
$artId= (isset($_GET['artId'])) ? (int) htmlspecialchars($_GET['artId']) : 0;

$sql = 'SELECT pmkArtId, fldName, fldType, fldDescription, fldWidth, fldHeight, fldDepth, fldPrice, fldImage, fldImage2
FROM tblArt
Where pmkArtId = ?
ORDER BY fldWidth';

$data = array($artId);
$arts = $thisDatabaseReader->select($sql, $data);

?>

<main>
    <?php   

        if (is_array($arts)){
            foreach($arts as $art){
                print '<p class="button_fixed"> <a href="artInterest.php?artId=' . $art['pmkArtId'] . '">Purchase this art</a></p>';
                print '<h2 class= "artPieceName">' . $art['fldName'] . '</h2>';
                print '<section class="grid-layout"><figure>';

                if ($art['fldType']=='Sculpture'){
                    print '<div class="slideshow-container">
                    <div class="slides">';
                }
                
                print '<img alt="'. $art['fldName'] . '" src="images/' . $art['fldImage'] . '">';   

                if ($art['fldType']=='Sculpture'){
                    print '</div>
                    <div class="slides">
                    <img alt="'. $art['fldName'] . '" src="images/' . $art['fldImage2'] . '"></div>
                    <a class="prev" onclick="plusSlides(-1)">❮</a>
                    <a class="next" onclick="plusSlides(1)">❯</a>
                    </div>';
                } 

                if ($art['fldType']=='Sculpture'){
                    print '
                        <script>
                        let slideIndex = 1;
                        showSlides(slideIndex);
                        
                        function plusSlides(n) {
                            showSlides(slideIndex += n);
                        }
                        
                        function currentSlide(n) {
                            showSlides(slideIndex = n);
                        }
                        
                        function showSlides(n) {
                            let i;
                            let slides = document.getElementsByClassName("slides");
                            if (n > slides.length) {slideIndex = 1}    
                            if (n < 1) {slideIndex = slides.length}
                            for (i = 0; i < slides.length; i++) {
                            slides[i].style.display = "none";  
                            }
                            slides[slideIndex-1].style.display = "block";  
                        }
                        </script> ';


                    }

                print '</figure>';
                

                print '<section class="info"><p class="description">' . $art['fldDescription'] . '</p>'; 
                print '<p class="size">' . $art['fldWidth'] . 'x' . $art['fldHeight'];
                if ($art['fldDepth'] != 0)print 'x' . $art['fldDepth'];
                print '</p>'; 
                print '<p class="price">$' . $art['fldPrice'] . '</p></section></section>';
                

                
        }

        
    }


    ?>  

        
</main>
<?php
include 'footer.php';
?>

    </body>

