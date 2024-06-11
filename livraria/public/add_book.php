<?php
include('../config/db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $opinion = $_POST['opinion'];
    $rating = $_POST['rating'];
    $image = $_FILES['image']['name'];
    $target_dir = "../images/";
    $target_file = $target_dir . basename($image);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES['image']['tmp_name']);
    if ($check === false) {
        $errors[] = "O arquivo não é uma imagem.";
        $uploadOk = 0;
    }

    if (file_exists($target_file)) {
        $errors[] = "Desculpe, arquivo já existe.";
        $uploadOk = 0;
    }

    if ($_FILES['image']['size'] > 500000) {
        $errors[] = "Desculpe, seu arquivo é muito grande.";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        $errors[] = "Desculpe, apenas arquivos JPG, JPEG, PNG e GIF são permitidos.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO books (user_id, title, author, genre, opinion, rating, image, wishlist) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $wishlist = isset($_POST['wishlist']) ? 1 : 0;
            $stmt->bind_param("issssssi", $user_id, $title, $author, $genre, $opinion, $rating, $image, $wishlist);

            if ($stmt->execute()) {
                $stmt->close();
                header("Location: view_books.php");
                exit;
            } else {
                $errors[] = "Erro ao adicionar livro: " . $conn->error;
            }
        } else {
            $errors[] = "Erro ao fazer o upload da imagem.";
        }
    }
}

include('../templates/header.php');
?>

<h1>Adicionar Livro</h1>
<div class="container">
    <?php
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
    ?>
    <form method="post" action="" enctype="multipart/form-data">
        <label>Título:</label>
        <input type="text" name="title" required><br>
        <label>Autor:</label>
        <input type="text" name="author" required><br>
        <label>Gênero:</label>
        <select name="genre" required>
            <option value="Ficção">Ficção</option>
            <option value="Terror">Terror</option>
            <option value="Romance">Romance</option>
            <option value="Aventura">Aventura</option>
            <option value="Mistério">Mistério</option>
            <option value="Não-ficção">Não-ficção</option>
        </select><br>
        <label>Sua Opinião:</label><br>
        <textarea name="opinion" rows="5" cols="40" required></textarea><br>
        <label>Nota (1-5 estrelas):</label>
        <input type="number" name="rating" min="1" max="5" required><br>
        <label>Carregar Imagem:</label>
        <input type="file" name="image" id="image" required><br>
        <button type="submit">Adicionar Livro</button>
    </form>
</div>


