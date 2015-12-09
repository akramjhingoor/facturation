<?php require ("config.php");?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
    
        <title>M2L - Accueil</title>
    </head>
  
    <body>
    <?php require 'header.php'; ?>
  	<section>
  		
  		<article>
        <h2 style="color: white;">Consulter les factures</h2>

        <p><strong><a href="panelfacture.php">Créer une facture</a></strong></p>
        <?php 
          $sql = $bdd->query("SELECT * FROM facture");

        ?>
        <br/><br/>
  			<table border="4" align="center">
  				<tr>
  					<th>Numéro de la Facture</th>
            <th>Date de la Facture</th>
            <th>Échéance de la Facture</th>
            <th>Ligue concernée</th>
  				</tr>
          <?php 
            while ($infos = $sql->fetch()) 
            {
             $req = $bdd->query('SELECT * FROM ligue WHERE numcompte = '.$infos['compte_ligue']);

          ?>
  				<tr>
            <td><a href="facture.php?num=<?php echo $infos['numfacture']; ?>">FC <?php echo $infos['numfacture']; ?></a></td>
  				  <td><?php
                $date = $infos['datefacture'];
                $dates = explode('-', $infos['datefacture']);
                echo $dates[2].'/'.$dates[1].'/'.$dates[0]; 
                ?>
            </td>
            <td><?php $echeance = $infos['echeance']; $echeances = explode('-', $infos['echeance']);
                echo $echeances[2].'/'.$echeances[1].'/'.$echeances[0] ?></td>
            <td>
              <?php 
                while ($donnees = $req->fetch()) {
                  if ($donnees['numcompte'] == $infos['compte_ligue']) {
                    echo $donnees['intitule'];                    
                  }
                }
              ?>
            </td>
          </tr>

          <?php } ?>
  			</table>
  		</article>

  	</section>

    </body>
</html>
