<?php
require_once 'animal.php';
class reptil extends animal{
    private $corEscama;
    function getCorEscama(){
        return $this->corEscama;
    }
    function setCorEscama($ce){
        return $this->corEscama = $ce;
    }
    public function locomover()
    {
        echo "<br>Rastejar <br>";
    }
    public function alimentar()
    {
        echo "<br>comendo vegetais <br>";
    }
    public function emitirSom()
    {
        echo "<br> som de reptil <br>";
    }
   
}