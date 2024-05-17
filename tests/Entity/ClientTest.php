<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function getClient() {
        return new Client();
    }
    public function testUsername()
    {
        $Client = $this->getClient();
        $name = "Test name";
        
        $Client->setUsername($name);
        $this->assertEquals($name, $Client->getUsername());
    }

    public function testPassword()
    {
        $client = $this->getClient();
        $password = "wa";
        
        $client->setPassword($password);
        $this->assertEquals($password, $client->getPassword());
    }

    public function testUsers()
    {
        $client = $this->getClient();
        $user = new User;
        $user->setClient($client);

        $client->addUser($user);


        $this->assertContains($user, $client->getUsers());

        $client->removeUser($user);

        $this->assertNotContains($user, $client->getUsers());
        
    }


}
