<?php
include('../config/db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = $_POST['book_id'];

    $sql = "DELETE FROM books WHERE id = '$book_id' AND user_id = '{$_SESSION['user_id']}'";

    if ($conn->query($sql) === TRUE) {
        echo "Livro excluído com sucesso.";
    } else {
        echo "Erro ao excluir livro: " . $conn->error;
    }
}

header("Location: view_books.php");
exit;

