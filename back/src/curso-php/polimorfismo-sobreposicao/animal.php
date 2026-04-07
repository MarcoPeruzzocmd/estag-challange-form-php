<?php
abstract class animal {
private $peso;
private $idade;
private $membros;
abstract public function locomover();
abstract public function alimentar();
abstract public function emitirSom();
function getPeso(){
    return $this->peso;
}
function getIdade(){
    return $this->idade;
}
function getMembros(){
    return $this->membros;
}
function setPeso($p){
    return $this->peso = $p;
}
function setIdade($i){
    return $this->idade = $i;
}
function setMembro($m){
    return $this->membros = $m;
}
};