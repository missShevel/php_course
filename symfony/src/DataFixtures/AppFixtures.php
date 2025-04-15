<?php

namespace App\DataFixtures;
use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Reader;
use App\Entity\Issue;
use App\Entity\ReturnBook;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Authors
        $orwell = new Author();
        $orwell->setName('George Orwell');
        $manager->persist($orwell);

        $austen = new Author();
        $austen->setName('Jane Austen');
        $manager->persist($austen);

        $rowling = new Author();
        $rowling->setName('J.K. Rowling');
        $manager->persist($rowling);

        // Books
        $book1 = new Book();
        $book1->setTitle('1984');
        $book1->setAuthor($orwell);
        $book1->setPublishedYear(1949);
        $manager->persist($book1);

        $book2 = new Book();
        $book2->setTitle('Pride and Prejudice');
        $book2->setAuthor($austen);
        $book2->setPublishedYear(1813);
        $manager->persist($book2);

        $book3 = new Book();
        $book3->setTitle('Harry Potter and the Philosopher\'s Stone');
        $book3->setAuthor($rowling);
        $book3->setPublishedYear(1997);
        $manager->persist($book3);

        // Readers
        $reader1 = new Reader();
        $reader1->setName('Alice Johnson');
        $reader1->setEmail('alice@example.com');
        $manager->persist($reader1);

        $reader2 = new Reader();
        $reader2->setName('Bob Smith');
        $reader2->setEmail('bob@example.com');
        $manager->persist($reader2);

        // Issues
        $issue1 = new Issue();
        $issue1->setBook($book1);
        $issue1->setReader($reader1);
        $issue1->setIssueDate(new \DateTime('2024-04-01'));
        $manager->persist($issue1);

        $issue2 = new Issue();
        $issue2->setBook($book2);
        $issue2->setReader($reader2);
        $issue2->setIssueDate(new \DateTime('2024-04-05'));
        $manager->persist($issue2);

        // Return Records
        $return1 = new ReturnBook();
        $return1->setIssue($issue1);
        $return1->setReturnDate(new \DateTime('2024-04-10'));
        $manager->persist($return1);

        $manager->flush();
    }
}