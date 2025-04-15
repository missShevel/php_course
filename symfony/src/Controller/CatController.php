<?php

namespace App\Controller;

use App\Entity\Cat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/cats')]
class CatController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function index(EntityManagerInterface $em): JsonResponse
    {
        $cats = $em->getRepository(Cat::class)->findAll();
        return $this->json($cats);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(Cat $cat): JsonResponse
    {
        return $this->json($cat);
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $cat = new Cat();
        $cat->setName($data['name']);
        $cat->setAge($data['age']);
        $cat->setBreed($data['breed']);
        $cat->setColor($data['color']);
        $cat->setCharacter($data['character']);

        $em->persist($cat);
        $em->flush();

        return $this->json($cat, 201);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(Cat $cat, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return $this->json(['error' => 'Invalid JSON or no data provided'], 400);
        }

        $cat->setName($data['name'] ?? $cat->getName());
        $cat->setAge($data['age'] ?? $cat->getAge());
        $cat->setBreed($data['breed'] ?? $cat->getBreed());
        $cat->setColor($data['color'] ?? $cat->getColor());
        $cat->setCharacter($data['character'] ?? $cat->getCharacter());

        $em->flush();

        return $this->json($cat);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(Cat $cat, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($cat);
        $em->flush();

        return $this->json(null, 204);
    }
}
