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
        $response = static::createClient()->request(self::FORM_METHOD, self::FORM_URL, ['json'=>[
            'fullName' => 'John Cena',
            'email' => 'test@test.com',
            'message' => 'Testowa wiadomosc',
            'consent' => true,
        ]
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains(['message' => 'Dziękujemy za przesłaną wiadomość, niedługo odpowiemy na Państwa wiadomość ;)']);
    }

    public function testFailureRequest(): void
    {
        $response = static::createClient()->request(self::FORM_METHOD, self::FORM_URL, ['json'=>[
            'fullName' => 'John Cena',
            'email' => 'test@test.com',
            'message' => 'Testowa wiadomosc',
            'consent' => false,
        ]
        ]);

        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonContains(['errors' => []]);
    }
}
