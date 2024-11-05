<?php
$file = '..\data\books.txt';

function getBooks($file) {
    if (!file_exists($file) || !is_readable($file)) {
        return [];
    }
    $books = [];
    $fileContents = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($fileContents as $line) {
        list($id, $title, $author) = explode('|', $line);
        $books[] = ['id' => $id, 'title' => $title, 'author' => $author];
    }
    return $books;
}

function saveBooks($file, $books) {
    if (!is_writable($file)) {
        echo "Gagal menyimpan data.";
        return;
    }
    $data = '';
    foreach ($books as $book) {
        $data .= "{$book['id']}|{$book['title']}|{$book['author']}
";
    }
    file_put_contents($file, $data);
}

if (isset($_GET['title']) && isset($_GET['author'])) {
    $title = trim($_GET['title']);
    $author = trim($_GET['author']);
    
    // Debugging sikit sikit
    echo "Title: " . $title . "<br>";
    echo "Author: " . $author . "<br>";

    if (!empty($title) && !empty($author)) {
        $books = getBooks($file);
        $newId = count($books) > 0 ? $books[count($books) - 1]['id'] + 1 : 1;
        $books[] = ['id' => $newId, 'title' => $title, 'author' => $author];
        saveBooks($file, $books);
        echo "Buku berhasil ditambahkan!";
    } else {
        echo "Parameter tidak lengkap.";
    }
} else {
    echo "Parameter tidak lengkap.";
}