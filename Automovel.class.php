<?php
class Automovel {
    private $id;
    private $modelo;
    private $preco;
    private $conn;

    public function __construct($id = null, $modelo = null, $preco = null) {
        $this->conn = (new Database())->getConnection();  
        if ($id) {
            $this->id = $id;
            $this->modelo = $modelo;
            $this->preco = $preco;
        }
    }


    public function getById($id) {
        $query = "SELECT id, modelo, preco FROM automoveis WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->id = $row['id'];
            $this->modelo = $row['modelo'];
            $this->preco = $row['preco'];
            return $this;
        }

        return null;
    }

    public function save() {
        if ($this->id) {
            $query = "UPDATE automoveis SET modelo = :modelo, preco = :preco WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":modelo", $this->modelo);
            $stmt->bindParam(":preco", $this->preco);
        } else {
            $query = "INSERT INTO automoveis (modelo, preco) VALUES (:modelo, :preco)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":modelo", $this->modelo);
            $stmt->bindParam(":preco", $this->preco);
        }

        return $stmt->execute();
    }

    public function __toString() {
        return "Automóvel(ID: {$this->id}, Modelo: {$this->modelo}, Preço: {$this->preco})";
    }
}
?>
