<?php 
include_once './config/config.php'; 
include_once './classes/treino.php'; 
include_once './classes/instrutor.php'; 
session_start(); 

if (!isset($_SESSION['usuario_nome'])) { 
    header('Location: login.php'); 
    exit(); 
}

$treino = new Treino($db); 
$nome_usuario = $_SESSION['usuario_nome'];

$dados = []; // Variável para armazenar os dados de treino

// Verifica se o parâmetro 'ler' foi passado via GET
if (isset($_GET['ler'])) {
    $id = $_GET['ler'];
    $dados = $treino->ler($id);  // Busca um treino específico pelo ID
} else {
    $dados = $treino->ler();  // Caso não haja busca, lista todos os treinos
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/consultaT.css">
    <title>Portal de Treinos</title>
</head>
<body>
    <div class="container">
        <!-- Formulário de busca -->
        <form method="GET" action="consultarTreino.php" class="search-form">
            <input type="number" name="ler" placeholder="Buscar Treino por ID" />
            <button type="submit">Buscar</button>
        </form>
        <div class="actions">
            <a href="cadastrarTreino.php">Adicionar Treino</a>
            <a href="logout.php">Logout</a>
            <a href="portal.php">Voltar</a>
        </div>

        <!-- Exibição dos treinos -->
        <div class="cards-container">
            <?php if ($dados): ?> <!-- Verifica se há resultados -->
                <?php foreach ($dados as $treino) : ?>
                    <div class="card">
                        <h3><?php echo $treino['tipo']; ?></h3>
                        <p><strong>Exercício:</strong> <?php echo $treino['exercicio']; ?></p>
                        <p><strong>Instrutor:</strong> <?php echo $treino['nome_instrutor']; ?></p>
                        <p><strong>Descrição:</strong> <?php echo $treino['descricao']; ?></p>
                        <div class="card-actions">
                            <a href="editarT.php?id=<?php echo $treino['id']; ?>">Editar</a>
                            <a href="deletarT.php?id=<?php echo $treino['id']; ?>">Deletar</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhum treino encontrado.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>