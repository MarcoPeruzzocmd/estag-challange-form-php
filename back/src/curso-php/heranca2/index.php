<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <pre>
    <?php
    require_once 'pessoa.php';
    require_once 'visitante.php';
    require_once 'aluno.php';
    require_once 'bolsista.php';
    $p1 = new Visitante();
    $p1 -> setNome("Maria");
    $p1 -> setIdade(17);
    $p1 -> fazerAniver();
    $p2 = new aluno();
    $p2 -> setMatricula(11111);
    $p2 -> setCurso("Info");
    $p2 -> setIdade(20);
    $p2 -> setNome("Pedro");
    $p2 -> pagarMensalidade();
    $p3 = new bolsista();
    $p3 -> setBolsa("50%");
    $p3 -> pagarMensalidade();
    print_r($p1);
    print_r($p2);
    ?>
    </pre>
</body>
</html>