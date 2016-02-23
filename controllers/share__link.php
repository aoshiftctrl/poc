<?php

class share__link{


  public $link;

  function generate__link(){

    $this->link = substr(md5 (uniqid (rand())), 0, 5);
    return $this->link;

  }


}

?>
