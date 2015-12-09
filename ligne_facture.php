<?php require ("config.php");?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
    
        <title>M2L - Gestion des Factures</title>
    </head>
  
    <body>
    <?php require 'header.php'; ?>
  	<section>
  		<?php 
       if (isset($_GET['numero']) && is_numeric($_GET['numero'])) {

          $num = intval($_GET['numero']);
          //echo $num;
      ?>
      <?php
        $erreur = "";
        if (isset($_POST['ajouter'])) 
        {
          
          if (isset($_POST['listprestation']) && !empty($_POST['listprestation']) && isset($_POST['quantite']) && !empty($_POST['quantite']) && is_numeric($_POST['quantite'])){
            
            $listprestation = explode(':', $_POST['listprestation']);
            $verif = $bdd->prepare('SELECT codepres FROM prestation WHERE libelle = :lib');
            $verif->execute(array( 'lib'=>$listprestation[0], ))or exit(print_r($verif->errorInfo()));
            $results = $verif->fetch();
            //var_dump($results); exit; 

            $addmore = $bdd->prepare('SELECT * FROM ligne_facture WHERE numfacture = :numfacture AND code_prestation = :code');
            $addmore->execute(array( 'numfacture'=> $num, 'code'=> $results['codepres'], ));
            if ($qtemore = $addmore->fetch()) {
              
              $quantiteEnplus = $bdd->prepare('UPDATE ligne_facture SET quantite = quantite + :qte WHERE numfacture = :numfacture AND code_prestation = :code ');
              $quantiteEnplus->execute(array(
                'numfacture' => $qtemore['numfacture'],
                'code'=>$qtemore['code_prestation'],
                'qte'=>$_POST['quantite'],
                )) or die(print_r($quantiteEnplus->errorInfo()));
              $erreur = '<strong>Quantité facturée !</strong><br/>';
            }else{ 

            $sql = $bdd->prepare("INSERT INTO ligne_facture(numfacture, code_prestation, quantite) VALUES(:num, :code, :qte) ");
            $sql->execute(array(
              'num' => $num,
              'code'=>$results['codepres'],
              'qte'=>$_POST['quantite'],
              )) or exit (print_r($sql->errorInfo()));
            $erreur = '<strong>Prestation facturée !</strong><br/>';
            $sql->closeCursor();
            }
          }else $erreur = '<strong>Veuillez remplir les champs</strong>';
        }
        
      ?>
  		<article>
       <form action="#" method="POST"><fieldset>
        <h3>Ajouter des prestations à facturer</h3><hr />
        <?php echo $erreur;?><br/>
        <label>Prestations : </label>
        <?php
              /* On recup les ligues pour les mettre dans la liste 
              */                      
                                   
            echo '<select name="listprestation" style=" width: 180px;">';

            $req = $bdd->query('SELECT * FROM prestation');
                      
            while ($recup = $req->fetch()) 
            {
              echo '<option>'.$recup['libelle'].': '.$recup['prix_unitaire']. '€/u'; 
              
            }

              echo "</select><br/><br/>";
    
        ?>
        <label>Quantité : </label><input type="number" name="quantite" min="1" max="999" /><br/><br/>
       
        <input type="reset" value="Effacer" />&nbsp;&nbsp;<input type="submit" name="ajouter" value="Ajouter" />
        <br><br>
        <a href="panelfacture.php">Gestion des Factures</a>
        
        </fieldset>
       </form>
       
  		</article>
      <?php }else header('Location:panelfacture.php'); ?>
  	</section>

    </body>
</html>
