<?php
require_once 'pessoa.php';
class aluno extends pessoa{
    private $matricula;
    private $curso;
    public function pagarMensalidade(){
        echo "Pagando mensalidade " . $this->getNome();
        echo"<br>";
    }
    function getMatricula(){
        return $this->matricula;
    }
    function getCurso(){
        return $this->curso;
    }
    function setMatricula($m){
        return $this->matricula = $m;
    }
    function setCurso($c){
        return $this->curso = $c;
    }
};