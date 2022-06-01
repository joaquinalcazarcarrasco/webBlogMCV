<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joaquín Alcázar Carrasco - Desarrollador Web y de Software</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans+Condensed:ital,wght@0,400;0,700;1,100;1,400&family=Open+Sans:wght@400;700&family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="preload" href="../css/normalize.css" as="style">
    <link rel="stylesheet" href="../css/normalize.css" type="text/css">
    <link rel="preload" href="../css/cv.css" as="style">
    <link rel="stylesheet" href="../css/cv.css" type="text/css">
</head>
<body>
    <header class="header">
        <div class="contenedor">
            <div class="barra">
                <a class="identidad" href="/">
                    <h1 class="identidad__nombre no-margin">Joaquín Alcázar</h1>
                </a>
                <label class="label-desplegar" for="toggle">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu-2"  viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <line x1="4" y1="6" x2="20" y2="6" />
                        <line x1="4" y1="12" x2="20" y2="12" />
                        <line x1="4" y1="18" x2="20" y2="18" />
                    </svg>
                </label>
                <input class="input-desplegar" type="checkbox" id="toggle" />
                <nav class="menu menu--toogle<?php echo $isAdmin ? ' menu--admin' : '' ?>">
                    <a class="menu__enlace" href="/sobre-mi">Sobre mí</a>
                    <a class="menu__enlace" href="/experiencia">Experiencia</a>
                    <a class="menu__enlace" href="/formacion">Formación</a>
                    <a class="menu__enlace" href="/contacto">Contacto</a>
                    <?php if($isAdmin): ?>
                        <a class="menu__enlace" href="/administrador">Admin</a>
                        <a class="menu__enlace" href="/administrador/salir">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="22" height="22" viewBox="0 0 24 24" stroke-width="2" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                            <path d="M7 12h14l-3 -3m0 6l3 -3" />
                        </svg>
                        </a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>
    <div class="cuerpo">
        <section class="banner">
            <div class="banner__filtro">
                <div class="banner__contenido contenedor">
                    <h2 class="contenido__texto no-margin centrar-texto">Desarollador Web y de Software</h2>
                    <div class="contenido__iconos">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-code" width="88" height="88" viewBox="0 0 24 24" stroke-width="2.5" stroke="#15A0B0" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <polyline points="7 8 3 12 7 16" />
                            <polyline points="17 8 21 12 17 16" />
                            <line x1="14" y1="4" x2="10" y2="20" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-code-plus" width="88" height="88" viewBox="0 0 24 24" stroke-width="2.5" stroke="#15A0B0" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M9 12h6" />
                            <path d="M12 9v6" />
                            <path d="M6 19a2 2 0 0 1 -2 -2v-4l-1 -1l1 -1v-4a2 2 0 0 1 2 -2" />
                            <path d="M18 19a2 2 0 0 0 2 -2v-4l1 -1l-1 -1v-4a2 2 0 0 0 -2 -2" />
                        </svg>
                    </div>
                </div>
            </div>
        </section>



        <?php echo $contenido; ?>




        </div><!-- .cuerpo -->
<footer class="footer">
        <div class="contenedor">
            <div class="barra">
                <a class="identidad" href="/">
                    <h1 class="identidad__nombre no-margin">Joaquín Alcázar</h1>
                </a>
                <nav class="menu">
                    <a class="menu__enlace" href="/sobre-mi">Sobre mí</a>
                    <a class="menu__enlace" href="/experiencia">Experiencia</a>
                    <a class="menu__enlace" href="/formacion">Formación</a>
                    <a class="menu__enlace" href="/contacto">Contacto</a>
                    <?php if($isAdmin): ?>
                        <a class="menu__enlace" href="/administrador">Admin</a>
                        <a class="menu__enlace" href="/administrador/salir">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="22" height="22" viewBox="0 0 24 24" stroke-width="2" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                            <path d="M7 12h14l-3 -3m0 6l3 -3" />
                        </svg>
                        </a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </footer>
    <script src="../js/cv.js"></script>
</body>
</html>