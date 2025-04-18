<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/authors')]
class AuthorController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function index(Request $request, AuthorRepository $authorRepository): JsonResponse
    {
        $filters = [
            'name' => $request->query->get('name'),
            'birth_date' => $request->query->get('birth_date'),
        ];

        $page = max(1, (int) $request->query->get('page', 1));
        $limit = max(1, (int) $request->query->get('itemsPerPage', 10));

        $authors = $authorRepository->findFilteredPaginated($filters, $page, $limit);
        return $this->json($authors, 200);
    }

    #[Route('', methods: ['POST'])]
    public function store(
        Request $request,
        EntityManagerInterface $em,
        ValidatorInterface $validator,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['name'], $data['birth_date'])) {
            return $this->json(['error' => 'Missing required fields'], 400);
        }

        $existing = $em->getRepository(Author::class)->findOneBy(['name' => $data['name']]);
        if ($existing) {
            return $this->json(['error' => 'Author name already exists'], 409);
        }

        $author = new Author();
        $author->setName($data['name']);
        $author->setBirthDate(new \DateTime($data['birth_date']));

        $errors = $validator->validate($author);
        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }

        $em->persist($author);
        $em->flush();

        return $this->json($author, 201);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(Author $author = null): JsonResponse
    {
        if (!$author) {
            return $this->json(['error' => 'Author not found'], 404);
        }

        return $this->json($author);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(
        Author $author = null,
        Request $request,
        EntityManagerInterface $em,
        ValidatorInterface $validator
    ): JsonResponse {
        if (!$author) {
            return $this->json(['error' => 'Author not found'], 404);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['name'])) {
            $author->setName($data['name']);
        }
        if (isset($data['birth_date'])) {
            $author->setBirthDate(new \DateTime($data['birth_date']));
        }

        $errors = $validator->validate($author);
        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }

        $em->flush();

        return $this->json($author);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function destroy(Author $author = null, EntityManagerInterface $em): JsonResponse
    {
        if (!$author) {
            return $this->json(['error' => 'Author not found'], 404);
        }

        $em->remove($author);
        $em->flush();

        return $this->json(null, 204);
    }
}
