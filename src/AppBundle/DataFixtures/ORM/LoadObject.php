<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 03/05/2017
 * Time: 10:26
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;

abstract class LoadObject extends AbstractFixture
{
    public function getLoremIpsum($numberParagraphs = 5) {
        if (!is_integer($numberParagraphs)) {
            $numberParagraphs = 5;
        }


        return file_get_contents('http://www.loripsum.net/api/' . $numberParagraphs . '/decorate/link/ol', false);
    }
}