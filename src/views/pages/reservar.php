<?php
$quarto = $_GET['quarto'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/reservar.css">
</head>

<body>
    <div class="container">
        <form action="<?= $base ?>/reservarquarto" method="POST">
            <h1>Reservar</h1>
            <div class="inputs">
                <input type="hidden" name="tipoQuarto" value="<?=$_GET['quarto']?>">
                <label for="data">Data da Reserva</label>
                <input name="dataReserva" type="datetime-local" placeholder="Data da Reserva">
                <label for="data-final">Data final</label>
                <input name="dataFinal" type="datetime-local" placeholder="Data final">
                <label for="dataCheckin">Data de check-in</label>
                <input name="dataCheckin" type="datetime-local" placeholder="Data de check-in">
                <input type="text" placeholder="Método de pagamento">
                <?php
                    if($quarto == 'standard') {
                        echo '<select name="tipo">
                                <option value="">Escolha o tipo</option>
                                <option value="individual">Individual</option>
                                <option value="duplo">Duplo</option>
                                <option value="triplo">Triplo</option>
                                <option value="quadruplo">Quadruplo</option>
                            </select>
                        ';
                    } else if($quarto == 'executiva') {
                        echo '<select name="tipo">
                                <option value="">Escolha o tipo</option>
                                <option value="individual">Individual</option>
                                <option value="duplo">Duplo</option>
                            </select>
                        ';
                    }
                ?>
            </div>
            <button type="submit">Reservar</button>
        </form>
    </div>
</body>

</html>