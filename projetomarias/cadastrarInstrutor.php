<?php
include_once './config/config.php';
include_once './classes/Instrutor.php';

// Função para calcular a idade
function calcularIdade($dataNascimento)
{
    $dataAtual = new DateTime();
    $dataNascimento = new DateTime($dataNascimento);
    $idade = $dataAtual->diff($dataNascimento);
    return $idade->y;
}

// Função para validar a idade
function validarIdade($idade)
{
    return $idade >= 20;
}

session_start();
$instrutor = new Instrutor($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $nome = htmlspecialchars(trim($_POST['nome']));
    $sexo = $_POST['sexo'];
    $fone = htmlspecialchars(trim($_POST['fone']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];
    $cpf = htmlspecialchars(trim($_POST['cpf']));
    $datanas = $_POST['datanas'];
    $area = $_POST['area'];
    $imagem = ''; // Definindo imagem por padrão como vazia

    // Calcular idade
    $idade = calcularIdade($datanas);

    // Validações
    if (!validarIdade($idade)) {
        $mensagem_erro = "Você precisa ter pelo menos 20 anos para se cadastrar.";
    } elseif (!preg_match("/^\d{3}\.\d{3}\.\d{3}-\d{2}$/", $cpf)) {
        $mensagem_erro = "CPF inválido. Por favor, use o formato XXX.XXX.XXX-XX.";
    } elseif (strtotime($datanas) > time()) {
        $mensagem_erro = "A data de nascimento não pode ser no futuro.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem_erro = "Email inválido.";
    } elseif ($instrutor->verificarEmail($email)) {
        $mensagem_erro = "O email já está cadastrado!";
    } else {
        // Verifica se a imagem foi enviada
        if (!empty($_FILES['imagem']['name'])) {
            $target_dir = "img/";  // Diretório onde as imagens serão armazenadas
            $target_file = $target_dir . basename($_FILES["imagem"]["name"]);  // Caminho do arquivo com nome

            // Obtém a extensão do arquivo
            $extensao = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Tipos de arquivos permitidos
            $tipos_permitidos = ['jpg', 'jpeg', 'png', 'pdf'];

            // Verifica se a extensão é válida
            if (!in_array($extensao, $tipos_permitidos)) {
                $mensagem_erro = "Apenas arquivos .jpg, .jpeg, .png e .pdf são permitidos.";
            } else {
                // Verifica o tipo MIME do arquivo
                $mime_type = mime_content_type($_FILES['imagem']['tmp_name']);
                $tipos_mime_permitidos = ['image/jpeg', 'image/png', 'application/pdf'];

                // Verifica se o MIME corresponde aos tipos permitidos
                if (!in_array($mime_type, $tipos_mime_permitidos)) {
                    $mensagem_erro = "O tipo MIME do arquivo não é permitido. Apenas imagens (JPG, PNG) e PDF são aceitos.";
                } else {
                    // Se passar nas validações, tenta mover o arquivo
                    if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file)) {
                        $imagem = $target_file;  // Caminho completo da imagem
                    } else {
                        $mensagem_erro = "Erro ao fazer upload da imagem.";
                    }
                }
            }
        }

        // Registra o instrutor com imagem
        if (!isset($mensagem_erro)) {
            if ($instrutor->cadastrar($nome, $cpf, $email, $senha, $fone, $sexo, $area, $datanas, $imagem)) {
                header('Location: portalI.php'); // Redireciona para o portalI
                exit();
            } else {
                $mensagem_erro = "Erro ao cadastrar. Tente novamente!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Registrar</title>
    <link rel="stylesheet" href="styles/cadI.css">
</head>
<body>
    <h1>Registrar</h1>
    <form action="cadastrarInstrutor.php" method="POST" enctype="multipart/form-data">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required><br>

        <label for="fone">Telefone:</label>
        <input type="text" name="fone" id="fone" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required><br>

        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" placeholder="XXX.XXX.XXX-XX" required>

        <label for="datanas">Data de Nascimento:</label>
        <input type="date" name="datanas" id="datanas" required><br>

        <label>Área de Atuação:</label>
            <div class="radio">
                <label><input type="radio" name="area" value="G" required> Ginástica</label>
                <label><input type="radio" name="area" value="P" required> Personal Trainer</label>
                <label><input type="radio" name="area" value="F" required> Fisioterapia</label>
                <label><input type="radio" name="area" value="E" required> Especial</label>
            </div>
            <label>Sexo:</label>
            <div class="radio">
                <label><input type="radio" name="sexo" value="M" required> Masculino</label>
                <label><input type="radio" name="sexo" value="F" required> Feminino</label>
            </div>
        <label for="imagem">Imagem:</label>
        <input type="file" name="imagem" id="imagem" accept=".jpg,.jpeg,.png,.pdf"><br>

        <input type="submit" value="Enviar">
    </form>

    <p>Já tem conta? <br> <a href="./loginI.php">Clique Aqui</a></p>
    <p>Esqueceu a senha? <br> <a href="./solicitar_recuperacao.php">Clique Aqui</a></p>

    <?php if (isset($mensagem_erro)): ?>
        <p class="error-message"><?php echo $mensagem_erro; ?></p>
    <?php endif; ?>
</body>
</html>