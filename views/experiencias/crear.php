
<main id="formularioExperiencias" class="contenedor ptb-4">
    <section class="heading">
        <svg class="heading__icono" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-prompt" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <polyline points="5 7 10 12 5 17" />
            <line x1="13" y1="17" x2="19" y2="17" />
        </svg>
        <h3 class="heading__texto centrar-texto">Crear Experiencia</h3>
    </section>
    
    <div class="volver">
        <a class="boton boton-azul" href="/experiencias/index">Volver</a>
    </div>

    <form method="POST" class="formulario">
        <?php foreach($errores as $error): ?>
            
            <div class="alerta error">
                <?php echo $error ?>   
            </div>
        
        <?php endforeach; ?>
        <fieldset>
            <legend>Información Principal</legend>

            <label for="categoria">Categoría(*)</label>
            <select name="categoria" id="categoria">
                <option value="">--- Selecciona ---</option>
                <?php foreach($categorias as $categoria): ?>
                    <option value="<?php echo $categoria->id; ?>" <?php echo $experiencia->categoria===$categoria->id ? 'selected' : '' ?>><?php echo $categoria->nombre; ?></option>                    
                <?php endforeach; ?>
            </select>

            <label for="empresa">Empresa(*): </label>
            <input type="text" name="empresa" id="empresa" placeholder="Ej: Accenture" <?php echo $experiencia->empresa ? "value='$experiencia->empresa'" : ''; ?>>

            <label for="descripcion">Descripción(*):</label>
            <textarea name="descripcion" id="descripcion"><?php echo $experiencia->descripcion ? $experiencia->descripcion : ''; ?></textarea>

            <label for="fechaInicio">Fecha de Inicio(*): </label>
            <input type="date" name="fechaInicio" id="fechaInicio" 
                <?php
                    echo $experiencia->fechaInicio ? "value='$experiencia->fechaInicio'" : '';
                    echo " max='${hoy}'"; 
                ?>>

            <label for="fechaFinal">Fecha de Fin: </label>
            <input type="date" name="fechaFinal" id="fechaFinal" 
                <?php
                    echo $experiencia->fechaFinal ? "value='$experiencia->fechaFinal'" : '';
                    echo " max='${hoy}'"; 
                ?>>

            <label for="actual">Es mi trabajo actual</label>
            <input type="checkbox" name="actual" id="actual" <?php echo $actual==='on' ? 'checked' : '' ?>>

        </fieldset>

        <fieldset>
            <legend>Información complementaria</legend>

            <label for="clientes">Clientes: </label>
            <input type="text" name="clientes" id="clientes" placeholder="Ej: Iberdrola, El Corte Inglés, etc."<?php echo $experiencia->clientes ? "value='$experiencia->clientes'" : ''; ?>>

            <label for="entornos">Entornos Tecnológicos: </label>
            <input type="text" name="entornos" id="entornos" placeholder="Ej: Android, Angular, etc."<?php echo $experiencia->entornos ? "value='$experiencia->entornos'" : ''; ?>>

        </fieldset>

        <fieldset>
            <legend>Competencias adquiridas</legend>
            <label for="competencias">Puedes escribir una o varias competencias separadas por comas(*):</label>
            <input type="text" name="competencias" id="competencias" placeholder="Ej: Creatividad" <?php echo $competenciasStr ? "value='$competenciasStr'" : ''; ?>>
            
        </fieldset>

        <input class="boton boton-azul" type="submit" value="Crear Experiencia">
    </form>
</main>