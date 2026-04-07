<?php
require_once 'lutadorFunc.php';
class lutador implements lutadorFunc {
    private $nome;
    private $nacionalidade;
    private $idade;
    private $altura;
    private $peso;
    private $categoria;
    private $vitorias;
    private $derrotas;
    private $empates;

    public function __construct($nm, $nc, $i, $a, $p, $v, $d, $e){
        $this->nome = $nm;
        $this->nacionalidade = $nc;
        $this->idade = $i;
        $this->altura = $a;
        $this->setPeso($p);
        $this->vitorias = $v;
        $this->derrotas = $d;
        $this->empates = $e;
    }
    public function getNome(){
        return $this->nome;
    }
    public function getNacionalidade(){
        return $this->nacionalidade;
        }
    public function getIdade(){
        return $this->idade;
    }
    public function getAltura(){
        return $this->altura;
    }
    public function getPeso(){
        return $this->peso;
    }
    public function getCategoria(){
        return $this->categoria;
    }
    public function getVitorias(){
        return $this->vitorias;
    }
    public function getDerrotas(){
        return $this->derrotas;
    }
    public function getEmpates(){
        return $this->empates;
    }
    public function setNome($nm){
        return $this->nome = $nm;
        }
    public function setNacionalidade($nc){
        return $this->nacionalidade = $nc;
    }
    public function setIdade($i){
        return $this->idade = $i;
        }
    public function setAltura($a){
        return $this->altura = $a;
        }
    public function setPeso($p){
        $this->peso = $p;
        $this->setCategoria();
        }
    private function setCategoria(){
        if ($this-> peso < 52.2) {
            $this->categoria = "inválido ";
        }
        elseif ($this->peso <= 70.3){
            $this->categoria = "leve ";
        }
        elseif ($this->peso <= 83.9) {
            $this->categoria = "PESO-PESADO ";
        }
        else{
            $this->categoria = "inválido ";
        }
        }
    private function setVitorias($v){
        return $this->vitorias = $v;
    }
    private function setDerrotas($d){
        return $this->derrotas = $d;
    }
    private function setEmpates($e){
        return $this->empates = $e;
    }
    public function apresentar(){
        echo "Lutador:" . $this->getNome();
        echo "Origem:" . $this->getNacionalidade();
        echo $this->getNome(), "anos";
        echo $this->getAltura(), "m de altura";
        echo "Pesando: " . $this->getPeso(), "kg";
        echo "Ganhou" . $this->getVitorias();
        echo "Empatou" . $this->getEmpates();
        echo "Perdeu" . $this->getDerrotas();
    }
    public function status(){
        echo $this->getNome();
        echo " é um peso " , $this->getCategoria();
        echo "e tem " , $this-> getVitorias(), " vitórias, ";
        echo $this->getDerrotas()," derrotas, ";
        echo $this->getEmpates(), " empates.";
    }
    public function ganharLuta(){
        $this->setVitorias($this->getVitorias() + 1);
    }
    public function perderLuta(){
        $this->setDerrotas($this->getDerrotas() + 1);
    }
    public function empatarLuta(){
        $this->setEmpates($this->getEmpates() + 1);
    }
};