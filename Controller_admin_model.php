<?php
	// Connection to the database
    $mysqli = new mysqli('localhost', 'root', '', 'reservation_data');
    
	if ($mysqli->connect_errno) {
      echo 'ERROR: Connection mysqli failed'.$mysqli->connect_error;
    }
    
	$query = 'SELECT * FROM reservation';
    $result = $mysqli->query($query);
	
	$table = '';
	
	while ($row = $result->fetch_assoc()) {
    
	$table = $table.'<tr><td>'.$row['ID'].'</td>';
	$table = $table.'<td>'.$row['Destination'].'</td>';
	$table = $table.'<td>'.$row['Assurance'].'</td>';
	$table = $table.'<td>'.$row['Voyageur(s)'].'</td>';
	$table = $table.'<td>'.$row['PrixTot'].'</td>';
	$table = $table.'<td><a href="http://localhost/Project/Controller_admin_model.php?action=edit&id='.$row['ID'].'"> <input type="button" value="Editer" class="button_2"/></a></td>';
	$table = $table.'<td><a href="http://localhost/Project/Controller_admin_model.php?action=delete&id='.$row['ID'].'"> <input type="button" value="Supprimer" class="button_3" /></a></td>';

	}
	
	if (!isset($_GET["action"])){ include "Controller_admin_view.php";}

	else 
	{	// if edit button 
		if($_GET["action"] == 'edit')
		{
			header('Location: http://localhost/Project/Controller.php?action=edit&id='.$_GET['id'].'');
		}
		// if delete button
		if($_GET["action"] == 'delete')
		{
			$queryDEL = 'DELETE FROM `reservation` WHERE ID='.$_GET["id"];
			$result = $mysqli->query($queryDEL);
			 
			include "Controller_admin_view.php";
			echo "<br>Les entrées ont été supprimées, veuillez rafraichir la page pour voir les changements<br>";
			echo '<br><a href="http://localhost/Project/Controller_admin_model.php"> <input type="button" class="button3" value="Rafraichir" /></a>';
			
			
		}
	}
	
	$mysqli->close();
	?>
