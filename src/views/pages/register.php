<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/register.css">
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
            <form action="<?= $base ?>/registro" method="POST">
                <div class="input">
                    <img src="./assets/images/pessoa.png" alt=""> <input type="text" placeholder="Nome" name="nome">
                </div>
                <div class="border"></div>

                <div class="input">
                    <img src="./assets/images/email.png" alt=""> <input type="text" placeholder="E-mail" name="email">
                </div>
                <div class="border"></div>

                <div class="input">
                    <img src="./assets/images/senha.png" alt=""> <input type="password" placeholder="Password" name="senha">
                </div>
                <div class="border"></div>

                <div class="buttons">
                    <a href="#">Ja tenho uma conta</a>
                    <button type="submit">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>