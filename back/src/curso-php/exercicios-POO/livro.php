<?php
require_once 'pessoa.php';
require_once 'publicacao.php';
class livro implements publicacao{
    private $titulo;
    private $autor;
    private $totPaginas;
    private $pagAtual;
    private $aberto;
    private $leitor;

    public function __construct($t, $a, $totP, $l)
    {
        $this->titulo = $t;
        $this->autor = $a;
        $this->totPaginas =$totP;
        $this->pagAtual = 0;
        $this->aberto = false;
        $this->leitor = $l;
    }
    private function getTitulo(){
        return $this->titulo;
    }
    private function getAutor(){
        return $this->autor;
    }
    private function gettotPaginas(){
        return $this->totPaginas;
    }
    private function getpagAtual(){
        return $this->pagAtual;
    }
    private function getAberto(){
        return $this->aberto;
    }
    private function getLeitor(){
        return $this->leitor;
    }
    private function setTitulo($t){
        return $this->titulo=$t;
    }
    private function setAutor($a){
        return $this->autor=$a;
    }
    private function settotPaginas($totP){
        return $this->totPaginas = $totP;
    }
    private function setpagAtual($pg){
        return $this->pagAtual = $pg;
    }
    private function setAberto($ab){
        return $this->aberto=$ab;
    }
    private function setLeitor($l){
        return $this->leitor=$l;
    }
    public function detalhes(){
      echo "Livro " . $this->titulo . " escrito por " . $this->autor;
      echo "<br> Paginas: " . $this->totPaginas;
      echo "<br> Sendo lido por " . $this->leitor->getNome();
      echo "<br> Pagina atual: " . $this->pagAtual; 
      $this->pagFaltante();
    }
    public function abrir()
    {
        $this->aberto = true;
    }
    public function fechar()
    {
        $this->aberto = false;
    }
    public function folhear($p)
    {
        if ($p > $this->totPaginas){
            $this->pagAtual = 0;
        }
        else {
            $this->pagAtual = $p;
        }
    }
    public function avancarPag()
    {
        $this->pagAtual ++;
    }
    public function voltarPag()
    {
        $this->pagAtual --;
    }
    public function pagFaltante(){
        $pagFaltante = $this->totPaginas - $this->pagAtual;;
        echo "<br>Paginas faltantes: $pagFaltante";
    }
}
?>