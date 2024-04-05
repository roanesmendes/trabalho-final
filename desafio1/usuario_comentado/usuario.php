<?php
class Usuario {
    // Propriedades da classe Fornecedor
    private $conexao; // Objeto de conexão PDO
    private $tabela_nome = "usuarios"; // Nome da tabela do banco de dados

    // Propriedades públicas para os atributos do fornecedor
    public $id; // ID do fornecedor
    public $usuario; // Nome do fornecedor
    public $telefone; // Número de celular do fornecedor

    // Construtor da classe Fornecedor
    public function __construct($db) {
        $this->conexao = $db; // Atribui o objeto de conexão PDO recebido como parâmetro ao atributo $conexao
    }

    // Método para ler todos os fornecedores do banco de dados
    function ler() {
        // Monta a consulta SQL para selecionar os fornecedores da tabela
        $query = "SELECT id, nome, telefone FROM " . $this->tabela_nome;
        // Prepara a consulta SQL para execução
        $comando = $this->conexao->prepare($query);
        // Executa a consulta SQL
        $comando->execute();
        // Retorna o resultado da consulta
        return $comando;
    }

    // Método para criar um novo fornecedor no banco de dados
    function criar() {
        // Monta a consulta SQL para inserir um novo fornecedor na tabela
        $query = "INSERT INTO " . $this->tabela_nome . " SET usuario=:usuario, telefone=:telefone";
        // Prepara a consulta SQL para execução
        $comando = $this->conexao->prepare($query);
        // Remove caracteres HTML e PHP das entradas do fornecedor e do celular para evitar injeção de código
        $this->usuario = htmlspecialchars(strip_tags($this->usuario));
        $this->telefone = htmlspecialchars(strip_tags($this->telefone));
        // Vincula os parâmetros da consulta aos valores das propriedades do objeto
        $comando->bindParam(":usuario", $this->usuario);
        $comando->bindParam(":telefone", $this->telefone);
        // Executa a consulta SQL e retorna verdadeiro se bem-sucedido, falso caso contrário
        if ($comando->execute()) {
            return true;
        }
        return false;
    }
}
?>
