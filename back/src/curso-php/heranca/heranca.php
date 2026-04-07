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
        require_once 'aluno.php';
        require_once 'professor.php';
        require_once 'funcionario.php';
        $p1 = new pessoa("Maria", 16, "F");
        $p2 = new aluno("Fabiana", 31, "F");
        $p3 = new professor("Mario", 40, "M" );
        $p4 = new funcionario("Marco", 18, "M");
        $p2->setCurso("PHP");
        $p2->setMatricula(123456);
        $p3->setSalario(2200);
        $p3->setEspecialidade("Matematica");
        $p3->receberAumento(1000);
        $p4 -> setSetor("Tecnologia");
        $p2->cancelarMatr();
        $p4->mudarTrabalho();
        print_r($p1);
        print_r($p2);
        print_r($p3);
        print_r($p4);
        ?>
    </pre>
</body>
</html>