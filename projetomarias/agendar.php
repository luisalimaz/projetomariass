<?php
// Inclui as classes necessárias e conecta ao banco de dados
require_once 'classes/Database.php';
require_once 'classes/Instrutor.php';
require_once 'classes/Usuario.php';
require_once 'classes/Agendamento.php';

$db = (new Database())->getConnection();
$instrutorObj = new Instrutor($db);
$instrutores = $instrutorObj->ler(); // Método que retorna todos os instrutores
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agende sua aula experimental</title>
    <link rel="stylesheet" href="styles/agendar.css">
</head>
<body>
<div class="form-container">
    <h1>Agende sua aula</h1>
    <form method="POST" action="agendamento.php">
        <!-- Campo de Data -->
        <label for="data">Data do Agendamento:</label>
        <input type="date" id="data" name="data" min="2024-12-18" max= "2024-12-31"required>
        <br><br>

        <!-- Campo de Horário -->
        <label for="horario">Selecione um horário (06:00 - 00:30):</label>
        <input type="time" id="horario" name="horario" required>
        <br><br>

        <!-- Campo de Tipo de Treino -->
        <label for="treino">Tipo de Treino:</label>
        <input type="text" id="treino" name="treino" placeholder="Ex: Especial, CrossFit" required>
        <br><br>

        <!-- Campo de Nome do Aluno -->
        <label for="aluno">Nome do Aluno:</label>
        <input type="text" id="aluno" name="aluno" placeholder="Seu nome" required>
        <br><br>

        <!-- Botão de Envio -->
        <button type="submit" class="btn-agendar">Agendar Aula</button>
    </form>
    <script src="agendar.js"></script>
</div>

<script>
    const timeInput = document.getElementById("horario");

    timeInput.addEventListener("input", () => {
        const timeValue = timeInput.value;
        const [hours, minutes] = timeValue.split(":").map(Number);
        const timeInMinutes = hours * 60 + minutes;

        // Validações de horário (06:00 a 00:30)
        const isValidTime =
            (timeInMinutes >= 360 && timeInMinutes <= 1440) || 
            (timeInMinutes >= 0 && timeInMinutes <= 30);

        if (!isValidTime) {
            alert("Por favor, insira um horário entre 06:00 e 00:30.");
            timeInput.value = ""; // Limpa o campo
        }
    });
</script>
</body>
</html>