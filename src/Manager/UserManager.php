<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\User;
use App\Model\UserModel;
use App\Repository\UserRepository;
use App\Security\Roles;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserManager {

    public function __construct(private UserRepository $userRepository, private EntityManagerInterface $entityManager, private readonly UserPasswordHasherInterface $passwordHasher) {}

    public function create(UserModel $userModel): UserModel
    {
        $user = new User();

        $user->setEmail($userModel->email);
        $user->setPassword($this->passwordHasher->hashPassword($user, $userModel->password));
        $user->setRoles([Roles::ROLE_USER]);

        $this->save($user);

        return $this->one($user);
    }

    public function update(UserModel $userModel, User $currentUser): UserModel
    {
        $this->save($currentUser);

        return $this->one($currentUser);
    }

    public function one(User $user): UserModel
    {    
        $userModel = new UserModel();

        $userModel->id = $user->getId();
        $userModel->email = $user->getEmail();
        $userModel->roles = $user->getRoles();
        // $userModel->comments = ;

        return $userModel;
    }

    public function list() {
        
    }

    public function delete() {
        
    }

    private function save($entity) {

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    private function remove($entity) {

        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
}
