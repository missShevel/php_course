<?php
// src/Controller/ReturnController.php
namespace App\Controller;

use App\Entity\ReturnBook;
use App\Repository\ReturnBookRepository;
use App\Repository\IssueRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/api/returns')]
class ReturnController extends AbstractController
{
    /**
     * @Route("/api/returns", methods={"GET"})
     */
    #[Route('', methods: ['GET'])]
    public function index(ReturnBookRepository $returnBookRepository): JsonResponse
    {
        $returns = $returnBookRepository->findAll();
        return $this->json($returns);
    }

    /**
     * @Route("/api/returns", methods={"POST"})
     */
    #[Route('', methods: ['POST'])]
    public function store(Request $request, EntityManagerInterface $em, IssueRepository $issueRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validate input
        if (!isset($data['issue_id']) || !isset($data['returned_at'])) {
            return $this->json(['error' => 'Issue ID and Returned At are required.'], 400);
        }

        $issue = $issueRepository->find($data['issue_id']);
        if(!$issue) {
            return $this->json(['error' => 'Issue not found.'], 400);
        }

        // Create new Return
        $return = new ReturnBook();
        $return->setIssue($issue);
        $return->setReturnedAt(new \DateTime($data['returned_at']));
        $em->persist($return);
        $em->flush();

        return $this->json($return, 201);
    }

    /**
     * @Route("/api/returns/{id}", methods={"GET"})
     */
    #[Route('/{id}', methods: ['GET'])]
    public function show($id, ReturnBookRepository $returnBookRepository): JsonResponse
    {
        $return = $returnBookRepository->find($id);

        if (!$return) {
            return $this->json(['error' => 'Return not found'], 404);
        }

        return $this->json($return);
    }

    /**
     * @Route("/api/returns/{id}", methods={"PUT"})
     */    
    #[Route('/{id}', methods: ['PUT'])]
    public function update($id, Request $request, EntityManagerInterface $em, ReturnBookRepository $returnBookRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $return = $returnBookRepository->find($id);

        if (!$return) {
            return $this->json(['error' => 'Return not found'], 404);
        }

        // Update the return
        if (isset($data['issue_id'])) $return->setIssue($data['issue_id']);
        if (isset($data['returned_at'])) $return->setReturnedAt(new \DateTime($data['returned_at']));

        $em->flush();

        return $this->json($return);
    }

    /**
     * @Route("/api/returns/{id}", methods={"DELETE"})
     */
    #[Route('/{id}', methods: ['DELETE'])]
    public function destroy($id, EntityManagerInterface $em, ReturnBookRepository $returnBookRepository): JsonResponse
    {
        $return = $returnBookRepository->find($id);

        if (!$return) {
            return $this->json(['error' => 'Return not found'], 404);
        }

        $em->remove($return);
        $em->flush();

        return $this->json(['message' => 'Return deleted successfully']);
    }
}
