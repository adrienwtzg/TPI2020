<?php

function getAllCriteresByCategories($idCategorie) {
  $db = connectDB();
  $query = $db->prepare("SELECT * FROM criteres WHERE idCategorie = ?");
  $query->bindParam(1, $idCategorie);
  if ($query->execute()) {
    $tab = $query->fetchAll(PDO::FETCH_ASSOC);
    return $tab;
  }
  else {
    // code...
  }
}

?>
