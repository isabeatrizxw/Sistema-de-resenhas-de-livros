<?php
include('../config/db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM books WHERE user_id = '$user_id'";
$result = $conn->query($sql);
?>

<?php include('../templates/header.php'); ?>

<h1>Meus Livros</h1>
<ul>
    <?php while ($row = $result->fetch_assoc()): ?>
        <li>
            <h3><a href="https://www.google.com/search?q=<?php echo urlencode($row['title']); ?>" target="_blank"><?php echo $row['title']; ?></a></h3>
            <p><strong>Autor:</strong> <?php echo $row['author']; ?></p>
            <p><strong>Gênero:</strong> <?php echo $row['genre']; ?></p>
            <div>
                <?php if (!empty($row['image'])): ?>
                    <img src="../images/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>" class="book-image">
                <?php else: ?>
                    <img src="../images/book_placeholder.png" alt="Placeholder" class="book-image">
                <?php endif; ?>
                <p><strong>Opinião:</strong> <?php echo $row['opinion']; ?></p>
                <p><strong>Nota:</strong> <?php echo $row['rating']; ?>/5</p>
            </div>
            <form method="post" action="delete_book.php">
                <input type="hidden" name="book_id" value="<?php echo $row['id']; ?>">
                <button type="submit">Excluir Livro</button>
            </form>
        </li>
    <?php endwhile; ?>
</ul>



<?php include('../templates/footer.php'); ?>
