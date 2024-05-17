<?php

namespace App\Tests\Entity;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function getProduct() {
        return new Product();
    }
    public function testName()
    {
        $Product = $this->getProduct();
        $name = "Test name";
        
        $Product->setName($name);
        $this->assertEquals($name, $Product->getName());
    }
}
