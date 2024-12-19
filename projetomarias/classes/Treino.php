<?php

class Treino
{
    private $conn;
    private $table_name = "treino"; // Nome da tabela alterado

    // Construtor para inicializar a conexão com o banco de dados
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Método para cadastrar um treino no banco
    public function cadastrar($tipo, $exercicio, $instrutor, $descricao)
    {
        // Corrige o nome da coluna para 'fkidinstrutor' em vez de 'instrutor'
        $query = "INSERT INTO " . $this->table_name . " (tipo, exercicio, fkidinstrutor, descricao)
                 VALUES (:tipo, :exercicio, :instrutor, :descricao)";

        // Preparar a declaração SQL
        $stmt = $this->conn->prepare($query);

        // Bind dos parâmetros
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':exercicio', $exercicio);
        $stmt->bindParam(':instrutor', $instrutor);
        $stmt->bindParam(':descricao', $descricao);

        // Executar a query e retornar o resultado
        return $stmt->execute();
    }



    // Método para ler todos os treinos ou um treino específico
    public function ler($id = null)
    {
        if ($id) {
            // Se um ID for passado, buscar um treino específico


            /*  $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";*/
            $query = "SELECT treino.*, instrutor.nome AS nome_instrutor
                      FROM " . $this->table_name . " AS treino
                      INNER JOIN instrutor ON treino.fkidinstrutor = instrutor.id
                      WHERE treino.id = :id";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
        } else {
            // Caso contrário, buscar todos os treinos
            //$query = "SELECT * FROM " . $this->table_name;
            $query = "SELECT treino.*, instrutor.nome AS nome_instrutor
            FROM " . $this->table_name . " AS treino
            INNER JOIN instrutor ON treino.fkidinstrutor = instrutor.id;";
            $stmt = $this->conn->prepare($query);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna um array de resultados
    }

    // Método para atualizar os dados de um treino
    public function atualizar($id, $tipo, $exercicio, $instrutor, $descricao)
    {
        $query = "UPDATE " . $this->table_name . " SET tipo = ?, exercicio = ?, descricao = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$tipo, $exercicio, $instrutor, $descricao, $id]);
    }

    // Método para deletar um treino
    public function deletar($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
