<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class UserTest extends ApiTestCase
{
    private $token;
    protected function restoreExceptionHandler(): void
    {
        while (true) {
            $previousHandler = set_exception_handler(static fn() => null);
        
            restore_exception_handler();
        
            if ($previousHandler === null) {
                break;
            }
        
            restore_exception_handler();
        }
    }
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->restoreExceptionHandler();
    }
    public function testNoJwt(): void
    {
        $options = ['headers' =>['accept'=>'application/json']];
        $response = static::createClient()->request('GET', '/api/users', $options);

        $this->assertResponseStatusCodeSame(401, 'JWT Token not found');
    }

    public function testGetToken(): void
    {

        $authData = ["username" => "root",
        "password" => "root"];

        $response = static::createClient()->request('POST', '/auth', ['json'=> $authData]);

        $this->assertResponseIsSuccessful();

        $arr = $response->toArray();

        $this->assertNotEmpty($arr);

        $this->token = $arr['token'];


        //testGetUsers() 

        $options = ['headers' =>['accept'=>'application/json'], 'auth_bearer'=> $this->token];


        $response = static::createClient()->request('GET', '/api/users', $options);

        $user1 = $response->toArray()[0];

        $this->assertResponseIsSuccessful();

        $this->assertContains('testuser', $user1);

        //testGetUser()
        $options = ['headers' =>['accept'=>'application/json'], 'auth_bearer'=> $this->token];


        $response = static::createClient()->request('GET', '/api/users/'.$user1['id'], $options);

        $user = $response->toArray();

        $this->assertResponseIsSuccessful();

        $this->assertContains('testuser', $user);


        //testPostUser
        $options = ['headers' =>['accept'=>'application/json'], 'auth_bearer'=> $this->token];


        $response = static::createClient()->request('POST', '/api/users', array_merge($options, ['json'=>['name'=>'wawa']]));


        $this->assertResponseIsSuccessful();

        $postUser = $response->toArray();

        $this->assertContains('wawa', $postUser);

        $response = static::createClient()->request('GET', '/api/users/'.$postUser['id'], $options);
        
        $this->assertResponseIsSuccessful();


    }

}
