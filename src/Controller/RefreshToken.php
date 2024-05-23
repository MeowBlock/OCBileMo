<?php
namespace App\Controller;

use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class RefreshToken extends AbstractController
{
    public function __construct(
    ) {}

    public function __invoke($token): void
    {
        die;
        dump($token);
    }
}