<?php
session_start();
if (!isset($_SESSION['treino_id'])) {
    header('Location: consultarTreino.php');
    exit();
}

include_once './config/config.php';
include_once './classes/Treino.php';
include_once './classes/Instrutor.php';

// Conectando ao banco de dados
$database = new Database();
$db = $database->getConnection();

// Inicializando a classe de Treino
$treino = new Treino($db);

// Inicializando a classe de Instrutor para obter a lista de instrutores
$instrutorObj = new Instrutor($db);
$instrutores = $instrutorObj->ler(); // Obtém os instrutores do banco

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $tipo = $_POST['tipo'];
    $exercicio = $_POST['exercicio'];
    $instrutor = $_POST['instrutor'];
    $descricao = $_POST['descricao'];

    // Atualizando treino
    $treino->atualizar($id, $tipo, $exercicio, $instrutor, $descricao);
    header('Location: consultarTreino.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Recupera o treino pelo ID
    $row = $treino->ler($id)[0]; // Busca o treino específico
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Treino</title>
    <link rel="stylesheet" href="styles/editarT.css">
</head>
<body>
    <div>
        <h1>Editar Treino</h1>
        <form method="POST">
            <a href="consultarTreino.php">Voltar</a>

            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <label for="tipo">Tipo:</label>
            <input type="text" id="tipo" name="tipo" value="<?php echo htmlspecialchars($row['tipo']); ?>" required>

            <label for="exercicio">Exercício:</label>
            <input type="text" id="exercicio" name="exercicio" value="<?php echo htmlspecialchars($row['exercicio']); ?>" required>

            <!-- Campo de Instrutor -->
            <label for="instrutor">Instrutor:</label>
            <select name="instrutor" id="instrutor" required>
                <option value="">Selecione o instrutor</option>
                <?php while ($instrutor = $instrutores->fetch(PDO::FETCH_ASSOC)) : ?>
                    <option value="<?php echo $instrutor['id']; ?>"
                        <?php echo ($instrutor['id'] == $row['fkidinstrutor']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($instrutor['nome']); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="descricao">Descrição:</label>
            <input type="text" id="descricao" name="descricao" value="<?php echo htmlspecialchars($row['descricao']); ?>" required>

            <input type="submit" value="Atualizar">
        </form>
    </div>
</body>
</html>
