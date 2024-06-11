<?php
include('../config/db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM books WHERE user_id = '$user_id' AND wishlist = 1 ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<?php include('../templates/header.php'); ?>

<div class="main-content">
    <h1>Leituras Futuras</h1>
    <ul class="book-list">
        <?php while ($row = $result->fetch_assoc()): ?>
            <li class="book-item">
                <h3><a href="https://www.amazon.com.br/s?k=<?php echo urlencode($row['title']); ?>" target="_blank"><?php echo $row['title']; ?></a></h3>
                <?php if (!empty($row['image'])): ?>
                    <img src="../images/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>" class="book-image-small">
                <?php else: ?>
                    <img src="../images/book_placeholder.png" alt="Placeholder" class="book-image-small">
                <?php endif; ?>
            </li>
        <?php endwhile; ?>
    </ul>

    <form method="post" action="add_future_book.php" enctype="multipart/form-data">
        <h2>Adicionar Leitura Futura</h2>
        <label>Título:</label>
        <input type="text" name="title" required><br>
        <label>Carregar Imagem:</label>
        <input type="file" name="image" id="image" required><br>
        <button type="submit">Adicionar Leitura Futura</button>
    </form>
</div>

