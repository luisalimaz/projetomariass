<?php
class Agendamento
{
    private $conn;
    private $table_name = "agendamento"; // Nome da tabela

    // Construtor para inicializar a conexão com o banco de dados
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // Método para cadastrar um novo agendamento
    public function cadastrar($data, $horario, $aluno, $treino, $instrutor)
    {
        $query = "INSERT INTO " . $this->table_name . " (data, horario, aluno, treino, instrutor) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$data, $horario, $aluno, $treino, $instrutor]);
    }

    // Método para listar todos os agendamentos
    public function ler()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt; // Retorna todos os agendamentos
    }

    // Método para buscar um agendamento pelo ID
    public function lerPorId($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna os dados do agendamento
    }

    // Método para atualizar um agendamento (apenas se o aluno for o dono do agendamento)
    public function atualizar($id, $data, $horario, $treino, $instrutor, $aluno)
    {
        // Verifica se o aluno é o dono do agendamento
        $agendamento = $this->lerPorId($id);
        if ($agendamento['aluno'] == $aluno) {
            $query = "UPDATE " . $this->table_name . " SET data = ?, horario = ?, treino = ?, instrutor = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$data, $horario, $treino, $instrutor, $id]);
        } else {
            return false; // Retorna false se o aluno tentar editar um agendamento que não é dele
        }
    }

    // Método para deletar um agendamento (apenas se o aluno for o dono do agendamento)
    public function deletar($id, $aluno)
    {
        // Verifica se o aluno é o dono do agendamento
        $agendamento = $this->lerPorId($id);
        if ($agendamento['aluno'] == $aluno) {
            $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$id]);
        } else {
            return false; // Retorna false se o aluno tentar excluir um agendamento que não é dele
        }
    }

    // Método para listar agendamentos de um aluno
    public function agendamentosPorAluno($alunoId)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE aluno = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$alunoId]);
        return $stmt; // Retorna os agendamentos de um aluno
    }

    // Método para listar agendamentos de um instrutor
    public function agendamentosPorInstrutor($instrutorId)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE instrutor = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$instrutorId]);
        return $stmt; // Retorna os agendamentos de um instrutor
    }
}
?>
