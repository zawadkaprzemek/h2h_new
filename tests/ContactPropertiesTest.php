<?php

namespace App\Tests;

use App\Entity\ContactMessage;
use PHPUnit\Framework\TestCase;

class ContactPropertiesTest extends TestCase
{
    public function testSomething(): void
    {
        $contact = new ContactMessage();
        $emailInvalid = 'testtest.com';
        $contact->setEmail($emailInvalid);
        $this->assertEquals($emailInvalid, $contact->getEmail());
    }
}
