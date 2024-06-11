<nav>
    <ul>
        <?php if(isset($_SESSION['user_id'])): ?>
            <li><a href="profile.php">Perfil</a></li>
            <li><a href="add_book.php">Adicionar Livro</a></li>
            <li><a href="view_books.php">Meus Livros</a></li>
            <li><a href="future_books.php">Leituras futuras</a></li>
            <li><a href="logout.php">Logout</a></li>

        <?php else: ?>
            <li><a href="register.php">Registrar</a></li>
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>
