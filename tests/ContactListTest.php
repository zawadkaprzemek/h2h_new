<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class ContactListTest extends ApiTestCase
{
    public function testSomething(): void
    {
        $response = static::createClient()->request('GET', '/api/contact/list');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['list' => []]);
    }
}
