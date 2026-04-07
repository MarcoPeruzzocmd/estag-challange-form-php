<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercicio</title>
</head>
<body>
    <pre>
    <?php
    require_once 'pessoa.php';
    require_once 'livro.php';
    $p[0] = new pessoa("Pedro", 22, "M");
    $p[1] = new pessoa("Maria", 30, "F");
    $l[0] = new livro("PHP Básico", "Maria de souza", 500, $p[0]);
    $l[1] = new livro("POO com PHP", "José da silva", 600, $p[1]);
    print_r($l[0]);
    $l[0] -> abrir();
    $l[0] -> folhear(200);
    $l[0] -> avancarPag();
    $l[0] -> voltarPag();
    $l[0] -> detalhes();

?>
</pre>
</body>
</html>