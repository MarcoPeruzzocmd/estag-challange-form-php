<?php
    #RELACIONAMENTO DE CLASSE -> AGREGAÇÃO DE OBJETOS E CLASSES
require_once 'lutador.php';
class luta {
private $desafiado;
private $desafiante;
private $rounds;
private $aprovada;
private function getDesafiado(){
    return $this->desafiado;
}
private function getDesafiante(){
    return $this-> desafiante;
}
private function getRounds(){
    return $this-> rounds;
}
private function getAprovada(){
    return $this-> aprovada;
}
private function setDesafiado($dd){
    return $this->desafiado=$dd;
}
private function setDesafiante($dt){
    return $this->desafiante = $dt;
}
private function setRounds($r){
    return $this->rounds=$r;
}
private function setAprovada($a){
    return $this->aprovada=$a;
}
public function marcarLuta($l1, $l2){
    if ($l1->getCategoria() === $l2->getCategoria() && ($l1!=$l2)){
        $this->aprovada = true;
        $this->desafiado = $l1;
        $this->desafiante = $l2; 
    }
    else {
            $this->aprovada = false;
            $this-> desafiado = null;
            $this-> desafiante = null;
        }
}
public function lutar(){
    if ($this->aprovada){
        $this->desafiado->apresentar();
        echo"<br>";
        $this->desafiante->apresentar();
        $vencedor = rand(0,2);
        switch ($vencedor){
            case 0:
                echo "<p>EMPATE</p>";
                $this->desafiado->empatarLuta();
                break;
            case 1:
                echo"<p> ". $this->desafiado->getNome() ." venceu</p>";
                $this->desafiado->ganharLuta();
                $this->desafiante->perderLuta();
                break;
            case 2:
                echo"<p> ". $this->desafiante->getNome() ." venceu </p>";
                $this->desafiante->ganharLuta();
                $this->desafiado->perderLuta();
                break;    
        }    
    }
    else{
        echo "ERRO";
    }
}
};
?>