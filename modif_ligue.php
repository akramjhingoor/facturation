<?php require ("config.php");?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
    
        <title>M2L - Modifier Ligue</title>
    </head>
  
    <body>
    <?php require 'header.php'; ?>
  	<section>
  		<?php 
      $erreur = "";
      if (isset($_POST['valider'])) {

        if(!empty($_POST['choix'])){

              if ($_POST['choix'] == 'non'){
              if (!empty($_POST['listligue']) && !empty($_POST['intitule']) && !empty($_POST['nomtresorier']) && !empty($_POST['adrue']) && !empty($_POST['cp']) && !empty($_POST['ville'])) {
                $choixligue = htmlentities($_POST['listligue']);
                $reukette = $bdd->prepare('SELECT numcompte FROM ligue WHERE intitule = :inprout');
                $reukette->execute(array('inprout' => $choixligue,))or exit(print_r($req->errorInfo()));
                $num = $reukette->fetch();
                $num = $num['numcompte'];
                //var_dump($num); exit;
                $intitule = htmlentities($_POST['intitule']);
                $nomtresorier = htmlentities($_POST['nomtresorier']);
                $adrue = htmlentities($_POST['adrue']);
                $cp = htmlentities($_POST['cp']);
                $ville = htmlentities($_POST['ville']);
                
                  $sql = $bdd->prepare("UPDATE ligue SET intitule = :intitule, nomtresorier = :nt, adrue = :adrue, cp = :cp, ville = :ville WHERE numcompte = :num");
                  $sql->execute(array(
                    'num' => $num,
                    'intitule' => $intitule,
                    'nt' => $nomtresorier,
                    'adrue' => $adrue,
                    'cp' => $cp,
                    'ville' => $ville,
                  ))or die(print_r($sql->errorInfo()));
                  $erreur = '<strong>Ligue enregistré dans la base de données</strong><br/><br/>';
              }else $erreur = '<strong>Modifier une ligue sans infos, c\'est comme un phone sans Wi-Fi</strong><br/><br/>';
            }elseif ($_POST['choix'] == 'oui' ) {
              if(!empty($_POST['listligue']) && !empty($_POST['adrue']) && !empty($_POST['cp']) && !empty($_POST['ville'])){

                $choixligue = htmlentities($_POST['listligue']);
                $reukette = $bdd->prepare('SELECT numcompte FROM ligue WHERE intitule = :inprout');
                $reukette->execute(array('inprout' => $choixligue,))or exit(print_r($req->errorInfo()));
                $num = $reukette->fetch();
                $num = $num['numcompte'];
                $adrue = htmlentities($_POST['adrue']);
                $cp = htmlentities($_POST['cp']);
                $ville = htmlentities($_POST['ville']);
             
              
                $sql = $bdd->prepare("UPDATE ligue SET adrue = :adrue, cp = :cp, ville = :ville WHERE numcompte = :num");
                $sql->execute(array(
                  'num' => $num,
                  'adrue' => $adrue,
                  'cp' => $cp,
                  'ville' => $ville,
                ))or die(print_r($sql->errorInfo()));
                $erreur = '<strong>Ligue enregistré dans la base de données</strong><br/><br/>';
              }else $erreur = '<strong>Modifier une adresse sans informations, c\'est comme des frites sans ketchup</strong><br/><br/>';
            }else $erreur = '<strong>Erreur Système !</strong><br/><br/>';
        
      }else $erreur = '<strong>Préciser si vous voulez modifier uniquement l\'adresse ou non</strong><br/><br/>';
    }
      
      ?>
  		<article>
       <form action="modif_ligue.php" method="POST"><fieldset>
        <h3>Modifier une Ligue</h3><hr />
        <?php echo $erreur;?>
        <label>Modifier uniquement l'adresse ? : </label><input type="radio" name ="choix" value ="oui" /> : Oui <input type="radio" name ="choix" value ="non" />: Non<br/><br/>
        <label>Choix de la Ligue concerné : </label>
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
        <label>Intitulé : </label><input type="text" name="intitule" maxlength="30" placeholder="Nom de la Ligue..." /><br/><br/>
        <label>Nom du Trésorier : </label><input type="text" name="nomtresorier" maxlength="20" placeholder="Nom du trésorier..." /><br/><br/>
       
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
