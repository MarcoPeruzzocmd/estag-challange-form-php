<?php
class pessoa {
    private $nome;
    private $idade;
    private $sexo;

    public function fazerAniver(){
        $this->idade ++;
    }
    public function __construct($nome, $idade, $sexo){
    $this->nome = $nome;
    $this->idade = $idade;
    $this->sexo = $sexo;
}
    function getNome(){
        return $this->nome;
    }
    function getIdade(){
        return $this->idade;
    }
    function getSexo(){
        return $this->sexo;
    }
    function setNome($nm){
        return $this->nome = $nm;
    }
    function setIdade($i){
        return $this->idade = $i;
    }
    function setSexo($s){
        return $this->sexo = $s;
    }
}
?>