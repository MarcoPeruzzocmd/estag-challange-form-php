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
        require_once 'mamifero.php';
        require_once 'reptil.php';
        require_once 'peixe.php';
        require_once 'ave.php';
        $mam = new mamifero();
        $r = new reptil();
        $p = new peixe();
        $a = new ave();
        $a -> locomover();
        $r -> locomover();
        ?>
    </pre>
</body>
</html>