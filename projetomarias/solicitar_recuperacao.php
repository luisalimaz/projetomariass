<?php
include_once './config/config.php';
include_once './classes/Usuario.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $usuario = new Usuario($db);
    $codigo = $usuario->gerarCodigoVerificacao($email);

    if ($codigo) {
        $mensagem = "Seu código de verificação é: $codigo. Por favor, anote o código e <a href='redefinir_senha.php'>clique aqui</a> para redefinir sua senha.";
    } else {
        $mensagem = 'E-mail não encontrado.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/solicitar.css">
    <title>Recuperar Senha</title>
   
</head>
<body>
    <div>
    <form method="POST">
        <h1>Recuperar Senha</h1>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <input type="submit" value="Enviar">
    </form>

    <p><?php echo $mensagem; ?></p>

    <a href="logout.php">Voltar</a>

    <footer>
        <p>&copy; 2024 Recuperação de Senha | Todos os direitos reservados.</p>
    </footer></div>
</body>
</html>
