<?php
include_once './config/config.php';
include_once './classes/Usuario.php';

$mensagem = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = $_POST['codigo'];  // Código de verificação
    $nova_senha = $_POST['nova_senha'];  // Nova senha

    $usuario = new Usuario($db);

    // Verifica se o código é válido
    $usuario_valido = $usuario->verificarCodigo($codigo);

    if ($usuario_valido) {
        // Redefine a senha se o código for válido
        if ($usuario->redefinirSenha($codigo, $nova_senha)) {
            $mensagem = 'Senha redefinida com sucesso. Você pode <a href="index.php">entrar</a> agora.';
        } else {
            $mensagem = 'Erro ao redefinir a senha. Tente novamente.';
        }
    } else {
        $mensagem = 'Código de verificação inválido.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/redefinir.css">
    <title>Redefinir Senha</title>
</head>
<body>
    <div>
     <h1>Redefinir Senha</h1>
    <form method="POST">  
     
        <label for="codigo">Código de Verificação:</label>
        <input type="text" name="codigo" placeholder="Seu código aqui" required><br><br>
        
        <label for="nova_senha">Nova Senha:</label>
        <input type="password" name="nova_senha" required><br><br>
        
        <input type="submit" value="Redefinir Senha">
    </form></div>
    <p><?php echo $mensagem; ?></p>
</body>
</html>