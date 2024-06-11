<?php
include('../config/db.php');
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: profile.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            header("Location: profile.php");
        } else {
            echo "Senha inválida.";
        }
    } else {
        echo "Nenhum usuário encontrado com este email.";
    }
}
?>

<?php include('../templates/header.php'); ?>

<h1>Login</h1>
<form method="post" action="">
    <label>Email:</label>
    <input type="email" name="email" required><br>
    <label>Senha:</label>
    <input type="password" name="password" required><br>
    <button type="submit">Login</button>
</form>
<p>Ainda não tem uma conta? <a href="register.php">Registre-se aqui</a>.</p>

<?php include('../templates/footer.php'); ?>
