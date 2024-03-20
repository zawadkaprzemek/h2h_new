<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class ContactListTest extends ApiTestCase
{
    public function testSomething(): void
    {
        $response = static::createClient()->request('GET', '/api/contact/list',[
            'headers' => [
                'content-type' => 'application/json',
                'accept' => '*/*'
            ]
        ]);

        $responseData = json_decode($response->getContent(), true);
        $this->assertResponseIsSuccessful();
        $this->assertIsArray($responseData);

    }
}
