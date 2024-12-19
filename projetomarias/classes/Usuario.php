<?php
class Usuario
{
    private $conn;
    private $table_name = "usuario"; // Nome da tabela

    // Construtor para inicializar a conexão com o banco de dados
    public function __construct($db)
    {
        $this->conn = $db;
    }

    
    // Método para registrar um novo usuário
    public function registrar($nome, $email, $senha, $fone, $sexo, $cpf, $dataN, $peso, $altura)
    {
        $query = "INSERT INTO " . $this->table_name . " (nome, email, senha, fone, sexo, cpf, dataN, peso, altura) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($senha, PASSWORD_BCRYPT); // Hash da senha
        return $stmt->execute([$nome, $email, $hashed_password, $fone, $sexo, $cpf, $dataN, $peso, $altura]);
    }

    // Método para fazer login
    public function login($email, $senha)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }
        return false;
    }

    // Método para verificar se um email já está cadastrado
    public function verificarEmail($email)
    {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0; // Retorna true se o email já estiver cadastrado
    }

    // Método para listar todos os usuários
    public function ler()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt; // Retorna todos os usuários
    }
   
    
        // Função para listar os instrutores
        public function leri() {
            $query = "SELECT id, nome FROM " . $this->table_name;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    
    // Método para buscar um usuário pelo ID
    public function lerPorId($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna os dados do usuário
    }

    // Método para atualizar os dados de um usuário
    public function atualizar($id, $nome, $email, $fone, $sexo, $cpf, $dataN, $peso, $altura)
    {
        $query = "UPDATE " . $this->table_name . " SET nome = ?, sexo = ?, fone = ?, email = ?, cpf = ?, dataN = ?, peso = ?, altura = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$nome, $sexo, $fone, $email, $cpf, $dataN, $peso, $altura, $id]);
    }

    // Método para deletar um usuário
    public function deletar($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    // Método para gerar um código de verificação
    public function gerarCodigoVerificacao($email)
    {
        $codigo = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 10);
        $query = "UPDATE " . $this->table_name . " SET codigo_verificacao = ? WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$codigo, $email]);
        return ($stmt->rowCount() > 0) ? $codigo : false;
    }

    // Método para verificar o código de verificação
    public function verificarCodigo($codigo)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE codigo_verificacao = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$codigo]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna os dados do usuário, se o código for válido
    }

    // Método para redefinir a senha e remover o código de verificação
    public function redefinirSenha($codigo, $senha)
    {
        $query = "UPDATE " . $this->table_name . " SET senha = ?, codigo_verificacao = NULL WHERE codigo_verificacao = ?";
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($senha, PASSWORD_BCRYPT); // Hash da nova senha
        return $stmt->execute([$hashed_password, $codigo]);
    }
}
?>
