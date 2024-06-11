<?php
include('../config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Usuário registrado com sucesso.";
        header("Location: login.php");
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}
?>

<?php include('../templates/header.php'); ?>

<h1>Registrar</h1>
<form method="post" action="">
    <label>Nome de Usuário:</label>
    <input type="text" name="username" required><br>
    <label>Email:</label>
    <input type="email" name="email" required><br>
    <label>Senha:</label>
    <input type="password" name="password" required><br>
    <button type="submit">Registrar</button>
</form>

<?php include('../templates/footer.php'); ?>
