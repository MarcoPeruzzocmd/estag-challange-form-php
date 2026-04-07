<?php
require_once 'aluno.php';
class bolsista extends aluno{
    private $bolsa;
    public function renovarBolsa(){
        
    }
    public function pagarMensalidade() {
        echo "pagando de bolsista" . $this->getBolsa();
    }
    function getBolsa(){
        return $this->bolsa;
    }
    function setBolsa($b){
        return $this->bolsa = $b;
    }
}