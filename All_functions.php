//All_functions
<?php
	function handleReservation(){	
		if(isset($_POST["insurance"]))
		{
			$insurance = true;
		}
		else
		{
			$insurance = false;
		}
				
		if(isset($_POST["destination"]) && isset($_POST["nbr_pers"]))
			{	
				$destination = htmlspecialchars($_POST["destination"]);
				$traveller = htmlspecialchars($_POST["nbr_pers"]);
				$res = new reservation($destination, $traveller, $insurance);
				$res->save();
				
				return $res;
			}
		elseif(isset($_SESSION["Reservation_model"]))
			{	 
				return unserialize($_SESSION["Reservation_model"]);
			}
	}
		
	function retreivePers()
	{ 
		if(isset($_SESSION["pers"]))
		{	
			return unserialize($_SESSION["pers"]);
		}
		else 
		{
			$pers = array();
			$res = handleReservation();
			for($i=0; $i<$res->get_nbr_pers();$i++)
			{
				$pers[] = new person("",0);
			}
			return $pers;
		}
		
	}
	
	function GoBack($var)
	{
		$res = handleReservation();
		
		if($var == 1)
		{
			$backdest = $res->get_destination();
			$backpers = $res->get_nbr_pers();
		
			if ($res->get_insurance() == 1){$backinsu = "<input type='checkbox' 
			name='insurance' id='case' checked='checked' /><label for='case'></label><br><br>";}
			else {$backinsu = "<input type='checkbox' name='insurance' id='case' />
			<label for='case'></label><br><br>";}

			include "ReservationAccueil_view.php";
		}
		
		if($var == 2)
		{
			$pers = retreivePers();			
			for ($i = 0 ; $i < $res->get_nbr_pers() ; $i=$i+1)
			{		
				$BackName[$i] = $pers[$i]->GetName() ;
				$BackAge[$i] = $pers[$i]->GetAge();
			}
			
			include "ReservationDetails_view.php";
		}
	}
	
	function totalprice()
	{	
		$price = 0;
		$res = handleReservation();
		$pers = retreivePers();
		
		if ($res->get_insurance() == 1){
			$price += 20;
		}

		for($i=0 ; $i < $res->get_nbr_pers() ;$i++)
		{	
			if ($pers[$i]->GetAge() < 12){$price += 10;}			
			else { $price += 15;}
		}
		
		return $price;	

	}	
	
	function reload($object, $ID)
	{
		$mysqli = new mysqli('localhost', 'root', '', 'reservation_data');
    
		if ($mysqli->connect_errno) {
		  echo 'ERROR: Connection to mysqli failed'.$mysqli->connect_error;
		}
		
		$query = 'SELECT * FROM reservation WHERE ID='.$ID.'';
		$result = $mysqli->query($query);
		
		$table = '';
		
			while ($row = $result->fetch_assoc())
			{
				$destination = $row['Destination'];
				if( $row['Assurance'] == 1){$assurance = true;}
				if( $row['Assurance'] == 0){$assurance = false;}
				$listpersonnes = $row['Voyageur(s)'];
			}
			
			$personne = explode( ' ' , $listpersonnes);

			if ($object == 1)
			{
				if (sizeof($personne) > 1 ){$nbr_pers = sizeof($personne)-1;}
				else {$nbr_pers = sizeof($personne);}
			
				$res = new reservation($destination, $nbr_pers, $assurance);
				$res->save();
					
				return $res;
			}
			
			if ($object == 2)
			{		
				return $personne;
			}	
	}
			
	function SaveInDBB()
	{
		$res = handleReservation();
		$pers = retreivePers();
		
		if ( $res->get_insurance() == 1) { $insurance = 1;}
		else { $insurance = 0;}
		
		$traveller = '';
		for($i=0 ; $i < $res->get_nbr_pers();$i++)
		{	
			$name = $pers[$i]->GetName();
			$age = $pers[$i]->GetAge();
			$traveller = $traveller . $name . '-' . $age .' ';
		}
					
		// Connexion to the database
		$bdd = new mysqli("localhost", "root", "","reservation_data") or
		
		die("Could not select database");

		if ($bdd->connect_errno) 
		{
			echo "Echec lors de la connexion à MySQL : (" . $bdd->connect_errno . ")
			" . $bdd->connect_error;
		}

		// Add in database		
		if ( !isset($_GET['action'])) 
		{
			$query = "INSERT INTO `reservation`(`Destination`, `Assurance`, 
			`Voyageur(s)`, `PrixTot`) 
					VALUES ( '".$res->get_destination()."' , ".$insurance." , 
					'".$traveller."' , ".totalprice()." )";
		}
		
		// Modifications
		if ( isset($_GET['action'])) 
		{
			$query = "UPDATE `reservation` SET `Destination`='".$res->get_destination()."',
			`Assurance`=".$insurance.",`Voyageur(s)`='".$traveller."',`PrixTot`=".totalprice()
			."WHERE ID=".$_GET['id'];
			
		}
		$result = $bdd->query($query);
	}
?>