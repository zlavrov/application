<?php

declare(strict_types=1);

namespace App\Security;

use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

readonly class UserCheckerAdmin implements UserCheckerInterface
{
    public function __construct() {}

    public function checkPreAuth(UserInterface $user): void {}

    public function checkPostAuth(UserInterface $user): void {}
}
