<?php

function getDomaines() {
  $db = connectDB();
  $query = $db->prepare("SELECT * FROM domaines");
  if ($query->execute()) {
    $tab = $query->fetchAll(PDO::FETCH_ASSOC);
    return $tab;
  }
  else {
    // code...
  }
}

?>
