<?php

namespace App\Tests;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ContactTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());

        $container = static::getContainer();

        $contact = new Contact();
        $contact->setFirstName('Nicolas');
        $contact->setLastName('Pereire');
        $contact->setEmail('nico63@live.fr');
        $contact->setMessage('bonjour');

        $errors = $container->get('validator')->validator($contact);
        $this->assertCount(0, $errors);

        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
    }
}
