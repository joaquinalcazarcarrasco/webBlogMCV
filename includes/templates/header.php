<?php

    //Checking if user is logged
    $isLogged = isLogged();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,400;0,700;1,200;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="preload" href="/css/normalize.css" as="style">
    <link rel="stylesheet" href="/css/normalize.css" type="text/css">
    <link rel="preload" href="/css/styles.css" as="style">
    <link rel="stylesheet" href="/css/styles.css" type="text/css">
    <title>G&S IT Solutions News Blog</title>
</head>
<body>
    <header class="header<?php echo isset($credentials) ? ' credentials' : '' ?>">
        <div class="container">
            <div class="bar">
                <a class="logo" href="/">&nbsp;</a>
                <?php if($isLogged): ?>   
                    <p class="welcome-out">Welcome <strong><?php echo $_SESSION['nickname']; ?></strong></p>
                <?php endif; ?>
                <label class="label-drop-down" for="toggle">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu-2"  viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <line x1="4" y1="6" x2="20" y2="6" />
                        <line x1="4" y1="12" x2="20" y2="12" />
                        <line x1="4" y1="18" x2="20" y2="18" />
                    </svg>
                </label>
                <input class="input-drop-down" type="checkbox" id="toggle" />
                <nav class="menu">
                    <?php if($isLogged): ?>                     
                        <p class="welcome-in">Welcome <strong><?php echo $_SESSION['nickname']; ?></strong></p>
                        <a class="menu__link" href="/">News</a>
                        <a class="menu__link" href="/admin/">Admin</a>
                        <a class="menu__link" href="/logout.php">Logout</a>
                    <?php else: ?>
                        <a class="menu__link" href="/signup.php">Sign up</a>
                        <a class="menu__link" href="/login.php">Login</a>
                    <?php endif; ?>
                </nav>
            </div>