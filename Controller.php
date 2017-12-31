<?php

	session_start();
	include "All_functions.php";
	include "ReservationAccueil_model.php";
	include "Person.php";
			
	$BackName = array();
	$BackAge = array();
	
	
	// If validate button pressed or not = details
	if(isset($_POST["GoDetails"]))
	{	
		$_SESSION["res"] = handleReservation();
		$res = $_SESSION["res"];
		
		if ( isset($_GET['id'])){
			$listpersonne = reload(2, $_GET['id']);
		}
		
		for ($i = 0 ; $i < $res->get_nbr_pers() ; $i=$i+1)
			{
				if (isset($_GET['id']))
				{
					$spec = explode( '_' ,  $listpersonne[$i]);
					$BackName[$i] = $spec[0];
					$BackAge[$i] = $spec[0];
				}
				
				else 
				{
					$BackName[$i] = '';
					$BackAge[$i] = '';
				}
			}
			include "ReservationDetails_view.php";		
		}
	// If second validate button pressed or not = confirmation 
	elseif(isset($_POST["GoValidation"]))
	{	
		// Gestion des entrée de details_view
		$pers = array();
		$res = handleReservation();
		
		for($i=0 ; $i <$res->get_nbr_pers() ;$i++)
		{	
			$name = htmlspecialchars($_POST['name'][$i]);
			$age = htmlspecialchars($_POST['age'][$i]);
			$pers[$i] = new person($name,$age);
		}
		$_SESSION["pers"] = serialize($pers);
		$price = totalprice();						
		include "Validation_view.php";
		}
	
	// Save the reservation in the database "reservation"
	elseif(isset($_POST['save']))
	{
		SaveInDBB();

		// recuperation of the id
		if ( !isset($_GET['id']))
		{
			$mysqli = new mysqli('localhost', 'root', '', 'reservation_data');

			if ($mysqli->connect_errno){
				echo 'ERROR: Connection mysqli failed'.$mysqli->connect_error;
			}

			$query = 'SELECT * FROM reservation';
			$result = $mysqli->query($query);

			while ($row = $result->fetch_assoc()) {$id = $row['ID'];}
			$num_res = $id;
			include "Final_message.php";
		}
		elseif (isset($_GET['id']))
		{
			header('location: http://localhost/Project/Reservation_router.php?user=admin');
		}
	}
	
	// If button back pushed on reservation
	elseif(isset($_POST["backAccueil"]))
	{
		GoBack(1);
	}
	
		// If button back pushed on validation
		elseif(isset($_POST["backDetails"]))
		{
			GoBack(2);
			$pers = $_SESSION["pers"];
		}
	
		// If cancel button pushed 
		elseif(isset($_POST["cancel"]))
		{
			session_unset();  
			session_destroy();
			$backdest = "";
			$backpers = "";
			$backinsu = "<input type='checkbox' name='insurance' id='case' /><label for='case'></label><br><br>";
			include "ReservationAccueil_view.php"; 

		}
		
		else 
		{
			if (!isset($_GET["action"]))
			{			
				$backdest = "";
				$backpers = "";
				$backinsu = "<input type='checkbox' name='insurance' id='case' /><label for='case'></label><br><br>";
				include "ReservationAccueil_view.php";
			}
			
			else 
			{			
				$_SESSION['res'] = reload(1, $_GET['id']);
				Goback(1);
			}
		}
?>

