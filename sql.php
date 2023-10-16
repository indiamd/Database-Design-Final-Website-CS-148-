<?php include 'top.php';?>

<h3> Create SQL Table </h3>

<pre>
CREATE TABLE tblArtwork(
        pmkArtId INT AUTO_INCREMENT PRIMARY KEY,
        fldTitle varchar(27),
        fldsize varchar(4)
     );  
</pre>

<h3>Populate table with data</h3>

<pre>
INSERT INTO tblArtwork
     (fldTitle, fldSize)
     VALUES

     ('Bike', 'Yes'),

     ('Costa Rican Church', '5x7'),

     ('Cow Tornado', '5x7')
     
     ('Chopping Wood', '6x6'),
     
     ('Elephant Tears', '8x8'),

     ('I Like Cats', '6x6'),

     ('Drawing With Cat', '4x8'),

     ('Day of the Dead Girls', '8x12'),

     ('Copperhead', '5x7')
     
     ('Yellow Backed Snipe Fly', '5x7')

     ('Ballerina Mouse', '5x7')

     ('Boll Weevill', '5x7')

     ('Dust Devils in Dogland', '4x8')

     ('Cow Dog and Beach Balls', '5x7')

     ('Ecuadorian Women', '6x9')

     ('Sea Bed', '5x7')

     ('Hula Hoop', '5x7')

     ('Sparkles and Frida', '5x7')

     ('Snake in Grass', '6x6')

     ('Forget the Cats', '8x10')

     ('Angel Fish', '5x7')

     ('Cat Holding the World', '5x7')
     ;
</pre>


<h3>Select Data for Display</h3>
      <pre>
     SELECT fldTitle, fldsize FROM tblArtwork
      </pre>


<h3>Create form table</h3>
    <pre>
    CREATE TABLE tblArtistContact(
    pmkPlasticSurveyId INT AUTO_INCREMENT PRIMARY KEY,
    fldFirstName VARCHAR(20),
    fldLastName VARCHAR(20),
    fldEmail VARCHAR(50),
    fldMethod VARCHAR(5),
    fldDrawing TINYINT(1),
    fldPainting TINYINT(1),
    fldBox TINYINT(1),
    fldArtPiece VARCHAR(25),
    fldComments TEXT;
    )
    </pre>


     </main>

     <?php include 'footer.php';?>
     </body>