<html>
    <head>
        <title>Mural de Recados em PHP</title>
    </head>
    <body>
        <h1>Mural de Recados</h1>
        <form method="POST" action="cadastra.php">
            Titulo: <input type="text" name="titulo" />
 
 
            E-mail: <input type="text" name="email" />
 
           
            Recado: <textarea name="recado">Deixe seu recado!</textarea>
 
            <input type="submit" />
           
           
            <h2>Recados Postados: </h2>
            <?php
                include("/classes/meulinkdb/meulinkdb.php");    
 GerarConexao();				
                $query = "SELECT * FROM `materia_bi` where `cod_materia_bi`='18525' ";
                $resultado = mysql_query($query) or die(mysql_error());
                while ($row = mysql_fetch_array($resultado)) {
                    echo "<b>".$row["teste"]."</b>";
                    echo "<br/>";
                    echo $row["teste"];
                    echo "<br/>";              
                    
                    echo "<br/><br/>";                              
                }
                mysql_close();
            ?>
        </form>
    </body>
</html>