<?php
// src/Controller/ReaderController.php
namespace App\Controller;

use App\Entity\Reader;
use App\Repository\ReaderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/api/readers')]
class ReaderController extends AbstractController
{
    /**
     * @Route("/api/readers", methods={"GET"})
     */
    #[Route('', methods: ['GET'])]
    public function index(ReaderRepository $readerRepository): JsonResponse
    {
        $readers = $readerRepository->findAll();
        return $this->json($readers);
    }

    /**
     * @Route("/api/readers", methods={"POST"})
     */
    #[Route('', methods: ['POST'])]
    public function store(Request $request, EntityManagerInterface $em, REaderRepository $readerRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validate input
        if (!isset($data['name']) || !isset($data['email'])) {
            return $this->json(['error' => 'Name and Email are required.'], 400);
        }

        $existingReader = $readerRepository->findOneBy(['email' => $data['email']]);
        if ($existingReader) {
            return $this->json(['error' => 'This email is already taken.'], 409);
        }

        // Create new Reader
        $reader = new Reader();
        $reader->setName($data['name']);
        $reader->setEmail($data['email']);
        $em->persist($reader);
        $em->flush();

        return $this->json($reader, 201);
    }

    /**
     * @Route("/api/readers/{id}", methods={"GET"})
     */
    #[Route('/{id}', methods: ['GET'])]
    public function show($id, ReaderRepository $readerRepository): JsonResponse
    {
        $reader = $readerRepository->find($id);

        if (!$reader) {
            return $this->json(['error' => 'Reader not found'], 404);
        }

        return $this->json($reader);
    }

    /**
     * @Route("/api/readers/{id}", methods={"PUT"})
     */
    #[Route('/{id}', methods: ['PUT'])]
    public function update($id, Request $request, EntityManagerInterface $em, ReaderRepository $readerRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $reader = $readerRepository->find($id);

        if (!$reader) {
            return $this->json(['error' => 'Reader not found'], 404);
        }

        // Update the reader
        if (isset($data['name'])) $reader->setName($data['name']);
        if (isset($data['email'])) $reader->setEmail($data['email']);

        $em->flush();

        return $this->json($reader);
    }

    /**
     * @Route("/api/readers/{id}", methods={"DELETE"})
     */
    #[Route('/{id}', methods: ['DELETE'])]
    public function destroy($id, EntityManagerInterface $em, ReaderRepository $readerRepository): JsonResponse
    {
        $reader = $readerRepository->find($id);

        if (!$reader) {
            return $this->json(['error' => 'Reader not found'], 404);
        }

        $em->remove($reader);
        $em->flush();

        return $this->json(['message' => 'Reader deleted successfully']);
    }
}
