<?php

namespace App\Services;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Form\Exception\InvalidArgumentException;

class UserService
{
    protected ObjectRepository $repo;
    public function __construct(protected EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(User::class);
    }

    public function create(string $login, string $pass, int $status = User::STATUS_DISABLED): User{
        $user = new User($login, $pass, $status);
        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }

    public function createFromArray(array $data): User
    {
        if (!isset($data['login']) || !isset($data['pass'])) {
            throw new InvalidArgumentException();
        }
        return $this->create($data['login'], $data['pass'], $data['status'] ?? User::STATUS_DISABLED);
    }



}
