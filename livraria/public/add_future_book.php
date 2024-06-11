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
            // Preparar e executar a inserção no banco de dados
            $stmt = $conn->prepare("INSERT INTO books (user_id, title, image, wishlist) 
                                   VALUES (?, ?, ?, 1)");
            $stmt->bind_param("iss", $user_id, $title, $image);

            if ($stmt->execute()) {
                $stmt->close();
                header("Location: future_books.php");
                exit;
            } else {
                $errors[] = "Erro ao adicionar leitura futura: " . $conn->error;
            }
        } else {
            $errors[] = "Erro ao fazer o upload da imagem.";
        }
    }
}

include('../templates/header.php');
?>

<div class="main-content">
    <h1>Adicionar Leitura Futura</h1>
    <?php
    // Exibir erros, se houver
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
    ?>
    <form method="post" action="" enctype="multipart/form-data">
        <label>Título:</label>
        <input type="text" name="title" required><br>
        <label>Carregar Imagem:</label>
        <input type="file" name="image" id="image" required><br>
        <button type="submit">Adicionar Leitura Futura</button>
    </form>
</div>

<?php include('../templates/footer.php'); ?>
