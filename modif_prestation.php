<?php require ("config.php");?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
    
        <title>M2L - Modifier Prestation</title>
    </head>

    <body>
    <?php require 'header.php'; ?>
  	<section>
  		<?php
      $erreur = "";
      if (isset($_POST['valider'])) {
        if (isset($_POST['libelle']) && !empty($_POST['libelle']) && isset($_POST['prix_unitaire']) &&!empty($_POST['prix_unitaire']) && isset($_POST['reference']) && !empty($_POST['reference'])) {

            $choixligue = htmlentities($_POST['listpres']);
            $reukette = $bdd->prepare('SELECT codepres FROM prestation WHERE libelle = :inprout');
            $reukette->execute(array('inprout' => $choixligue,))or exit(print_r($req->errorInfo()));
            $num = $reukette->fetch();
            $num = $num['codepres'];
            $reference = mb_strtoupper(htmlentities($_POST['reference']));
            $libelle = htmlentities($_POST['libelle']);
            $prix_unitaire = htmlentities($_POST['prix_unitaire']);
            $prix_unitaire = str_replace(',', '.', $prix_unitaire);
            //var_dump($prix_unitaire); exit;
            

            $sql = $bdd->prepare("UPDATE prestation SET reference = :ref, libelle = :libelle, prix_unitaire = :prix_unitaire WHERE codepres = :num ");
            $sql->execute(array(
                'num' => $num,
                'ref' => $reference,
                'libelle' => $libelle,
                'prix_unitaire' => $prix_unitaire,
              ))or die(print_r($sql->errorInfo()));
            $erreur = '<strong>Prestation modifiée !</strong>';
        }else $erreur = '<strong>Veuillez remplir tous les champs !</strong><br/><br/>' ;
        $reukette->closeCursor();
        $sql->closeCursor();
      }
      ?>
  		<article>
       <form action="modif_prestation.php" method="POST"><fieldset>
        <h3>Modifier une prestation</h3><hr />
        <?php echo $erreur;?><br>
        <label>Choix de la prestation concerné : </label>
        <?php
              /* On recup les prestations pour les mettre dans la liste 
              */                      
                                   
            echo '<select name="listpres" style=" width: 180px;">';

            $req = $bdd->query('SELECT * FROM prestation');
                      
            while ($recup = $req->fetch()) 
            {
              echo '<option>'.$recup['libelle']; 
              
            }

              echo "</select><br/><br/>";
    
        ?>
        <label>Référence de la prestation : </label><input type="text" name="reference" maxlength="10" placeholder="REFERENCE" /><br/><br/>
        <label>Libellé de la prestation : </label><input type="text" name="libelle" maxlength="25" placeholder="Libellé de la prestation" /><br/><br/>
        <label>Prix unitaire de la prestation : </label><input type="number" name ="prix_unitaire" placeholder="1.50" step="0.01" /><br/><br/>
        <input type="reset" value="Effacer" />&nbsp;&nbsp;<input type="submit" name="valider" value="Valider" />
        </fieldset>
       </form>
       <hr/>
       <div id ="listprestation">
        <h3>Prestations disponibles : </h3>
        <table border="3" align="center">
        <?php 
          $listpres = $bdd->query("SELECT * FROM prestation");
          while ($donnees = $listpres->fetch()) 
          {
        ?>
        <tr>
          <td><strong><?php echo $donnees['reference']; ?></strong></td>
          <td><?php echo $donnees['libelle']; ?></td>
          <td><?php echo $donnees['prix_unitaire']; ?> € </td>
        </tr>
        <?php } $listpres->closeCursor(); ?>
        </table>
      </div>
  		</article>

  	</section>

    </body>
</html>
