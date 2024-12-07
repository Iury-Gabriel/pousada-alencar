<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/home.css">
    <title>Home - Pousada Alencar</title>
</head>

<body>
    <div class="container">
        <div class="navbar">
            <div class="logo">
                <a href="<?= $base ?>/"><img src="./assets/images/logo.png" alt="logo"></a>
            </div>
            <ul>
                <li><a href="<?= $base ?>/">Home</a></li>
                <li><a href="<?= $base ?>/reservas">Reservas</a></li>
                <li><a href="<?= $base ?>/quartos">Quartos</a></li>
                <li><a href="<?= $base ?>/login">Login</a></li>
            </ul>
        </div>
        <h3 class="welcome">Bem-Vindo</h3>
        <h1><span class="blue">P</span>ousada <span class="orange">A</span>lencar</h1>
        <h3 class="slogan">Seu Lar Longe de Casa</h3>
    </div>

    <div class="ourServices">
        <h2>Conheça um pouco sobre</h2>
        <h1>Nossos Serviços</h1>
        <div class="border"></div>
        <div class="services">
            <div class="card">
                <img src="./assets/images/cafe.jpg" alt="room">
                <h3>Cafe da manha</h3>
                <div class="border2"></div>
            </div>
            <div class="card">
                <img src="./assets/images/academia.jpg" alt="room">
                <h3>Academia</h3>
                <div class="border3"></div>
            </div>
            <div class="card">
                <img src="./assets/images/estacionamento.jpg" alt="room">
                <h3>Estacionamento</h3>
                <div class="border2"></div>
            </div>
        </div>
    </div>

    <div class="rooms">
        <h2>Explore as melhores</h2>
        <h1>Acomodações</h1>
        <div class="border"></div>
        <div class="roomInfo">
            <img src="./assets/images/quarto.jpg" alt="">
            <div class="info">
                <h3>Suíte Standard</h3>
                <p>(Frigobar, TV, Wi-Fi, ar-condicionado)</p>
                <ul>
                    <li>Individual <span>R$ 100,00</span></li>
                    <li>Duplo <span>R$ 130,00</span></li>
                    <li>Triplo <span>R$ 195,00</span></li>
                    <li>Quádruplo <span>R$250,00</span></li>
                </ul>
                <button><a href="<?= $base ?>/reservar?quarto=standard">Reservar</a></button>
            </div>
        </div>
    </div>

    <div class="rooms2">
        <div class="roomInfo2">

            <div class="info2">
                <h3>Suíte Executiva</h3>
                <p>(Frigobar, chuveiro, elétrico, TV, Wi-Fi, ar-
                    condicionado)</p>
                <ul>
                    <li>Individual <span>R$ 120,00</span></li>
                    <li>Duplo <span>R$ 140,00</span></li>
                </ul>
                <button><a class="btnInfo2" href="<?= $base ?>/reservar?quarto=executiva">Reservar</a></button>
            </div>
            <img src="./assets/images/quarto.jpg" alt="">
        </div>
    </div>

    <div class="rooms3">
        <div class="roomInfo3">
            <img src="./assets/images/quarto.jpg" alt="">
            <div class="info">
                <h3>Suíte Premium</h3>
                <p>(Duplex, Smart Tv. chuveiro elétrico, frigobar, Wi-Fi, ar-condicionado)</p>
                <h6>R$ 195,00</h6>
                <button><a href="<?= $base ?>/reservar?quarto=premium">Reservar</a></button>
            </div>
        </div>
    </div>

    <div class="rooms4">
        <div class="roomInfo2">
            <div class="info2">
                <h3>Suíte Premium Família</h3>
                <p>(Duplex, duas suítes, Smart Tv. chuveiro
                elétrico, frigobar, Wi-Fi, ar-condicionado)</p>
                <h6>R$ 250,00</h6>
                <button><a href="<?= $base ?>/reservar?quarto=premiumfamilia">Reservar</a></button>
            </div>
            <img src="./assets/images/quarto.jpg" alt="">
        </div>
    </div>

    <footer>
        <h1>P<span>A</span></h1>
        <div class="socialMedia">
            <h2>Social Media</h2>
            <p>✆ (99)98144-5737</p>
            <img src="" alt=""><p>pousada_alencar</p>
        </div>
        <div class="menu">
            <h2>Menu</h2>
            <div class="menu1">
                <div class="menu2">
                    <p>Home</p>
                    <p>Reservas</p>
                </div>
                <div class="menuBorder"></div>
                <div class="menu3">
                    <p>Quartos</p>
                    <p>Login</p>
                </div>
            </div>
        </div>

        <div class="copyright">Desenvolvido Por Iury e Yohana</div>
    </footer>
</body>

</html>