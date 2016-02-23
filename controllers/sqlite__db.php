<?php
/*
____ sqlite3.x
*/

class crud__db{


  public $db;
  public $heute;


	function __construct(){

   if (!file_exists("db/journl.sqlite3")){

			$this->db = new PDO('sqlite:db/journl.sqlite3');
      // Set errormode to exceptions
      $this->db->setAttribute(PDO::ATTR_ERRMODE,
                              PDO::ERRMODE_EXCEPTION);

      $_sql = 'CREATE TABLE journl (
                id INTEGER PRIMARY KEY,
                datum DATE,
                txt TEXT,
                status BOOLEAN,
                link TEXT
                )';

      $this->db->exec($_sql);

    } else {

      $this->db = new PDO('sqlite:db/journl.sqlite3');

    }

  }

	function insert__db(){


		$this->db = new PDO('sqlite:db/journl.sqlite3');

    $this->heute = time();
  	$_sql = 'INSERT INTO journl(datum, txt, status, link)'.
          	'VALUES ("'.$this->heute.'", "'.$_POST["journl"].'", "0", "http://www.mlly.me/");'
          	;

		$this->db->exec($_sql);

	}

	function fetch__db(){

		$this->db = new PDO('sqlite:db/journl.sqlite3');

		$_sql = 'SELECT * FROM journl ORDER BY id DESC LIMIT 5';
		$_result = $this->db->query($_sql);

		while($_row = $_result->fetch()){

      // link class @share__link()
      //            $_lnk->generate__link()
      $_lnk = new share__link();

			  echo "<article>";
  		  echo "<h2>".$_row['txt']."</h2>";
  		  echo "<p>".$_row['link']."".$_lnk->generate__link()."</p>";
        echo "<aside>";
        $date1 = $_row['datum'];
        $date2 = time();
        $diff = $date2 - $date1;

        $datum = round($diff/60, 0);

        switch ($datum) {
          case $datum <= 59:
              echo "Vor " . $datum . " Min.";
            break;
          case $datum <= 1439:
              echo "Vor " . round($datum/60, 0) . " Std.";
            break;
          case $datum <= 7200:
              echo "Vor " . round($datum/1440, 0) . " Tag/en.";
            break;
          default:
            echo gmdate("H:i - d.m.Y", $_row['datum']);
            break;
        }
        echo "</aside>";
        echo "<i class=\"ion-android-favorite-outline\"></i>";
        echo "<i class=\"ion-android-share\"></i>";
        echo "<span class=\"clearfix\"></span>";
			echo "</article>";

		}

	}




}




 if (! empty($_POST["journl"])){
   $_insert = new crud__db();
   $_insert->insert__db();

 }


?>
