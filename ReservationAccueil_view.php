<?php
	if(isset($res)) 
	{	
		//Loads values from reservation
		$destination = $res->get_destination();
		$pers = $res->get_nbr_pers();
		$insurance = $res->get_insurance();
	}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Reservation</title>
        <meta charset="utf-8" />
		<link rel="stylesheet" href="style.css" />
    </head>
	
    
	<body>
		
		<h1> Réservation</h1>
		<p>Le prix d'une billet est de 15e.
		<p>Le prix d'un billet est de 10e pour les enfants de moins de 12 ans.</p>
		<p>Le prix de l'assurance annulation est de 20e quel que soit le nombre de voyageurs.</p>
		
		<form method="post" >
		<!-- Different part of the form -->
		
		<p>Destination :
		<input type='text' placeholder='Entrez une destination' pattern="[A-Za-z]*" required='true' name='destination' value="<?php echo $backdest ?>" /> 
					
		<p>Nombre de voyageur(s):
		<input type="number" step="1" value="1" min="1" max="15" name='nbr_pers' value="<?php echo $backpers ?>"> 
				
		<p>Assurance annulation
		<?php echo $backinsu ?>
		
		</p>
		<input type='submit' name='GoDetails'  value='Suivant' class="button"/>
		
		</form> <br>		
    </body>
</html>


