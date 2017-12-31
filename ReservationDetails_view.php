<!DOCTYPE html>
<html>
    <head>
        <title>Détails de la réservation</title>
        <meta charset="utf-8" />
		<link rel="stylesheet" href="style.css" />
		
    </head>
    <body>
	
		<h1>Détails de la réservation</h1>
		
        <form method="post">
			<?php
				//Name and age for all person
				for ($i = 0 ; $i < $res->get_nbr_pers() ; $i=$i+1)
				{
					$p = $i+1;
					$name = $BackName[$i];
					$age = $BackAge[$i];
					
					echo "Passager ".$p."";
					echo "<p>Nom <input type='text' placeholder='Entrez un nom' pattern='[A-Za-z]*' required='true' name='name[".$i."]' value='".$name."'/>";
					echo "<p>Age <input type='number' required='true' value='18' step='1' min='1' max='120' name='age[".$i."]' value='".$age."'/><br>";
				}
			?>
			<br>
			<input name="GoValidation" type="submit" value="Suivant" class="button"/>
			<input name="backAccueil" type="submit" value="Retour" class="button"/> 
			<input name="cancel" type="submit" value="Annuler" class="button"/>
			
        </form>
	</body>
</html>

