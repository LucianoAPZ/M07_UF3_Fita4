<html>
 <head>
 	<title>Exemple de lectura de dades a MySQL</title>
 	<style>
 		body{
 		}
 		table,td {
 			border: 1px solid black;
 			border-spacing: 0px;
 		}
 	</style>
 </head>
 <body>
 	<?php
 		$conn = mysqli_connect('localhost','admin','Quiero chocolate 12345');

 		mysqli_select_db($conn, 'mundo');
 
		if (isset($_POST['continent']) && !empty($_POST['continent'])) {
			$continente = mysqli_real_escape_string($conn, $_POST['continent']);
			$consulta = "SELECT * FROM country WHERE Continent = '$continente'";
			$resultat = mysqli_query($conn, $consulta);
		} else {
			echo "Por favor, selecciona un continente.";
		}

		if (!empty($continentes)) {
			$continentes_escaped = array_map(function($continent) use ($conn) {
				return mysqli_real_escape_string($conn, $continent);
			}, $continentes);
			$continentes_str = "'" . implode("','", $continentes_escaped) . "'";
			$consulta = "SELECT Name,Continent FROM country WHERE Continent IN ($continentes_str)";
			$resultat = mysqli_query($conn, $consulta);
		} else {
			echo "Por favor, selecciona al menos un continente.";
		}
		

 	?>
 	<h1>Exemple de lectura de dades a MySQL</h1>

	<form action="M07_UF3_Fita4.1.php" method="POST">
		<select id="continentes" name="continent">
			<?php
                $consulta_paises = "SELECT DISTINCT continent FROM country";
                $resultat_paises = mysqli_query($conn, $consulta_paises);
                
                if ($resultat_paises) {
                    while ($registre = mysqli_fetch_assoc($resultat_paises)) {
                        echo '<option value="' . $registre['continent'] . '">' . $registre['continent'] . '</option>';
                    }
                } else {
                    echo "<option value=''>Error al cargar los continentes</option>";
                }
            ?>
		</select>
		<button type="submit">Filtrar</button>
	</form>

	<ul>
		<?php
			if (isset($resultat) && $resultat) {
				while ($registre = mysqli_fetch_assoc($resultat)) {
					echo "<li>" . $registre["Name"] . "</li>";
				}
			}
		?>
    </ul>


 </body>
</html>