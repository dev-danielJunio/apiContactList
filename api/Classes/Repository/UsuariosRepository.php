<?php

namespace Classes\Repository;

use Classes\DB\MySQL;

class UsuariosRepository{

    private object $MySQL;
    public const TABELA = "usuarios";

    public function __construct()
    {
        $this->MySQL = new MySQL();
    }

    public function getRegistroByLogin($nome)
    {
        $consulta = 'SELECT * FROM ' . self::TABELA . ' WHERE nome = :login';
        $stmt = $this->MySQL->getDb()->prepare($consulta);
        $stmt->bindParam(':login', $nome);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function insertUser($nome, $senha, $email, $telefone){
        $consultaInsert = 'INSERT INTO ' .self::TABELA . ' (nome, senha, email, telefone) VALUES (:nome, :senha, :email, :telefone)';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaInsert);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function updateUser($id, $dados){
        $consultaUpdate = 'UPDATE ' . self::TABELA . ' SET nome = :nome, senha = :senha, email = :email, telefone = :telefone WHERE id = :id';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaUpdate);
        $stmt->bindParam(':nome', $dados['nome']);
        $stmt->bindParam(':senha', $dados['senha']);
        $stmt->bindParam(':email', $dados['email']);
        $stmt->bindParam(':telefone', $dados['telefone']);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function getMySQL(){
        return $this->MySQL;
    }
}