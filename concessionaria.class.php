<?php
class Concessionaria {
    private $id;
    private $nome;
    private $conn;

    public function __construct($id = null, $nome = null) {
        $this->conn = (new Database())->getConnection();  
        if ($id) {
            $this->id = $id;
            $this->nome = $nome;
        }
    }

    public function getById($id) {
        $query = "SELECT id, nome FROM concessionarias WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->id = $row['id'];
            $this->nome = $row['nome'];
            return $this;
        }

        return null;
    }

    
    public function save() {
        if ($this->id) {
            $query = "UPDATE concessionarias SET nome = :nome WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":nome", $this->nome);
        } else {
            $query = "INSERT INTO concessionarias (nome) VALUES (:nome)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":nome", $this->nome);
        }

        return $stmt->execute();
    }

    public function __toString() {
        return "Concessionária(ID: {$this->id}, Nome: {$this->nome})";
   
   
    }
}
?>
