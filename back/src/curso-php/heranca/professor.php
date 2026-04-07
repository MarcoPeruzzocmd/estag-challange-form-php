<?php
require_once 'pessoa.php';
class professor extends pessoa{
    private $especialidade;
    private $salario;

    function getSalario(){
        return $this->salario;
    }
    function setSalario($sal){
        return $this->salario = $sal;
    }
    function getEspecialidade(){
        return $this->especialidade;
    }
    function setEspecialidade($e){
        return $this->especialidade = $e;
    }
    public function receberAumento($aum){
        $this-> salario += $aum;
    }
};