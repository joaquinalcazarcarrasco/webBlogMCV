            <div class="formulario">
                <form class="credentials__form" method="POST">
                    <fieldset>
                        <legend>Registro</legend>

                        <!-- Printing errors to inform the user -->
                        <?php foreach($errors as $error): ?>
                            <div class="alert red">
                                <p><?php echo $error; ?></p>
                            </div>
                        <?php endforeach; ?>

                        <!-- Success message -->
                        <?php 

                            $message = showAlertCV(intval($resultGET), "Cuenta");
                            if($message): 

                        ?>
                            <div class="alert green"> 
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>

                        <div class="credentials__fields">
                            <label for="email">E-mail: </label>
                            <input type="email" name="email" id="email" placeholder="nombre@dominio.es" value="<?php echo sanitise($user->email); ?>">

                            <label for="nickname">Nombre: </label>
                            <input type="text" name="nickname" id="nickname" placeholder="Nombre" value="<?php echo sanitise($user->nickname); ?>">

                            <label for="password">Contraseña: </label>
                            <input type="password" name="password" id="password" placeholder="Contraseña" value="<?php echo sanitise($user->password); ?>">
                        </div>
                        <div class="credentials__buttons">
                            <a class="button green" href="/blog/login">Ya tengo cuenta</a>
                            <input class="button" type="submit" value="Registro">
                        </div>
                        
                    </fieldset>
                </form>
            </div>
    
        </div>
        </header><!-- .header -->
        
    
</body>
</html>