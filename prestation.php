<?php require ("config.php");?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
    
        <title>M2L - Prestation</title>
    </head>

    <body>
    <?php require 'header.php'; ?>
  	<section>
  		<?php
      $erreur = "";
      if (isset($_POST['valider'])) {
        if (isset($_POST['libelle']) && !empty($_POST['libelle']) && isset($_POST['prix_unitaire']) &&!empty($_POST['prix_unitaire']) && isset($_POST['reference']) && !empty($_POST['reference'])) {

            $req = $bdd->query('SELECT COUNT(*) AS prestations FROM prestation');
            $donnees = $req->fetch();
            $prestations = $donnees['prestations'];
            $prestations++;
            //$codepres = htmlentities($_POST['codepres']);
            $libelle = htmlentities($_POST['libelle']);
            $prix_unitaire = htmlentities($_POST['prix_unitaire']);
            $prix_unitaire = str_replace(',', '.', $prix_unitaire);
            $reference = mb_strtoupper(htmlentities($_POST['reference']));
            //var_dump($prix_unitaire); exit;
            

            $sql = $bdd->prepare("INSERT INTO prestation(codepres, reference, libelle, prix_unitaire) VALUES (:codepres, :ref , :libelle, :prix_unitaire)");
            $sql->execute(array(
                'codepres' => $prestations,
                'ref' => $reference,
                'libelle' => $libelle,
                'prix_unitaire' => $prix_unitaire,
              ))or die(print_r($sql->errorInfo()));
            $erreur = '<strong>Prestation enregistrée !</strong>';
        }else $erreur = '<strong>Veuillez remplir tous les champs !</strong><br/><br/>' ;
      }
      ?>
  		<article>
       <form action="prestation.php" method="POST"><fieldset>
        <h3>Ajouter une prestation</h3><hr />
        <?php echo $erreur;?><br/>
        <label>Référence de la nouvelle prestation : </label><input type="text" name="reference" maxlength="10" placeholder="REFERENCE" /><br/><br/>
        <label>Libellé de la nouvelle prestation : </label><input type="text" name="libelle" maxlength="25" placeholder="Libellé de la prestation" /><br/><br/>
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
