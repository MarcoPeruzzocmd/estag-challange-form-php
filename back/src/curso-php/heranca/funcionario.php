<?php
require_once 'pessoa.php';
class funcionario extends pessoa {
    private $setor;
    private $trabalhando;

    function getSetor(){
        return $this->setor;
    }
    function getTrabalhando(){
        return $this->trabalhando;
    }
    function setTrabalhando($trnd){
        return $this->trabalhando = $trnd;
    }
    function setSetor($set){
        return $this-> setor = $set;
    }
    public function mudarTrabalho(){
        if ($this->trabalhando == true){
            $this-> trabalhando = false;
            if ($this->trabalhando == false){
                $this->trabalhando = "Trabalhando";
            }
        }
        else if ($this->trabalhando == false) {
            $this->trabalhando = true;
            if($this->trabalhando == true){
                $this->trabalhando = "Não está trabalhando";
            }
        }
    }
};