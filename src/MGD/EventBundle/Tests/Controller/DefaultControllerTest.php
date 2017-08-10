<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 08/08/2017
 * Time: 15:17
 */

namespace MGD\EventBundle\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /** We check if the menu "Evénements" is selected (class active) */
    public function testIndexGoodLinkActive() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/events/');

        $this->assertEquals("Evénements", $crawler->filterXPath('//li[@class="active"]')->children()->first()->text());
    }

    /**
     * We check if there's at least one event on the page
     */
    public function testIndexMultipleEvents() {
        $client = static::createClient();

        $crawer = $client->request('GET', '/events/');

        $this->assertTrue($crawer->filter('.thumbnail-event')->count() > 0);
    }

    /**
     * We check that if we click on an event, we're redirected to the good page (at least, the page redirects to the page where
     * the title is the name of the event
     */
    public function testIndexLinks() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/events/');

        $eventLink = $crawler->filter('.main-content .thumbnail-event a')->first();
        $eventTitle = $eventLink->children()->last()->text();
        $crawler = $client->click($eventLink->link());

        $this->assertEquals(1, $crawler->filter('h1:contains("'.$eventTitle.'")')->count());
    }
}
