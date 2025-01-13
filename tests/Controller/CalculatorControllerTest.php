<?php
// tests/Controller/CalculatorControllerTest.php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CalculatorControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Calculatrice');
    }

    public function testCalculate(): void
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/calculate',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'first' => 10,
                'second' => 5,
                'operator' => '+'
            ])
        );

        $this->assertResponseIsSuccessful();
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(15, $response['result']);
    }

    public function testInvalidCalculation(): void
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/calculate',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'first' => 10,
                'second' => 0,
                'operator' => '/'
            ])
        );

        $this->assertResponseStatusCodeSame(400);
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('error', $response);
    }
}