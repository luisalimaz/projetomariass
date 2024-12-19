<?php
// Configuração de conexão com o banco de dados
$host = 'localhost';     // endereço do servidor
$dbname = 'bdacademia'; // nome do banco de dados
$username = 'root';   // seu nome de usuário do banco
$password = '';     // sua senha do banco

// Cria a conexão com o banco de dados
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Habilita os erros de PDO
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
    die();
}

// Inclua o arquivo da classe Usuario
include_once 'classes/Usuario.php';

// Crie uma instância da classe Usuario, passando a conexão com o banco como argumento
$usuario = new Usuario($db);

// Agora você pode usar os métodos da classe Usuario
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Agendamentos</title>
    <link rel="stylesheet" href="styles/agendamento.css">
</head>
<body>
    <div class="container">
        <h1>Calendário de Agendamentos</h1>

        <?php
        $mesAtual = date('m');
        $anoAtual = date('Y');
        $primeiroDiaDoMes = "$anoAtual-$mesAtual-01";
        $ultimoDiaDoMes = date('Y-m-t', strtotime($primeiroDiaDoMes));
        $primeiroDiaDaSemana = date('w', strtotime($primeiroDiaDoMes));
        $totalDiasNoMes = date('t', strtotime($primeiroDiaDoMes));
        ?>

        <!-- Calendário -->
        <div class="calendario">
            <div class="mes">
                <h2><?php echo strftime('%B de %Y', strtotime($primeiroDiaDoMes)); ?></h2>
            </div>
            <div class="dias">
                <?php
                $diasSemana = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
                foreach ($diasSemana as $dia) {
                    echo "<div class='dia semana'>$dia</div>";
                }

                for ($i = 0; $i < $primeiroDiaDaSemana; $i++) {
                    echo '<div class="dia vazio"></div>';
                }

                for ($dia = 1; $dia <= $totalDiasNoMes; $dia++) {
                    $dataAtual = "$anoAtual-$mesAtual-" . str_pad($dia, 2, '0', STR_PAD_LEFT);
                    $temAgendamento = isset($agendamentosPorData[$dataAtual]);
                    ?>
                    <div class="dia <?php echo $temAgendamento ? 'agendado' : ''; ?>">
                        <span class="numero"><?php echo $dia; ?></span>
                        <?php if ($temAgendamento): ?>
                            <span class="bolinha"></span>
                        <?php endif; ?>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Lista de Agendamentos -->
        <h2>Agendamentos do Mês</h2>
        <?php if (!empty($agendamentos)): ?>
            <table border="1">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Aluno</th>
                        <th>Treino</th>
                        <th>Instrutor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($agendamentos as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['data']); ?></td>
                            <td><?php echo htmlspecialchars($item['horario']); ?></td>
                            <td><?php echo htmlspecialchars($item['aluno']); ?></td>
                            <td><?php echo htmlspecialchars($item['treino']); ?></td>
                            <td><?php echo htmlspecialchars($item['instrutor']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum agendamento registrado.</p>
        <?php endif; ?>
    </div>
</body>
</html>