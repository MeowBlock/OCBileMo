<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class CreateUser extends AbstractController
{
    public function __construct(
    ) {}

    public function __invoke(User $user): User
    {
        if(!$user->getClient()) {
            $user->setClient($this->getUser());
        }
        return $user;
    }
}