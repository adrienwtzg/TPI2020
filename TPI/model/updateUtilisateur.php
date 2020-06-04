<?php
include 'getCritereIdByName.php';
include '../db/databaseConnection.php';

//Vérifie que les entrées sont correctement syntaxé
$dataUtilisateur = filter_input_array(INPUT_POST, [
    "idUtilisateur" => FILTER_SANITIZE_NUMBER_INT,
    "nom" => FILTER_SANITIZE_STRING,
    "prenom" => FILTER_SANITIZE_STRING,
    "email" => FILTER_SANITIZE_STRING,
    "statut" => FILTER_SANITIZE_NUMBER_INT
]);

//Connexion à la base données
$db = connectDB();

$query = $db->prepare("UPDATE `utilisateurs` SET `nom` = ?, `prenom` = ?, `email` = ?, `statut` = ? WHERE `idUtilisateur` = ?");
$query->bindParam(1, $dataUtilisateur["nom"]);
$query->bindParam(2, $dataUtilisateur["prenom"]);
$query->bindParam(3, $dataUtilisateur["email"]);
$query->bindParam(4, $dataUtilisateur["statut"]);
$query->bindParam(5, $dataUtilisateur["idUtilisateur"]);

//Execute la requête
if ($query->execute()) {

  header('Location: ../index.php?page=criteres');
}
else {
  header('Location: ../index.php?page=');
}
 ?>
