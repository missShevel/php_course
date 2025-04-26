<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Security;
use App\Enum\UserRole;

class AuthController extends AbstractController
{
    private $entityManager;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route("/api/register", name:"api_register", methods:["POST"])]
    public function register(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!in_array($data['role'], UserRole::values(), true)) {
            return new JsonResponse(['error' => 'Invalid role specified'], 400);
        }
        

        if ($data['password'] !== $data['password_confirmation']) {
            return new JsonResponse(['error' => 'Passwords do not match'], 400);
        }

        $user = new User();
        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setRoles([$data['role']]); // Наприклад ROLE_CLIENT
        $user->setPassword(
            $this->passwordHasher->hashPassword($user, $data['password'])
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'User registered successfully'], 201);
    }


    #[Route("/api/login", name:"api_login", methods:["POST"])]
    public function login(JWTTokenManagerInterface $JWTManager): JsonResponse
    {
        // Користувач вже аутентифікований через json_login firewall
        /** @var UserInterface $user */
        $user = $this->getUser();

        if (!$user) {
            return new JsonResponse(['error' => 'Invalid credentials'], 401);
        }

        $token = $JWTManager->create($user);

        return new JsonResponse([
            'token' => $token,
            'user' => [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'roles' => $user->getRoles()
            ]
        ]);
    }

    #[Route("/api/logout", name:"api_logout", methods:["POST"])]
    public function logout(): JsonResponse
    {
        // Статус 200 просто для фронтенду. Логаут відбувається на стороні фронту через видалення токену
        return new JsonResponse(['message' => 'Logged out successfully'], 200);
    }

    
     #[Route("/api/user", name:"api_user", methods:["GET"])]
    public function profile(): JsonResponse
    {
        /** @var UserInterface $user */
        $user = $this->getUser();

        if (!$user) {
            return new JsonResponse(['error' => 'Unauthorized'], 401);
        }

        return new JsonResponse([
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ]);
    }
}
