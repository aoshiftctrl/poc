<?php

/**
 * Filename: share__link.php
 * The class file for shared link
 * PHP Version 5.x
 *
 * @category Controllers
 * @package  ShareLink
 * @author   Rej <rej@cctrl.de>
 * @license  CC Attribution 3.0 Unported http://creativecommons.org/licenses/by/3.0/legalcode
 * @link     foo
 */

/**
 * ShareLink
 * A class for the shared links
 *
 * @category Controllers
 * @package  ShareLink
 * @author   Rej <rej@cctrl.de>
 * @license  CC Attribution 3.0 Unported http://creativecommons.org/licenses/by/3.0/legalcode
 * @link     foo
 */
class ShareLink
{

    public $Link;


    /**
     * GenerateLink
     *
     * Generates a link for the public webpost
     *
     * @return (string) (link)
     */
    function _construct()
    {

        $this->link = substr(md5(uniqid(rand())), 0, 5);
        return $this->link;

    }//end _construct()


}//end class
