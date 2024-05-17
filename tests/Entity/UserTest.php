<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Client;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function getUser() {
        return new User();
    }
    public function testName()
    {
        $user = $this->getUser();
        $name = "Test name";
        
        $user->setName($name);
        $this->assertEquals($name, $user->getName());
    }

    public function testClient()
    {
        $user = $this->getUser();
        $client = new Client();
        
        $user->setClient($client);
        $this->assertEquals($client, $user->getClient());
    }
}
