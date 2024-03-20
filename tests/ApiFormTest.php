<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Csrf\CsrfTokenManager;

class ApiFormTest extends ApiTestCase
{
    const string FORM_URL = '/api/contact/form';
    const string FORM_METHOD = 'POST';

    public function testSuccessRequest(): void
    {
        $response = static::createClient()->request(self::FORM_METHOD, self::FORM_URL, ['json' =>
            [
                'fullName' => 'John Cena',
                'email' => 'test@test.com',
                'message' => 'Testowa wiadomosc',
                'consent' => true,
            ],
            'headers' => [
                'content-type' => 'application/json',
                'accept' => '*/*'
            ]
        ]);

        $responseData = json_decode($response->getContent(), true);

        $this->assertResponseStatusCodeSame(201);
        $this->assertArrayHasKey('id', $responseData);
        $this->assertIsNumeric($responseData['id']);
    }

    public function testFailureRequest(): void
    {
        $response = static::createClient()->request(self::FORM_METHOD, self::FORM_URL, ['json' =>
            [
                'fullName' => 'John Cena',
                'email' => 'test@test.com',
                'message' => 'Testowa wiadomosc',
                'consent' => false,
            ],
            'headers' => [
                'content-type' => 'application/json',
                'accept' => '*/*'
            ]
        ]);

        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonContains(['errors' => []]);
    }
}
