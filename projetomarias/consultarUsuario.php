<?php
include_once './config/config.php';
include_once './classes/usuario.php';

session_start();

if (!isset($_SESSION['usuario_nome'])) {
    // Redirecionar para a página de login se o usuário não estiver logado
    header('Location: login.php');
    exit();
}

$usuario = new Usuario($db);
$nome_usuario =  $_SESSION['usuario_nome'];

$dados = $usuario->ler();

function saudacao()
{
    $hora = date('H');
    if ($hora >= 6 && $hora < 12) {
        return "Bom dia";
    } else if ($hora >= 12 && $hora < 18) {
        return "Boa tarde";
    } else {
        return "Boa noite";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="styles/consultarU.css">
<title>Portal</title>
</head>
<body>
    <div class="container">
        <h1><?php echo saudacao() . ", " . $nome_usuario; ?>!</h1>
        <div class="actions">
            <a href="registrar.php">Adicionar Usuário</a>
            <a href="logout.php">Logout</a>
            <a href="portal.php">Voltar</a>
        </div>
        <div class="users-grid">
            <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)) : ?>
                <div class="user-card">
                    <h2><?php echo $row['nome']; ?></h2>
                    <p><strong>Sexo:</strong> <?php echo ($row['sexo'] === 'M') ? 'Masculino' : 'Feminino'; ?></p>
                    <p><strong>Fone:</strong> <?php echo $row['fone']; ?></p>
                    <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
                    <p><strong>CPF:</strong> <?php echo $row['cpf']; ?></p>
                    <p><strong>Data de Nascimento:</strong> <?php echo $row['dataN']; ?></p>
                    <p><strong>Peso:</strong> <?php echo $row['peso']; ?> kg</p>
                    <p><strong>Altura:</strong> <?php echo $row['altura']; ?> m</p>
                    <div class="user-actions">
                        <a href="editar.php?id=<?php echo $row['id']; ?>">Editar</a>
                        <a href="deletar.php?id=<?php echo $row['id']; ?>">Deletar</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
