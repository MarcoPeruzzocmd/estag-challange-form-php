<?php
require_once 'animal.php';
class ave extends animal{
    private $corPena;
    function getCorPena(){
        return $this->corPena;
    }
    function setCorPena($ce){
        return $this->corPena = $ce;
    }
     public function locomover()
    {
        echo "<br> voar <br>";
    }
    public function alimentar()
    {
        echo "<br> comendo nada <br>";
    }
    public function emitirSom()
    {
        echo "<br> gritando <br>";
    }
    public function fazerNinho(){
        echo "<br> fazendo ninho <br>";
    }
}