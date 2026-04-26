<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LibraryController extends AbstractController
{
    #[Route('/library', name: 'library')]
    public function index(): Response
    {
        return $this->render('library/index.html.twig');
    }

    #[Route('/library/books', name: 'library_books')]
    public function books(BookRepository $bookRepository): Response
    {
        return $this->render('library/books.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    #[Route('/library/book/{id}', name: 'library_book')]
    public function book(Book $book): Response
    {
        return $this->render('library/book.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/library/create', name: 'library_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $book = new Book();
            $book->setTitle((string) $request->request->get('title'));
            $book->setIsbn((string) $request->request->get('isbn'));
            $book->setAuthor((string) $request->request->get('author'));
            $book->setImage((string) $request->request->get('image'));

            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('library_books');
        }

        return $this->render('library/create.html.twig');
    }

    #[Route('/library/update/{id}', name: 'library_update', methods: ['GET', 'POST'])]
    public function update(Book $book, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $book->setTitle((string) $request->request->get('title'));
            $book->setIsbn((string) $request->request->get('isbn'));
            $book->setAuthor((string) $request->request->get('author'));
            $book->setImage((string) $request->request->get('image'));

            $entityManager->flush();

            return $this->redirectToRoute('library_book', [
                'id' => $book->getId(),
            ]);
        }

        return $this->render('library/update.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/library/delete/{id}', name: 'library_delete', methods: ['POST'])]
    public function delete(Book $book, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('library_books');
    }

    #[Route('/library/reset', name: 'library_reset')]
    public function reset(EntityManagerInterface $entityManager, BookRepository $bookRepository): Response
    {
        foreach ($bookRepository->findAll() as $book) {
            $entityManager->remove($book);
        }

        $books = [
            [
                'title' => 'Mio min Mio',
                'isbn' => '9789129688313',
                'author' => 'Astrid Lindgren',
                'image' => 'https://upload.wikimedia.org/wikipedia/en/8/8c/Mio_my_son_cover.jpg',
            ],
            [
                'title' => 'Bröderna Lejonhjärta',
                'isbn' => '9789129688894',
                'author' => 'Astrid Lindgren',
                'image' => 'https://upload.wikimedia.org/wikipedia/en/9/95/The_Brothers_Lionheart.jpg',
            ],
            [
                'title' => 'Ronja Rövardotter',
                'isbn' => '9789129688825',
                'author' => 'Astrid Lindgren',
                'image' => 'https://upload.wikimedia.org/wikipedia/en/7/7b/Ronia_the_Robber%27s_Daughter.jpg',
            ],
        ];

        foreach ($books as $bookData) {
            $book = new Book();
            $book->setTitle($bookData['title']);
            $book->setIsbn($bookData['isbn']);
            $book->setAuthor($bookData['author']);
            $book->setImage($bookData['image']);

            $entityManager->persist($book);
        }

        $entityManager->flush();

        return $this->redirectToRoute('library_books');
    }
}
