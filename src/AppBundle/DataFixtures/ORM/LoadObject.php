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
        $aContext = array(
            'http' => array(
                'proxy' => 'tcp://10.241.2.3:3129',
                'request_fulluri' => true,
            ),
        );
        $cxContext = stream_context_create($aContext);

        return file_get_contents('http://www.loripsum.net/api/' . $numberParagraphs . '/decorate/link/ol', false, $cxContext);
    }
}