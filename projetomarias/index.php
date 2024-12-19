<?php
include_once './config/config.php';
include_once './classes/Treino.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    $treinos = new Treino($db);
    $dados = $treinos->ler();  // Método ler que retorna os dados como um array
} catch (Exception $e) {
    die("Erro: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/index.css">
    <title>Academia Fit</title>
</head>
<body>
    <!-- Cabeçalho -->
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="img/haltere.png" alt="Logo" class="logo-img">
            </div>
            <div class="header-content">
                <h1>Academia Fit</h1>
                <p>Juntos com você nessa jornada fitness!</p>
                <a href="login.php" class="btn-login">Login</a>
            </div>
        </div>
    </header>

    <!-- Treinos -->
    <main>
        <h2>Treinos Disponíveis</h2>
        <section class="treinos-container">
            <?php foreach ($dados as $row) : ?>
                <article class="treino-card">
                    <div class="treino-content">
                        <h3><?php echo htmlspecialchars($row['tipo']); ?></h3>
                        <p><strong>Exercício:</strong> <?php echo htmlspecialchars($row['exercicio']); ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
    </main>

    <!-- Rodapé -->
    <footer>
        <p>&copy; 2024 Academia Fit | Todos os direitos reservados Marias.</p>
    </footer>
</body>
</html>