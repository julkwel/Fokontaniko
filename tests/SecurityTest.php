<?php
/**
 * @author Julkwel <julienrajerison5@gmail.com>.
 *
 * Fokontaniko project 2020
 */

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class SecurityTest.
 */
class SecurityTest extends WebTestCase
{
    const GET = 'GET';

    /**
     * Test if homepage response is 200
     *
     * @dataProvider providersUrl
     *
     * @param string $url
     */
    public function testHomePage(string $url)
    {
        $client = static::createClient();
        $client->request(self::GET, $url);

        self::assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * @return array
     */
    public function providersUrl()
    {
        return [
          ['/'],
          ['/login'],
        ];
    }

    /**
     * Test if link in homepage is exist and clickable
     */
    public function testLink()
    {
        $client = static::createClient();
        $crawler = $client->request(self::GET, '/');
        $link = $crawler->filter('a.btn-get-started')->link();

        $client->click($link);
        self::assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * Test failure login
     */
    public function testFailureLogin()
    {
        $client = self::createClient();
        $crawler = $client->request(self::GET,'/login');

        $form = $crawler->filter('button#form_submit')->form();
        $form['userName'] = 'failed';
        $form['password'] = 'failed';

        $client->submit($form);

        self::assertTrue($client->getResponse()->isRedirect('/login'));
    }
}
