<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conta</title>
</head>
<body> 
    <pre>
    <?php 
        #exemplo prático de uso dos metodos getters, setters e construct
    require_once 'contaBanco.php';
    $p1 = new contaBanco();
    $p2 = new contaBanco();
    $p1 -> abrirConta("CC");
    $p1 -> setDono("Jubileu");
    $p1 -> setNumConta(1111);
    $p2 -> abrirConta("CP");
    $p2 -> setDono("Creuza");
    $p2 -> setNumConta(2222);

    $p1 -> depositar(300);
    $p2 -> depositar(500);

    $p2 -> sacar(630);

    $p1 -> pagarMensal();
    $p2 -> pagarMensal();

    $p2 -> fecharConta();

    print_r ($p1);
    print_r($p2);
    ?>
    </pre>
</body>
</html>