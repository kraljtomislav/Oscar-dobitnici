<?php
session_start();

if(isset($_POST["submit"])){ //provjeravamo ako je korisnik došao sa signup stranice, a ne preko URL-a
	$username = $_POST["uid"];
	$idKorisnika = $_SESSION["id"];
	
	require_once 'dbh.php';
	require_once 'funkcije.php';
	
	if(emptyInputUid($username) !== false){
		header("location: ../promjenauid.php?error=emptyinput");
		exit();
	}
	if(invalidUid($username) !== false){
		header("Location: ../promjenauid.php?error=invaliduid");
		exit();
	}
	if(newUidExists($conn, $username) !== false){
		header("Location: ../promjenauid.php?error=usernametaken");
		exit();
	}
	
	$query = "UPDATE korisnici SET
				  uidKorisnika='" . $username . "' WHERE id='" . $idKorisnika ."'";
	
	$result = mysqli_query($conn, $query);
	if($result){
		header("Location: ../promjenauid.php?error=none");
	} else {
		echo("UPDATE komanda nije uspjela. Kontaktirajte Web administratora!");
	}
	
}else{
		header("Location: ../promjenauid.php");
		exit();
}
