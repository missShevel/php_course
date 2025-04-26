<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class RoleVoter extends Voter
{
    public const ADMIN_OR_MANAGER = 'ADMIN_OR_MANAGER';

    protected function supports(string $attribute, $subject): bool
    {
        // Ми обробляємо тільки цей тип перевірки
        return $attribute === self::ADMIN_OR_MANAGER;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /** @var UserInterface|null $user */
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false; // неавторизований
        }

        $roles = $user->getRoles();

        switch ($attribute) {
            case self::ADMIN_OR_MANAGER:
                return in_array('ROLE_ADMIN', $roles, true) || in_array('ROLE_MANAGER', $roles, true);
        }

        return false;
    }
}
