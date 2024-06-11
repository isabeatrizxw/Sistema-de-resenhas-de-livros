<?php
include('../config/db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    $sql = "SELECT * FROM books WHERE id = '$book_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        echo "Livro não encontrado.";
        exit;
    }
} else {
    echo "ID do livro não especificado.";
    exit;
}
?>

<?php include('../templates/header.php'); ?>

<h1><?php echo $book['title']; ?></h1>
<p><strong>Autor:</strong> <?php echo $book['author']; ?></p>
<p><strong>Gênero:</strong> <?php echo $book['genre']; ?></p>
<p><strong>Opinião:</strong> <?php echo $book['opinion']; ?></p>
<p><strong>Nota:</strong> <?php echo $book['rating']; ?>/5</p>
<?php if (!empty($book['image'])): ?>
    <img src="../images/<?php echo $book['image']; ?>" alt="<?php echo $book['title']; ?>" class="book-image">
<?php else: ?>
    <img src="../images/book_placeholder.png" alt="Placeholder" class="book-image">
<?php endif; ?>
<a href="<?php echo $book['link']; ?>" target="_blank">Comprar Livro</a>

<?php include('../templates/footer.php'); ?>
