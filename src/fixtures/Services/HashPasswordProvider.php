<?php

namespace App\fixtures\Services;

use App\Entity\Client;
use Faker\Provider\Base;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HashPasswordProvider extends Base
{
    /**
     * @var UserPasswordHasherInterface
     */
    private $hasher;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public static function meow(string $seggs) {
        return 'meow';
    }

    public function hashPassword(string $plainPassword): string
    {
        return $this->hasher->hashPassword(new Client(), $plainPassword);
    }

}