<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    use TimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    // #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'comments')]
    // #[ORM\JoinColumn(nullable: false)]
    // private ?User $sender = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    // public function getSender(): ?User
    // {
    //     return $this->sender;
    // }

    // public function setSender(?User $sender): self
    // {
    //     $this->sender = $sender;

    //     return $this;
    // }
}
