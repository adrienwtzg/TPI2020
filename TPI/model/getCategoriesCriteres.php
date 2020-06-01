<?php

function getCategoriesCriteres() {
  $db = connectDB();
  $query = $db->prepare("SELECT * FROM categories ");
  if ($query->execute()) {
    $tab = $query->fetchAll(PDO::FETCH_ASSOC);
    return $tab;
  }
  else {
    // code...
  }
}

?>
