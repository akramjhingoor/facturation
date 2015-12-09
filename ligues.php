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
  		<?php 
      $erreur = "";
      if (isset($_POST['valider'])) {
        if(!empty($_POST['choix'])){
          

          if (!empty($_POST['intitule']) && !empty($_POST['nomtresorier'])) {
            $req = $bdd->query('SELECT COUNT(*) AS nbligues FROM ligue');
              $donnees = $req->fetch();
              $nbligues = $donnees['nbligues'];
              $nbligues = $nbligues + '411007';
              if ($_POST['choix'] == 'non'){
              $adrue = '13 rue Jean Moulin - BP 70001';
              $cp = '54510';
              $ville = 'TOMBLAINE';
              //&& !empty($_POST['adrue']) && !empty($_POST['cp']) && !empty($_POST['ville'])
              //var_dump($nbligues); exit;
            
              $intitule = htmlentities($_POST['intitule']);
              $nomtresorier = htmlentities($_POST['nomtresorier']);
              //$choix = htmlentities($_POST['choix']);
              /*
              $adrue = htmlentities($_POST['adrue']);
              $cp = htmlentities($_POST['cp']);
              $ville = htmlentities($_POST['ville']);
              */
                $sql = $bdd->prepare("INSERT INTO ligue(numcompte, intitule, nomtresorier, adrue, cp, ville )VALUES (:num, :intitule, :nt, :adrue, :cp, :ville)");
                $sql->execute(array(
                  'num' => $nbligues,
                  'intitule' => $intitule,
                  'nt' => $nomtresorier,
                  'adrue' => $adrue,
                  'cp' => $cp,
                  'ville' => $ville,
                ))or die(print_r($sql->errorInfo()));
                $erreur = '<strong>Ligue enregistré dans la base de données</strong><br/><br/>';
            }elseif ($_POST['choix'] == 'oui' ) {
              if(!empty($_POST['adrue']) && !empty($_POST['cp']) && !empty($_POST['ville'])){

              $intitule = htmlentities($_POST['intitule']);
              $nomtresorier = htmlentities($_POST['nomtresorier']);
              //$choix = htmlentities($_POST['choix']);
              $adrue = htmlentities($_POST['adrue']);
              $cp = htmlentities($_POST['cp']);
              $ville = htmlentities($_POST['ville']);
             
              
                $sql = $bdd->prepare("INSERT INTO ligue(numcompte, intitule, nomtresorier, adrue, cp, ville )VALUES (:num, :intitule, :nt, :adrue, :cp, :ville)");
                $sql->execute(array(
                  'num' => $nbligues,
                  'intitule' => $intitule,
                  'nt' => $nomtresorier,
                  'adrue' => $adrue,
                  'cp' => $cp,
                  'ville' => $ville,
                ))or die(print_r($sql->errorInfo()));
                $erreur = '<strong>Ligue enregistré dans la base de données</strong><br/><br/>';
              }else $erreur = '<strong>Si vous voulez recevoir les factures, rentrez votre adresse</strong><br/><br/>';
            }else $erreur = '<strong>Erreur Système !</strong><br/><br/>';
          }else $erreur = '<strong>Veuillez remplir tous les champs</strong><br/><br/>' ;
        
        }else $erreur = '<strong>Préciser si vous voulez recevoir la facture à tel adresse</strong><br/><br/>';
      }
      ?>
  		<article>
       <form action="ligues.php" method="POST"><fieldset>
        <h3>Ajouter une Ligue</h3><hr />
        <?php echo $erreur;?>
        <label>Intitulé : </label><input type="text" name="intitule" maxlength="30" placeholder="Nom de la Ligue..." /><br/><br/>
        <label>Nom du Trésorier : </label><input type="text" name="nomtresorier" maxlength="20" placeholder="Nom du trésorier..." /><br/><br/>
        <label>Recevoir les factures chez soi ? : </label><input type="radio" name ="choix" value ="oui" /> : Oui <input type="radio" name ="choix" value ="non" />: Non<br/><br/>
        <label>Adresse : </label><input type="text" name="adrue" maxlength="50" placeholder="Ex: 5 rue de la Done-ma" /><br/><br/>
        <label>Code postal : </label><input type="text" name="cp" maxlength="5" placeholder="75018" /><br/><br/>
        <label>Ville : </label><input type="text" name="ville" maxlength="20" placeholder="Paris" /><br/><br/>
        <input type="reset" value="Effacer" />&nbsp;&nbsp;<input type="submit" name="valider" value="Valider" />
        </fieldset>
       </form>
      <hr/>
      <div id ="listligue">
        <h3>Liste des Ligues Lorraine</h3>
        <?php 
          $listligue = $bdd->query("SELECT * FROM ligue");
          while ($donnees = $listligue->fetch()) 
          {
        ?>
        <h3 style=" font-color: white;"><?php echo $donnees['intitule'];?></h3>
        <p>
          Finance et facture géré par <?php echo $donnees['nomtresorier'];?><br/>
          <?php echo $donnees['adrue'];?><br/>
          <?php echo $donnees['cp'];?>&nbsp;
          <?php echo $donnees['ville'];?>
        </p>
        <?php } $listligue->closeCursor(); ?>
      </div>
  		</article>

  	</section>

    </body>
</html>
