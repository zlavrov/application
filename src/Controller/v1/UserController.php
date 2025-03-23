<?php

declare(strict_types=1);

namespace App\Controller\v1;

use App\Entity\User;
use App\Manager\UserManager;
use App\Model\UserModel;
use App\Security\AccessGroup;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[Route('/users', name: 'api_users_')]
class UserController extends AbstractController
{
    public function __construct(private UserManager $userManager) {}

    #[Route('', name: 'create', methods: [Request::METHOD_POST])]
    public function create(
        #[MapRequestPayload(
            serializationContext: ['groups' => [AccessGroup::USER_CREATE]],
            validationGroups: [AccessGroup::USER_CREATE]
        )] UserModel $userModel
    ): JsonResponse
    {
        return $this->json(
            $this->userManager->create($userModel),
            Response::HTTP_CREATED,
            [],
            ['groups' => [AccessGroup::USER_READ]]
        );
    }

    #[Route('/{id}', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: [Request::METHOD_PATCH])]
    public function update(
        #[MapRequestPayload(
            serializationContext: ['groups' => [AccessGroup::USER_WRITE]],
            validationGroups: [AccessGroup::USER_WRITE]
        )] UserModel $userModel,
        User $user
    ): JsonResponse {

        return $this->json(
            $this->userManager->update($userModel, $user),
            Response::HTTP_OK,
            [],
            ['groups' => [AccessGroup::USER_READ]]
        );
    }

    #[Route('/{id}', name: 'one', requirements: ['id' => Requirement::DIGITS], methods: [Request::METHOD_GET])]
    public function one(User $user): JsonResponse
    {
        return $this->json([]);
    }

    #[Route('', name: 'list', methods: [Request::METHOD_GET])]
    public function list(): JsonResponse
    {
        return $this->json([]);
    }

    #[Route('/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: [Request::METHOD_DELETE])]
    public function delete(User $user): JsonResponse
    {
        return $this->json([]);
    }
}
