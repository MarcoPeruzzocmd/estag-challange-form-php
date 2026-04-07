<?php
abstract class pessoa {
    private $nome;
    private $idade;
    private $sexo;
    public final function fazerAniver(){
        $this->idade ++;
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
    
};