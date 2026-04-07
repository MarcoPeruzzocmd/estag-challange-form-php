<?php
require_once 'animal.php';
class peixe extends animal{
    private $corEscama;
    function getCorEscama(){
        return $this->corEscama;
    }
    function setCorEscama($ce){
        return $this->corEscama = $ce;
    }
     public function locomover()
    {
        echo "<br> nadando <br>";
    }
    public function alimentar()
    {
        echo "<br> comendo substâncias <br>";
    }
    public function emitirSom()
    {
        echo "<br> peixe não faz som <br>";
    }
}