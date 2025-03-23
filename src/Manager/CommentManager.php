<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Comment;
use App\Entity\User;
use App\Model\CommentModel;
use App\Model\UserModel;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class CommentManager {

    public function __construct(private CommentRepository $commentRepository, private EntityManagerInterface $entityManager, public HubInterface $hub) {}

    public function create(
        CommentModel $commentModel, 
        // User $currentUser
    ): CommentModel
    {
        $comment = new Comment();

        $comment->setContent($commentModel->content);
        // $comment->setSender($currentUser);

        $this->save($comment);


        $commentModel = $this->one($comment);

        $update = new Update(
            '/comments',
            json_encode(['id' => $comment->getId(), 'content' => $comment->getContent()])
        );
        $this->hub->publish($update);


        return $commentModel;
    }

    public function update(CommentModel $commentModel, Comment $comment, User $currentUser): CommentModel
    {
        $comment->setContent($commentModel->content);
        // $comment->setSender($currentUser);

        $this->save($comment);

        return $this->one($comment);
    }

    public function one(Comment $comment): CommentModel
    {
        $commentModel = new CommentModel();

        // $userModel = new UserModel();
        // $sender = $comment->getSender();
        // $userModel->id = $sender->getId();
        // $userModel->email = $sender->getEmail();
        // $userModel->roles = $sender->getRoles();

        $commentModel->id = $comment->getId();
        $commentModel->content = $comment->getContent();
        // $commentModel->sender = $userModel;

        return $commentModel;
    }

    public function list(): array
    {
        $list = [];
        foreach($this->commentRepository->findAll() as $comment) {
            array_push($list, $this->one($comment));
        }
        return $list;
    }

    public function delete(Comment $comment): void
    {    
        $this->remove($comment);
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



