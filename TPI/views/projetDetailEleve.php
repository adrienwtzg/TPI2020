<?php
include 'model/getProjetById.php';
include 'model/getElevesProjet.php';
include 'model/getEleveToAdd.php';
include 'model/checkProjetExist.php';
include 'model/getEleveByUtilisateur.php';
include 'model/getCategoriesCriteres.php';
include 'model/getCriteresByCategories.php';
include 'model/getCriteresToAdd.php';
include 'model/estEvalue.php';
include 'model/getNote.php';
include 'model/getEvaluations.php';
include 'model/getInfoEleve.php';
require('fpdf182/fpdf.php');

//Récupère l'id du projet détaillé
if (isset($_SESSION['idProjet']))
{
  $idProjet = $_SESSION['idProjet'];
  //Vérifie si le projet existe
  if (!checkProjetExist($idProjet)) {
    //envoie sur la page des projets
    header('Location: index.php?page=projets');
  }
}

$projet = getProjetById($idProjet);

$idEleve = getEleveByUtilisateur($_SESSION["id"])[0]["idEleve"];
$eleve = getInfoEleve($idEleve);

if (isset($_POST["download"])) {
  $pdf = new FPDF();
  $pdf->SetAutoPageBreak( true);
  $pdf->AddPage();
  $page_height = 286.93;
  $pdf->AddFont('Helvetica','');
  $pdf->SetFont('Helvetica', '',18);
  $pdf->Cell(180, 10, utf8_decode($projet["titre"]). " - ".$eleve["prenom"]." ".$eleve["nom"]." - ".date("d/m/Y"), '', 1, '');
  $pointsObtenus += $evaluation["pointsObtenus"];
  $pointsTotal += $evaluation["pointsMax"];

  foreach (getCategoriesCriteres() as $categorie) {
    if (!empty(getCriteresByCategories($categorie["idCategorie"], $idProjet))) {
        $pdf->SetFont('Helvetica','B',18);
        $pdf->Cell(180, 10, utf8_decode($categorie["categorie"]), '', 1, '');
        $pdf->Cell(180, 4, "", '', 1);
      foreach (getEvaluations($idEleve, $idProjet, $categorie["idCategorie"]) as $evaluation) {
        if ($pdf->GetY() > $page_height - 80) {
          $pdf->AddPage();
        }
        $pdf->SetFont('Helvetica','B',16);
        $pdf->Cell(180, 10, utf8_decode($evaluation["critere"]), 'LTRB', 1, 'C');
        $pdf->SetFont('Helvetica','',12);
        if ($pdf->GetStringWidth($evaluation["definition"]) >= 180) {
          $pdf->MultiCell(180, 10, utf8_decode($evaluation["definition"]), 'LR', 1);
        }
        else {
          $pdf->Cell(180, 10, utf8_decode($evaluation["definition"]), 'LR', 1);
        }
        if ($pdf->GetStringWidth($evaluation["observation"]) >= 180) {
          $pdf->MultiCell(180, 10, "Commentaire: ".utf8_decode($evaluation["observation"]), 'LTR', 1);
        }
        else {
          $pdf->Cell(180, 10, "Commentaire: ".utf8_decode($evaluation["observation"]), 'LTR', 1);
        }
        $pdf->SetFont('Helvetica','B',16);
        $pointsObtenus += $evaluation["pointsObtenus"];
        $pointsTotal += $evaluation["pointsMax"];
        $pdf->Cell(180, 13, "Points: ".$evaluation["pointsObtenus"]." / ".$evaluation["pointsMax"], 'LTBR', 1, 'R');
        $pdf->Cell(180, 10, "", '', 1);
      }
    }
    else {
    }
  }
  $pdf->Cell(180, 10, "", '', 1);
  $pdf->SetFont('Helvetica','B',18);
  $pdf->Cell(60, 10, "Total des points ", '', 0, '');
  $pdf->Cell(20, 10, $pointsObtenus." / ".$pointsTotal, 'LTBR', 1, '');
  $pdf->Cell(180, 10, "", '', 1);
  $pdf->Cell(60, 10, "Note ", '', 0, '');
  $pdf->Cell(20, 10, getNote($idEleve, $idProjet), 'LTBR', 1, '');
  ob_clean();
   $pdf->Output('D', $eleve["nom"].'_'.$eleve["prenom"].'_'.$projet["titre"].'_Evaluation.pdf');
}

