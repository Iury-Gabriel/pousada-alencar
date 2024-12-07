<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/login.css">
</head>

<body>
    <div class="container">
        <div class="lateral">
            <img src="./assets/images/lateral.png" alt="">
        </div>
        <div class="login">
            <div class="logo">
                <a href="index.php"><img src="./assets/images/logo.png" alt="logo"></a>
            </div>
            <form action="<?= $base ?>/login" method="POST">
                <div class="input">
                    <img src="./assets/images/email.png" alt=""> <input type="text" placeholder="E-mail" name="email">
                </div>
                <div class="border"></div>

                <div class="input">
                    <img src="./assets/images/senha.png" alt=""> <input type="password" placeholder="Password" name="senha">
                </div>
                <div class="border"></div>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="error"><?= $_SESSION['error'] ?></div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <div class="buttons">
                    <a href="<?= $base ?>/forgot-password">Esqueceu a senha?</a>
                    <button type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>