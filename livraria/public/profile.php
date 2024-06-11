<?php
include('../config/db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>

<?php include('../templates/header.php'); ?>

<h1>Perfil de <?php echo $user['username']; ?></h1>
<p><strong>Nome de Usuário:</strong> <?php echo $user['username']; ?></p>
<p><strong>Email:</strong> <?php echo $user['email']; ?></p>
<p><a href="edit_profile.php">Editar Perfil</a></p>

<?php include('../templates/footer.php'); ?>
