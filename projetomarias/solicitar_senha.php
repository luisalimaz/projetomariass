<?php
include_once './config/config.php';
include_once './classes/Usuario.php';

$mensagem = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $usuario = new Usuario($db);

    // Verifica se o código foi gerado com sucesso
    $codigo = $usuario->gerarCodigoVerificacao($email);
    if ($codigo) {
        // Aqui você pode enviar o código por e-mail, mas, por enquanto, vamos exibi-lo.
        // Em um cenário real, você usaria uma função de envio de e-mail (mail()) ou uma API de e-mail.
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
    <link rel="stylesheet" href="styles/solicitarS.css">
    <title>Recuperar Senha</title>
</head>
<body>
    <h1>Recuperar Senha</h1>
    <form method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>
        <input type="submit" value="Enviar">
    </form>
    <p><?php echo $mensagem; ?></p>
    <a href="index.php">Voltar</a>
</body>
</html>