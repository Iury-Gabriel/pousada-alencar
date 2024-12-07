<?php

$showEmailForm = !isset($_SESSION['email_sent']);
$showCodeForm = isset($_SESSION['email_sent']) && !isset($_SESSION['code_verified']);
$showPasswordForm = isset($_SESSION['code_verified']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperação de Senha</title>
    <link rel="stylesheet" href="./assets/css/forgot-password.css">
</head>
<body>
    <div class="container">
        <h2>Recuperação de Senha</h2>

        <!-- Formulário de E-mail -->
        <?php if ($showEmailForm): ?>
        <form action="<?= $base ?>/send-verification-code" method="POST">
            <div class="input-group">
                <input type="email" name="email" placeholder="Digite seu e-mail" required>
            </div>
            <div class="input-group">
                <button type="submit">Enviar Código</button>
            </div>
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="error-message"><?= $_SESSION['error_message'] ?></div>    
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>
        </form>
        <?php endif; ?>

        <!-- Formulário de Código de Verificação -->
        <?php if ($showCodeForm): ?>
        <form action="<?= $base ?>/verify-code" method="POST">
            <div class="input-group">
                <input type="text" name="code" placeholder="Digite o código de 6 dígitos" maxlength="6" required>
            </div>
            <div class="input-group">
                <button type="submit">Verificar Código</button>
            </div>
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="error-message"><?= $_SESSION['error_message'] ?></div>    
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>
        </form>
        <?php endif; ?>

        <!-- Formulário para Redefinição de Senha -->
        <?php if ($showPasswordForm): ?>
        <form action="<?= $base ?>/reset-password" method="POST">
            <div class="input-group">
                <input type="password" name="new-password" placeholder="Nova senha" required>
            </div>
            <div class="input-group">
                <input type="password" name="confirm-password" placeholder="Confirme a nova senha" required>
            </div>
            <div class="input-group">
                <button type="submit">Redefinir Senha</button>
            </div>
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="error-message"><?= $_SESSION['error_message'] ?></div>    
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>
