<?php

//Clase 1
class Book {
    private $title;
    private $author;
    private $category;
    private $available; 

    public function __construct($title, $author, $category, $available = true) {
        $this->title = $title;
        $this->author = $author;
        $this->category = $category;
        $this->available = $available;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getCategory() {
        return $this->category;
    }

    public function isAvailable() {
        return $this->available;
    }

    
    public function setTitle($title) {
        $this->title = $title;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function setAvailability($available) {
        $this->available = $available;
    }

    
    public function displayDetails() {
        return "Título: {$this->title}, Autor: {$this->author}, Categoría: {$this->category}, Disponible: " . ($this->available ? 'Sí' : 'No');
    }
}

//Clase 2

class Library {
    private $books = []; 

    // Agregar un libro a la biblioteca
    public function addBook(Book $book) {
        $this->books[] = $book;
    }

    // Buscar libros por título, autor o categoría
    public function searchBooks($query, $type = 'title') {
        $results = [];
        foreach ($this->books as $book) {
            if ($type === 'title' && stripos($book->getTitle(), $query) !== false) {
                $results[] = $book;
            } elseif ($type === 'author' && stripos($book->getAuthor(), $query) !== false) {
                $results[] = $book;
            } elseif ($type === 'category' && stripos($book->getCategory(), $query) !== false) {
                $results[] = $book;
            }
        }
        return $results;
    }

    // Eliminar un libro por título
    public function removeBook($title) {
        foreach ($this->books as $index => $book) {
            if ($book->getTitle() === $title) {
                unset($this->books[$index]);
                return true;
            }
        }
        return false;
    }

    // Listar todos los libros
    public function listBooks() {
        foreach ($this->books as $book) {
            echo $book->displayDetails() . PHP_EOL;
        }
    }
}

//Clase 3
class Loan {
    private $book;
    private $user;
    private $date;

    public function __construct(Book $book, $user) {
        if (!$book->isAvailable()) {
            throw new Exception("El libro no está disponible para préstamo.");
        }
        $this->book = $book;
        $this->user = $user;
        $this->date = new DateTime();
        $book->setAvailability(false); 
    }

    public function getDetails() {
        return "Libro: {$this->book->getTitle()}, Usuario: {$this->user}, Fecha: {$this->date->format('Y-m-d H:i:s')}";
    }
}

// Crear libros
$book1 = new Book("1984", "George Orwell", "Ficción");
$book2 = new Book("Cien Años de Soledad", "Gabriel García Márquez", "Realismo Mágico");

// Crear biblioteca
$library = new Library();
$library->addBook($book1);
$library->addBook($book2);

// Buscar libros
$resultados = $library->searchBooks("1984", "title");
foreach ($resultados as $book) {
    echo $book->displayDetails() . PHP_EOL;
}

// Préstamo
try {
    $loan = new Loan($book1, "Usuario1");
    echo $loan->getDetails() . PHP_EOL;
} catch (Exception $e) {
    echo $e->getMessage();
}

// Listar libros en la biblioteca
$library->listBooks();




?>