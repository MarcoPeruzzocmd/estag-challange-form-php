<?php
require_once 'animal.php';
class mamifero extends animal{
    private $corPelo;
    public function locomover()
    {
        echo "<br>Correndo <br> ";
    }
    public function alimentar()
    {
        echo "<br>Mamando <br>";
    }
    public function emitirSom()
    {
        echo "<br>som de mamífero <br>";
    }
    public function getCorPelo(){
        return $this->corPelo;
    }
    public function setCorPelo($cp){
        return $this->corPelo = $cp;
    }
}