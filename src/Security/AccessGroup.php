<?php

declare(strict_types=1);

namespace App\Security;

class AccessGroup {

    public const COMMENT_READ = 'comment:read';
    public const COMMENT_WRITE = 'comment:write';
    public const COMMENT_CREATE = 'comment:create';

    public const USER_READ = 'user:read';
    public const USER_WRITE = 'user:write';
    public const USER_CREATE = 'user:create';
}
