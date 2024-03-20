<?php

namespace App\Tests;

use App\Entity\ContactMessage;
use PHPUnit\Framework\TestCase;

class ContactPropertiesTest extends TestCase
{
    public function testSomething(): void
    {
        $contact = new ContactMessage();
        $email = 'test@test.com';
        $fullName = "Testowy Test";
        $message = "Testowa treść wiadomości";
        $consent = false;
        $contact->setFullName($fullName);
        $contact->setEmail($email);
        $contact->setMessage($message);
        $contact->setConsent($consent);
        $this->assertEquals($fullName, $contact->getFullName());
        $this->assertEquals($email, $contact->getEmail());
        $this->assertEquals($message, $contact->getMessage());
        $this->assertEquals($consent, $contact->isConsent());
    }
}
