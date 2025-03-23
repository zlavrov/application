<?php

declare(strict_types=1);

namespace App\Model;

use App\Security\AccessGroup;
use Symfony\Component\Serializer\Attribute\Groups;

class UserModel {

    #[Groups(groups: [
        AccessGroup::USER_READ,
        AccessGroup::COMMENT_READ
    ])]
    public int $id;

    #[Groups(groups: [
        AccessGroup::USER_READ,
        AccessGroup::USER_CREATE,
        AccessGroup::COMMENT_READ
    ])]
    public string $email;

    #[Groups(groups: [
        AccessGroup::USER_READ,
        AccessGroup::COMMENT_READ
    ])]
    public array $roles;

    #[Groups(groups: [
        AccessGroup::USER_CREATE,
        AccessGroup::USER_CREATE
    ])]
    public string $password;

    #[Groups(groups: [
        AccessGroup::USER_READ
    ])]
    /** @var array<int, CommentModel> */
    public ?array $comments;
}
