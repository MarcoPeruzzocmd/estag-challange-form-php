<?php
         #exemplo prático de uso dos metodos getters, setters e construct
// classe
class contaBanco
{
    //atributos
    public $numConta;
    protected $tipo;
    private $dono;
    private $saldo;
    private $status;
    public function __construct(){
        $this->saldo = 0;
        $this->status = false;
        echo "conta criada com sucesso - ";
    }
    //métodos
    public function abrirConta($t) {
       $this -> setTipo($t);
       $this -> setStatus(true);
       if ($t == "CC"){
        $this -> setSaldo(50);
       }
       else if ($t == "CP") {
        $this -> setSaldo(150);
       }
    }
    public function fecharConta() {
        if ($this -> getSaldo() > 0){
            echo "Conta com dinheiro";
        }
        else if ($this -> getSaldo() < 0){
            echo "Conta em débito";
        }
        else{
           $this -> setStatus(false);
        }
    }

    public function depositar($v) {
        if ($this -> getStatus()) {
            $this -> setSaldo($this -> getSaldo() + $v);
        }
        else {
            echo "Impossível depositar";
        }
    }

    public function sacar($v) {
        if ($this -> getStatus()){
            if ($this->saldo >= $v ){
                $this -> setSaldo($this-> getSaldo() - $v);
            }
            else {
                echo "saldo insuficiente";
            }
        }
        else {
            echo "Conta desativada";
        } 
    }

    public function pagarMensal() {
        if ($this -> getTipo() == "CC") {
            $v = 12;
        }
        else if ($this -> getTipo() == "CP"){
            $v = 20;
        }
        if ($this -> getStatus()) {
            $this->setSaldo($this->getSaldo() - $v);
        } else {
            echo "Problemas com a conta, não posso cobrar";
        }
    }

    //métodos especiais
    public function setNumConta($n)
    {
        return $this->numConta = $n;
    }
    public function getNumConta()
    {
        return $this->numConta;
    }
    public function setTipo($t) {
        return $this->tipo = $t;
    }
    public function getTipo(){
        return $this->tipo;
    }
    public function setDono($d){
        return $this->dono = $d;
    }
    public function getDono(){
        return $this->dono;
    }
    public function setSaldo($s){
        return $this->saldo = $s;
    }
    public function getSaldo(){
        return $this->saldo;
    }
    public function setStatus($ss){
        return $this->status = $ss;
    }
    public function getStatus(){
        return $this->status;
    }
};
