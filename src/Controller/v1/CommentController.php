<?php

declare(strict_types=1);

namespace App\Controller\v1;

use App\Entity\Comment;
use App\Entity\User;
use App\Manager\CommentManager;
use App\Model\CommentModel;
use App\Security\AccessGroup;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/comments', name: 'api_comments_')]
class CommentController extends AbstractController
{
    public function __construct(private CommentManager $commentManager) {}

    #[Route('', name: 'create', methods: [Request::METHOD_POST])]
    public function create(
        #[MapRequestPayload(
            serializationContext: ['groups' => [AccessGroup::COMMENT_CREATE]],
            validationGroups: [AccessGroup::COMMENT_CREATE]
        )] CommentModel $commentModel,
        // #[CurrentUser] User $currentUser
    ): JsonResponse {

        return $this->json(
            $this->commentManager->create(
                $commentModel, 
                // $currentUser
            ),
            Response::HTTP_CREATED,
            [],
            ['groups' => [AccessGroup::COMMENT_READ]]
        );
    }

    #[Route('/{id}', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: [Request::METHOD_PATCH])]
    public function update(
        #[MapRequestPayload(
            serializationContext: ['groups' => [AccessGroup::COMMENT_WRITE]],
            validationGroups: [AccessGroup::COMMENT_WRITE]
        )] CommentModel $commentModel,
        #[CurrentUser] User $currentUser,
        Comment $comment
    ): JsonResponse {

        return $this->json(
            $this->commentManager->update($commentModel, $comment, $currentUser),
            Response::HTTP_OK,
            [],
            ['groups' => [AccessGroup::COMMENT_READ]]
        );
    }

    #[Route('/{id}', name: 'one', requirements: ['id' => Requirement::DIGITS], methods: [Request::METHOD_GET])]
    public function one(Comment $comment): JsonResponse
    {
        return $this->json(
            $this->commentManager->one($comment),
            Response::HTTP_OK,
            [],
            ['groups' => [AccessGroup::COMMENT_READ]]
        );
    }

    #[Route('', name: 'list', methods: [Request::METHOD_GET])]
    public function list(): JsonResponse
    {
        return $this->json(
            $this->commentManager->list(),
            Response::HTTP_OK,
            [],
            ['groups' => [AccessGroup::COMMENT_READ]]
        );
    }

    #[Route('/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: [Request::METHOD_DELETE])]
    public function delete(Comment $comment): JsonResponse
    {
        $this->commentManager->delete($comment);

        return $this->json(
            [],
            Response::HTTP_NO_CONTENT,
            [],
        );
    }
}
