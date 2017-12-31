<?php
if($_GET["user"] == "client" )
{
	include "Controller.php";
}
elseif ( $_GET["user"] == "admin" )
{
	if ( !isset($_POST["admin_next"])) {include "Controller_admin_pass.php"; }

	if ( isset($_POST["admin_next"]))
	{

		if (htmlspecialchars($_POST["pseudo"]) == "admin" && htmlspecialchars($_POST["mdp"]) == "admin")
		{
			include "Controller_admin_model.php";
		}
		else {
			echo "Mauvaise identification <br>";
			echo '<a href="http://localhost/Project/Reservation_router.php?user=admin"> <input type="button" value="Réessayer" /></a>';
		}
	}
}
?> 