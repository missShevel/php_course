<?php
// src/Controller/IssueController.php
namespace App\Controller;

use App\Entity\Issue;
use App\Repository\IssueRepository;
use App\Repository\BookRepository;
use App\Repository\ReaderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;


#[Route('/api/issues')]
class IssueController extends AbstractController
{
    /**
     * @Route("/api/issues", methods={"GET"})
     */
    #[Route('', methods: ['GET'])]
    public function index(Request $request, IssueRepository $issueRepository, SerializerInterface $serializer, LoggerInterface $logger): JsonResponse
    {
        $filters = [
            'book_id' => $request->query->get('book_id'),
            'reader_id' => $request->query->get('reader_id'),
            'issued_at' => $request->query->get('issued_at'),
        ];

        $issues = $issueRepository->findByFilters($filters);
        return $this->json($issues, 200, ['groups' => '*']);
    }

    /**
     * @Route("/api/issues", methods={"POST"})
     */
    #[Route('', methods: ['POST'])]
    public function store(Request $request, EntityManagerInterface $em, BookRepository $bookRepository, ReaderRepository $readerRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validate input
        if (!isset($data['book_id']) || !isset($data['reader_id']) || !isset($data['issued_at'])) {
            return $this->json(['error' => 'Book ID, Reader ID, and Issued At are required.'], 400);
        }

        $book = $bookRepository->find($data['book_id']);
        if(!$book) {
            return $this->json(['error' => 'Book not found'], 400);
        }
        
        $reader = $readerRepository->find($data['reader_id']);
        if(!$reader) {
            return $this->json(['error' => 'reader not found'], 400);
        }
        // Create new Issue
        $issue = new Issue();
        $issue->setBook($book);
        $issue->setReader($reader);
        $issue->setIssuedAt(new \DateTime($data['issued_at']));
        $em->persist($issue);
        $em->flush();

        return $this->json($issue, 201);
    }

    /**
     * @Route("/api/issues/{id}", methods={"GET"})
     */
    #[Route('/{id}', methods: ['GET'])]
    public function show($id, IssueRepository $issueRepository): JsonResponse
    {
        $issue = $issueRepository->find($id);

        if (!$issue) {
            return $this->json(['error' => 'Issue not found'], 404);
        }

        return $this->json($issue);
    }

    /**
     * @Route("/api/issues/{id}", methods={"PUT"})
     */
    #[Route('/{id}', methods: ['PUT'])]
    public function update($id, Request $request, EntityManagerInterface $em, IssueRepository $issueRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $issue = $issueRepository->find($id);

        if (!$issue) {
            return $this->json(['error' => 'Issue not found'], 404);
        }

        // Update the issue
        if (isset($data['book_id'])) $issue->setBook($data['book_id']);
        if (isset($data['reader_id'])) $issue->setReader($data['reader_id']);
        if (isset($data['issued_at'])) $issue->setIssuedAt(new \DateTime($data['issued_at']));

        $em->flush();

        return $this->json($issue);
    }

    /**
     * @Route("/api/issues/{id}", methods={"DELETE"})
     */
    #[Route('/{id}', methods: ['DELETE'])]
    public function destroy($id, EntityManagerInterface $em, IssueRepository $issueRepository): JsonResponse
    {
        $issue = $issueRepository->find($id);

        if (!$issue) {
            return $this->json(['error' => 'Issue not found'], 404);
        }

        $em->remove($issue);
        $em->flush();

        return $this->json(['message' => 'Issue deleted successfully']);
    }
}
