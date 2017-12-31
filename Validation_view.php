<!DOCTYPE html>
<html>
    <head>
        <title>Confirmation</title>
        <meta charset="utf-8" />
		<link rel="stylesheet" href="style.css" />
    </head>
	
    
	<body>
		
		<h1>Confirmation</h1>
		<p>Voici le récapitulatif de votre réservation</p>
		
		<?php 							
			echo sprintf("<p>Destination : %s</p>", $res->get_destination());
			 			
			if ($res->get_insurance() == 1 )
			{
				echo "<p>Assurance annulation : OUI</p>";
			}
			
			else 
			{
				echo "<p>Assurance annulation : NON </p> ";
			}
							
			for($i=0 ; $i < $res->get_nbr_pers();$i++)
			{	
				$n = $i +1;
				$format = '<p>Participant %d : %s  %d ans </p>';
				echo sprintf($format, $n, $pers[$i]->GetName(),  $pers[$i]->GetAge());
			}
			
			echo sprintf("Prix total : %d", $price);
		?>
		
		<form method="post" >				
				<input type='submit' name='backDetails' value='Retour' class="button"/> 
				<input type='submit' name='cancel' value='Annuler' class="button"/> 
				<input type='submit' name='save' value='Sauvegarder' class="button"/> 
		</form> <br>
		
    </body>
</html>