echo "<div class=\"container\" style=\"padding-top: 20px;\">";
echo "  <div class=\"card\">";
echo "   <div class=\"card-body\">";
echo "     <h5 class=\"card-title\" style=\"display: inline-block;\">".$projet["titre"]."</h5>";
echo "     <button type=\"button\" title=\"Domaine du projet\" style=\"float: right;\" class=\"btn btn-outline-primary\" disabled>Web</button>";
echo "     <p class=\"card-text\"><small class=\"text-muted\">".$projet["client"]."</small></p>";
echo "     <p class=\"card-text\">".$projet["description"]."</p>";
echo "     <p class=\"card-text\"><em>Débute le ".$projet["dateDebut"]." et dure ".$projet["dureePrevue"]." semestre(s)</em></p>";
echo "   </div>";
 ?>

</div><br><h3 style="text-align: center;">Gestion du projet</h3>
 <div class="card">
  <div class="card-body">
    <h5 class="card-title" style="display: inline-block;">Elèves</h5><br>
    <?php
    echo "     <div class=\"list-group\">";
    foreach (getElevesProjet($projet["idProjet"]) as $eleve) {
      if ($eleve["idUtilisateur"] == $_SESSION["id"]) {
        $idEleve = $eleve["idEleve"];
        echo "<a style=\"padding-top: 20px; padding-bottom: 20px;\" class=\"list-group-item list-group-item-action\"><b>(moi)</b> ".$eleve["prenom"]."  ".$eleve["nom"]."</a>";
      }
      else {
        echo "<a style=\"padding-top: 20px; padding-bottom: 20px;\" class=\"list-group-item list-group-item-action\">".$eleve["prenom"]."  ".$eleve["nom"]."</a>";
      }

    }
    echo "     </div>";
    echo "   </div></div>";
    ?>
<br>
<div class="card">
 <div class="card-body">
   <h4 class="card-title" style="display: inline-block;">Votre évaluation</h4><br><br>
     <div class="container">
       <?php
       if (!estEvalue($idEleve, $idProjet)) {
         echo "<div class=\"alert alert-secondary\" role=\"alert\">Votre enseignant ne vous a pas encore évalué. Lorsqu'il le fera, votre évaluation apparaîtra ici.</div>";
       }
       else {
            $pointsObtenus = 0;
          $pointsTotal = 0;
           foreach (getCategoriesCriteres() as $categorie) {
             if (!empty(getCriteresByCategories($categorie["idCategorie"], $idProjet))) {
               echo "<h5>".$categorie["categorie"]."</h5>";
               echo "<ul class=\"list-group\">";
               foreach (getEvaluations($idEleve, $idProjet, $categorie["idCategorie"]) as $evaluation) {
                 $pointsObtenus += $evaluation["pointsObtenus"];
                 $pointsTotal += $evaluation["pointsMax"];

                 echo "<input type=\"hidden\" name=\"idCriteres[]\" value=\"".$evaluation["idCritere"]."\">";
                 echo "<li class=\"list-group-item\"><p style=\"float: right;\">&nbsp;&nbsp;<b>".$evaluation["pointsObtenus"]."</b> / ".$evaluation["pointsMax"]." pt.</p><h6>".$evaluation["critere"]."</h6> <p>".$evaluation["definition"]."<p>";
                 echo "<label><em>Commentaire de l'enseignant</em></label>";
                 echo "<textarea rows=\"3\" name=\"commentaires[]\" class=\"form-control\" readonly>".$evaluation["observation"]."</textarea>";
               }
               echo "</ul><br><br>";
             }
             else {
             }
           }
         echo '<h6>Total des points <b style="border: 1px solid black; padding: 5px;">'. $pointsObtenus." / ".$pointsTotal.'</b></h6>';
         echo '<h4>Note <b style="border: 1px solid black; padding-right: 10px;padding-left: 10px;">'.getNote($idEleve, $idProjet).'</b></h4>';
         echo '<form class="" action="#" method="post">';
           echo '<br><button type="submit" name="download" class="btn btn-primary">Télécharger mon évaluation</button>';
         echo '</form>';
       }
     ?>
   </div>
 </div>
</div>
