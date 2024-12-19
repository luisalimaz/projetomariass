

<?php

class Instrutor
{
    private $conn;
    private $table_name = "instrutor"; // Nome da tabela

    // Construtor para inicializar a conexão com o banco de dados
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Método para cadastrar um novo instrutor
    public function cadastrar($nome, $cpf, $email, $senha, $fone, $sexo, $area, $datanas, $imagem)
    {
         // Caso uma imagem tenha sido carregada, mova o arquivo para o diretório desejado
         if (!empty($imagem)) {
            $imagem = "img/" . basename($imagem);  // Caminho da pasta img e nome do arquivo
        }
        $query = "INSERT INTO " . $this->table_name . " (nome, cpf, email, senha, fone, sexo, area, datanas, imagem) 
                  VALUES (?,?,?,?,?,?,?,?,?)";
        
                  $stmt = $this->conn->prepare($query);
                  $stmt->bindParam(':nome', $nome);
                  $stmt->bindParam(':cpf', $cpf);
                  $stmt->bindParam(':email', $email);
                  $stmt->bindParam(':senha', $senha);
                  $stmt->bindParam(':fone', $fone);
                  $stmt->bindParam(':sexo', $sexo);
                  $stmt->bindParam(':area', $area);
                  $stmt->bindParam(':datanas', $datanas);
                  $stmt->bindParam(':imagem', $imagem);
                  $hashed_password = password_hash($senha, PASSWORD_BCRYPT); // Hash da senha

     return $stmt->execute([$nome, $cpf, $email, $hashed_password, $fone, $sexo, $area, $datanas, $imagem]);
     
    }    
   
   public function login($email, $senha) {
    $query = "SELECT * FROM " . $this->table_name . " WHERE email = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$email]);
    $instrutor = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($instrutor && password_verify($senha, $instrutor['senha'])) {
        return $instrutor;
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

    // Método para listar 
    public function ler()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt; 
    }

    // Método para buscar por ID
    public function lerPorId($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    // Método para atualizar os dados
    public function atualizar($nome, $cpf, $email, $senha, $fone, $sexo, $area, $datanas, $imagem)
    {
        $query = "UPDATE " . $this->table_name . " SET nome = ?, cpf = ?, email = ?, senha = ?, fone = ?, sexo = ?, area = ?, datanas = ?, imagem = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$nome, $cpf, $email, $senha, $fone, $sexo, $area, $datanas, $imagem]);
    }

    // Método para deletar um 
    public function deletar($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}

?>