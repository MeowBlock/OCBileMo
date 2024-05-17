<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class ProductTest extends ApiTestCase
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
        $response = static::createClient()->request('GET', '/api/products', $options);

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


        $response = static::createClient()->request('GET', '/api/products', $options);

        $products = $response->toArray();

        $this->assertResponseIsSuccessful();

        $tmp = [];

        foreach($products as $product) {
            $tmp[$product['id']] = $product['name'];
        }

        $this->assertContains('produit_test', $tmp);

        $id = array_search('produit_test', $tmp);

        $response = static::createClient()->request('GET', '/api/products/'.$id, $options);
        
        $this->assertResponseIsSuccessful();



    }

}
