<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Reservas</title>
    <link rel="stylesheet" href="./assets/css/minhasreservas.css">
</head>
<body>
    <div class="container">
        <h1 class="btnQuarto">Minhas Reservas</h1>
        <div class="grid">
            <?php foreach ($minhasReservas as $reserva): ?>
                <div class="quarto">
                    <div class="info">
                        <div class="quartoInfo">
                            <div class="text">
                                <h6>Data Inicial: <?= date('d/m/Y H:i', strtotime($reserva['data_reserva'])); ?></h6>
                                <h6>Data Final: <?= date('d/m/Y H:i', strtotime($reserva['data_final'])); ?></h6>
                                <h6>Data CheckIn: <?= date('d/m/Y H:i', strtotime($reserva['data_checkin'])); ?></h6>
                                <h6>Valor: R$ <?= number_format($reserva['valortotal'], 2, ',', '.'); ?></h6>
                                <h6>N° <?= $reserva['quarto_id']; ?></h6>
                                <h6>Status: <?= ucfirst($reserva['status_reserva']); ?></h6>
                            </div>
                        </div>
                        <?php if ($reserva['status_reserva'] === 'pendente'): ?>
                            <button class="livre">Editar</button>
                            <button class="ocupado">Deletar</button>
                        <?php else: ?>
                            <button class="reservado"><?= ucfirst($reserva['status_reserva']); ?></button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
