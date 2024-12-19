<?php
session_start();
include_once './config/config.php';
include_once './classes/Instrutor.php';

$instrutor = new Instrutor($db);  // Instanciando a classe Instrutor

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizando o CPF e a senha
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);  // Utiliza CPF como string
    $senha = $_POST['senha'];

    // Verifica se o instrutor com o CPF e senha existe
    if ($dados_instrutor = $instrutor->login($email, $senha)) {
        // Armazenar as informações do instrutor na sessão
        $_SESSION['instrutor_id'] = $dados_instrutor['id']; 
        $_SESSION['instrutor_nome'] = $dados_instrutor['nome'];

        header('Location: portalI.php');
        exit();
    } else {
        // Mensagem de erro caso as credenciais estejam incorretas
        $mensagem_erro = "CPF ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="styles/loginI.css">
</head>

<body>
    <div id="container">
        <div class="container">
            <h1 id="titulo">Login</h1>
            <form method="POST">

            <label for="email">Email:</label>
                <input type="email" name="email" required>
                
                <label for="senha">Senha:</label>
                <input type="password" name="senha" required>
                <input type="submit" value="Entrar">
            </form>

            <p>Esqueceu a senha?  <br> <a href="./solicitar_recuperacao.php">Clique Aqui</a></p>

            <?php if (isset($mensagem_erro)): ?>
                <div class="error-message">
                    <?php echo $mensagem_erro; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
