<?php
include('../config/db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];

    $sql = "UPDATE users SET username = '$username', email = '$email' WHERE id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Perfil atualizado com sucesso.";
        header("Location: profile.php");
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>

<?php include('../templates/header.php'); ?>

<h1>Editar Perfil</h1>
<form method="post" action="">
    <label>Nome de Usuário:</label>
    <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br>
    <label>Email:</label>
    <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br>
    <button type="submit">Salvar Alterações</button>
</form>

<?php include('../templates/footer.php'); ?>
