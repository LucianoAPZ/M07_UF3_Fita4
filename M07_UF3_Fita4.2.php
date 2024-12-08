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
 
		$continentes = [];
		if (isset($_POST['continentes'])) {
			$continentes = $_POST['continentes'];
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

	<form action="M07_UF3_Fita4.2.php" method="POST">
		<?php
            $consulta_paises = "SELECT DISTINCT continent FROM country";
            $resultat_paises = mysqli_query($conn, $consulta_paises);
            
            if ($resultat_paises) {
                while ($registre = mysqli_fetch_assoc($resultat_paises)) {
                    echo '<label><input type="checkbox" name="continentes[]" value="' . $registre['continent'] . '"> ' . $registre['continent'] . '</label><br>';
                }
            } else {
                echo "Error al cargar los continentes.";
            }
        ?>
		<br>
		<button type="submit">Filtrar</button>
	</form>

	<?php
 		if (isset($resultat) && $resultat) {
 			$continentes_pais = [];

 			while ($registre = mysqli_fetch_assoc($resultat)) {
 				$continentes_pais[$registre['Continent']][] = $registre['Name'];
 			}

 			foreach ($continentes_pais as $continente => $paises) {
 				echo "<h2>Continente: $continente</h2>";
 				echo "<ul>";
 				foreach ($paises as $pais) {
 					echo "<li>$pais</li>";
 				}
 				echo "</ul>";
 			}
 		} else {
 			echo "No se encontraron resultados para los continentes seleccionados.";
 		}
 	?>

 </body>
</html>