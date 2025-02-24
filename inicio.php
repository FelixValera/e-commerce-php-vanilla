<!-- PRODUCTOS DESTACADOS -->
<div class="shoes-grid">

    <div class="products">
        <h5 class="latest-product">PRODUCTOS DESTACADOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h5>
        <form action="">

            <input type="text" name="texto">
            <select name="orden" required>
                <option value="false">filtrar</option>
                <option value="asc">Menor valor</option>
                <option value="desc">Mayor valor</option>
            </select>
            <input type="submit" name="buscar" value="Buscar">

        </form>
    </div>

    <?php 
        // revisar no se estan mandando los parametros con los valores correspondientes por GET

        $texto= isset($_GET['texto']) && !empty($_GET['texto']) ? trim($_GET['texto']) : 'false';
            
        $orden= isset($_GET['orden']) && $_GET['orden']!='false' ? $_GET['orden'] : 'false';
        
        $pagina= isset($_GET['p']) ? $_GET['p'] : 1;
        
        $fila=3;

        inicio($texto,$orden,$fila,$pagina);
    ?>

</div>
