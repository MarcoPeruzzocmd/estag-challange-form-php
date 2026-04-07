<?php
class pessoa {
    private $nome;
    private $idade;
    private $sexo;

    public function __construct($nm, $i, $s,){
        $this->nome = $nm;
        $this->idade = $i;
        $this->sexo = $s;
    }
    public function getNome(){
        return $this->nome;
    }
    private function getIdade(){
        return $this->idade;
    }
    private function getSexo(){
        return $this->sexo;
    }
    private function setNome($nm){
        return $this->nome = $nm;
    }
    private function setIdade($i){
        return $this->idade = $i;
    }
    private function setSexo($s){
        return $this->sexo = $s;
    }
    public function fazerAniver(){
        $this->idade ++;;
    }
}
?>