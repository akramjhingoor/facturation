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
        $erreur = "";
        if (isset($_POST['creer'])) 
        {
          
          if (isset($_POST['listligue']) && !empty($_POST['listligue']) && isset($_POST['datefacture']) && !empty($_POST['datefacture'])){
            $req = $bdd->query('SELECT COUNT(numfacture) AS nbfac FROM facture');
            $data = $req->fetch();
            $count = $data['nbfac'];
            $verif = $bdd->prepare('SELECT numcompte FROM ligue WHERE intitule = :ligue');
            $verif->execute(array('ligue'=>$_POST['listligue']))or die(print_r($verif->errorInfo()));
            $response = $verif->fetch();
            $num = 5180 + $count;
          
            $datedeb = $_POST['datefacture'];
            //$datedeb = '2008-10-25';
            list($annee, $mois, $jour) = explode("-", $datedeb);
            $adddate = 15;
            $datecheance = date('Y-m-d', mktime(0,0,0, $mois, $jour+$adddate, $annee));

            $sql = $bdd->prepare("INSERT INTO facture(numfacture, datefacture, echeance, compte_ligue) VALUES(:num, :datefacture, :echeance, :compte_ligue) ");
            $sql->execute(array(
              'num' => $num,
              'datefacture'=>$datedeb,
              'echeance'=>$datecheance,
              'compte_ligue'=>$response['numcompte'],
              )) or exit (print_r($sql->errorInfo()));
            $erreur = '<strong>Facture crée à ce jour</strong>';
            $sql->closeCursor();
          }else $erreur = '<strong>Veuillez remplir les champs</strong>';
        }
        
      ?>
  		<article>
       <form action="#" method="POST"><fieldset>
        <h3>Créer une facture</h3><hr />
        <?php echo $erreur;?><br/>
        <label>Ligues sujet à la facture : </label>
        <?php
              /* On recup les ligues pour les mettre dans la liste 
              */                      
                                   
            echo '<select name="listligue" style=" width: 180px;">';

            $req = $bdd->query('SELECT * FROM ligue');
                      
            while ($recup = $req->fetch()) 
            {
              echo '<option>'.$recup['intitule']; 
              
            }

              echo "</select><br/><br/>";
    
        ?>
        <label>Date de la facture : </label><input type="date" name="datefacture" placeholder="JJ/MM/AAAA" /><br/><br/>
       
        <input type="reset" value="Effacer" />&nbsp;&nbsp;<input type="submit" name="creer" value="Créer" />
        </fieldset>
       </form>
       
      <div id ="listligue">
        <h3>Liste des Factures</h3>
        <?php 
          $listfacture = $bdd->query("SELECT * FROM facture");
          //$listligue = $bdd->query("SELECT * FROM ligue");
          while ($donnees = $listfacture->fetch()) 
          {
        ?>
        <p>
          <?php 
            /*while ($infos = $listligue->fetch()) {
              if ($infos['numcompte'] == $donnees['compte_ligue']) {
                echo $infos['intitule'];
              }
            }*/
          ?>
          Numéro : <?php echo $donnees['numfacture'];?><br/>
          Facture en date du <a href="ligne_facture.php?numero=<?php echo $donnees['numfacture'];?>"><?php
                $date = $donnees['datefacture'];
                $dates = explode('-', $donnees['datefacture']);
                echo $dates[2].'/'.$dates[1].'/'.$dates[0]; 
                ?></a>
        </p>
        <?php } $listfacture->closeCursor(); ?>
      </div>
  		</article>

  	</section>

    </body>
</html>
