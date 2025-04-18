<?php
namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Repository\AuthorRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/api/books')]
class BookController extends AbstractController
{
    /**
     * @Route("/api/books", methods={"GET"})
     */
    #[Route('', methods: ['GET'])]
    public function index(Request $request, BookRepository $bookRepository): JsonResponse
    {
        $filters = [
            'title' => $request->query->get('title'),
            'genre' => $request->query->get('genre'),
            'published_at' => $request->query->get('published_at'),
            'author_id' => $request->query->get('author_id'),
        ];
        $books = $bookRepository->findByFilters($filters);
        return $this->json($books, 200, ['groups' => 'book:read']);
    }

    /**
     * @Route("/api/books", methods={"POST"})
     */
    #[Route('', methods: ['POST'])]
    public function store(Request $request, EntityManagerInterface $em, AuthorRepository $authorRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validate input
        if (!isset($data['title']) || !isset($data['author_id'])) {
            return $this->json(['error' => 'Title and Author are required.'], 400);
        }

        $author = $authorRepository->find($data['author_id']);
        if(!$author) {
            return $this->json(['error' => 'Author not found'], 400);
        }

        // Create new Book
        $book = new Book();
        $book->setTitle($data['title']);
        $book->setAuthor($author);
        $em->persist($book);
        $em->flush();

        return $this->json($book, 201);
    }

    /**
     * @Route("/api/books/{id}", methods={"GET"})
     */
    #[Route('/{id}', methods: ['GET'])]
    public function show($id, BookRepository $bookRepository): JsonResponse
    {
        $book = $bookRepository->find($id);

        if (!$book) {
            return $this->json(['error' => 'Book not found'], 404);
        }

        return $this->json($book);
    }

    /**
     * @Route("/api/books/{id}", methods={"PUT"})
     */
    #[Route('/{id}', methods: ['PUT'])]
    public function update($id, Request $request, EntityManagerInterface $em, BookRepository $bookRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $book = $bookRepository->find($id);

        if (!$book) {
            return $this->json(['error' => 'Book not found'], 404);
        }

        // Update the book
        if (isset($data['title'])) $book->setTitle($data['title']);
        if (isset($data['author_id'])) $book->setAuthor($data['author_id']);

        $em->flush();

        return $this->json($book);
    }

    /**
     * @Route("/api/books/{id}", methods={"DELETE"})
     */
    #[Route('/{id}', methods: ['DELETE'])]
    public function destroy($id, EntityManagerInterface $em, BookRepository $bookRepository): JsonResponse
    {
        $book = $bookRepository->find($id);

        if (!$book) {
            return $this->json(['error' => 'Book not found'], 404);
        }

        $em->remove($book);
        $em->flush();

        return $this->json(['message' => 'Book deleted successfully']);
    }
}
