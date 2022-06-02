            <div class="formulario">
                <form class="credentials__form" method="POST">
                    <fieldset>
                        <legend>Login</legend>
                        
                        <!-- aviso al usuario de errores -->
                        <?php foreach($errors as $error): ?>
                            <div class="alert red">
                                <p><?php echo $error; ?></p>
                            </div>
                        <?php endforeach; ?>

                        <div class="credentials__fields">
                            <label for="username">Nombre: </label>
                            <input type="text" name="nickname" id="nickname" placeholder="Username" value="<?php echo sanitise($user->nickname) ? sanitise($user->nickname) : ''; ?>">

                            <label for="password">Contraseña: </label>
                            <input type="password" name="password" id="password" placeholder="Password" value="<?php echo sanitise($user->password); ?>">
                        </div>
                        <div class="credentials__buttons">
                            <a class="button green" href="/blog/registro">Nuevo usuario</a>
                            <input class="button" type="submit" value="Login">
                        </div>
                        
                    </fieldset>
                </form>
            </div>
    
        </div>
        </header><!-- .header -->
        
    
</body>
</html>