<?php
require_once 'pessoa.php';
class aluno extends pessoa {
    private $matricula;
    private $curso;
    function setMatricula($m){
        return $this->matricula = $m;
    }
    function getCurso(){
        return $this->curso;
    }
    function setCurso($c){
        return $this->curso = $c;
    }
    public function cancelarMatr(){
        $this->matricula = null;
        if ($this->matricula == null){
            $this->matricula = "Cancelada";
        }
    }
    function getMatricula(){
        return $this->matricula;
    }
    public function detalhesAluno() {
        echo "Matrícula:" . $this->matricula;
    }
   

}
