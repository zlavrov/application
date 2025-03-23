<?php

declare(strict_types=1);

namespace App\Model;

use App\Security\AccessGroup;
use Symfony\Component\Serializer\Attribute\Groups;

class CommentModel {

    #[Groups(groups: [
        AccessGroup::COMMENT_READ,
        AccessGroup::USER_READ
    ])]
    public int $id;

    #[Groups(groups: [
        AccessGroup::COMMENT_READ,
        AccessGroup::COMMENT_CREATE,
        AccessGroup::COMMENT_WRITE,
        AccessGroup::USER_READ
    ])]
    public string $content;

    #[Groups(groups: [
        AccessGroup::COMMENT_READ
    ])]
    public ?UserModel $sender;
}
