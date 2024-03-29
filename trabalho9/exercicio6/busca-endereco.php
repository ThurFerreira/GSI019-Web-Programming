<?php

require "conexao.php";
$pdo = mysqlConnect();

try {
  $sql = <<<SQL
  SELECT cep, rua, bairro, cidade
  FROM Endereco
  SQL;

  $stmt = $pdo->query($sql);
} 
catch (Exception $e) {
  exit('Query Error: ' . $e->getMessage());
}

class Endereco
{
  public $rua;
  public $bairro;
  public $cidade;

  function __construct($rua, $bairro, $cidade)
  {
    $this->rua = $rua;
    $this->bairro = $bairro;
    $this->cidade = $cidade;
  }
}

$cepform = $_GET['cep'] ?? '';

while ($row = $stmt->fetch()) {

  $cep = htmlspecialchars($row['cep']);
  $rua = htmlspecialchars($row['rua']);
  $bairro = htmlspecialchars($row['bairro']);
  $cidade = htmlspecialchars($row['cidade']);

  if($cepform == $cep){
    $endereco = new Endereco($rua, $bairro, $cidade);
  }
}

header('Content-type: application/json');
echo json_encode($endereco);