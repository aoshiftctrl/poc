<?php

/**
 * Filename: sqlide__db.php
 * The class file for CRUD the sqlite db
 * PHP Version 5.x
 *
 * @category Controllers
 * @package  CrudDb
 * @author   Rej <rej@cctrl.de>
 * @license  CC Attribution 3.0 Unported http://creativecommons.org/licenses/by/3.0/legalcode
 * @link     foo
 */

/**
 * CrudDb
 * Does everything with the db
 *
 * @category Controllers
 * @package  CrudDb
 * @author   Rej <rej@cctrl.de>
 * @license  CC Attribution 3.0 Unported http://creativecommons.org/licenses/by/3.0/legalcode
 * @link     foo
 */
class CrudDb
{

    public $Db;
    public $Heute;
    public $Url = "http://www.domain.tld/";


    /**
     * _construct
     *
     * Generates the db file
     *
     * @return none
     */
    function __construct()
    {

        if (file_exists("db/journl.sqlite3") === false) {
            $this->Db = new PDO('sqlite:db/journl.sqlite3');
            // Set errormode to exceptions.
            $this->Db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $_sql = 'CREATE TABLE journl (
                id INTEGER PRIMARY KEY,
                datum DATE,
                txt TEXT,
                status BOOLEAN,
                link TEXT
                )';

            $this->Db->exec($_sql);
        } else {
            $this->Db = new PDO('sqlite:db/journl.sqlite3');
        }//end if

    }//end __construct()


    /**
     * InsertDb
     *
     * Writes post in the db
     *
     * @return none
     */
    function InsertDb()
    {

        $this->Db = new PDO('sqlite:db/journl.sqlite3');

        $this->Heute = time();
        $_sql        = 'INSERT INTO journl(datum, txt, status, link) VALUES ("'.$this->Heute.'", "'.$_POST["journl"].'", "0", "'.$this->Url.'");';

        $this->Db->exec($_sql);

    }//end InsertDb()


    /**
     * FetchDb
     *
     * Read the db
     *
     * @return none
     */
    function FetchDb()
    {

        $this->Db = new PDO('sqlite:db/journl.sqlite3');

        $SqliteQuery  = 'SELECT * FROM journl ORDER BY id DESC';
        $SqliteResult = $this->Db->query($SqliteQuery);

        while ($Entry = $SqliteResult->fetch()) {
            $_lnk = new ShareLink();

            echo "<article>";

            if (preg_match("/.jpg/", $Entry["txt"]) or preg_match("/.gif/", $Entry["txt"])) {
                echo "<img src=\"".$Entry['txt']."\" alt=\"\">";
            } else {
                echo "<h2>".$Entry['txt']."</h2>";
            }

              echo "<aside>";
              $DateSqliteResult = $Entry['datum'];
              $DateCurrent      = time();
              $diff = ($DateCurrent - $DateSqliteResult);

              $EntryDate = round(($diff / 60), 0);

            switch ($EntryDate) {
            case $EntryDate <= 59:
                echo "Vor ".$EntryDate." Min.";
                break;
            case $EntryDate <= 1439:
                echo "Vor ".round(($EntryDate / 60), 0)." Std.";
                break;
            case $EntryDate <= 7200:
                echo "Vor ".round(($EntryDate / 1440), 0)." Tag/e";
                break;
            default:
                echo gmdate("H:i - d.m.Y", $Entry['datum']);
                break;
            }

            echo "<p class=\"publiclink\">".$Entry["link"].$_lnk->_construct()."</p>";
            echo "</aside>";
            echo "<i class=\"ion-android-favorite-outline\"></i>";
            echo "<i class=\"ion-android-unlock active\"></i>";
            echo "<i class=\"ion-android-more-horizontal\"></i>";
            echo "<span class=\"clearfix\"></span>";
            echo "</article>";
        }//end while

    }//end FetchDb()


}//end class





if (empty($_POST["journl"]) === false) {
    $_insert = new CrudDb();
    $_insert->InsertDb();
}
