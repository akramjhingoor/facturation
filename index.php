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

        if (isset($_GET['nom']) && is_string($_GET['nom']) && !empty($_GET['nom']) && !is_numeric($_GET['nom'])) 
        {
          $nom = htmlentities($_GET['nom']);
          //echo $nom;
          if(isset($_POST['choisir']))
          {
            $choixlist = htmlentities($_POST['choixaffich']);
            header('Location:index.php?nom='.$choixlist);
          }

      ?>
        <form action="index.php?nom=<?php echo $nom; ?>" method ="POST">
          <h2>Afficher les Ligues ou les Prestations : </h2>
          <select name="choixaffich">
            <option value="ligue">Les Ligues</option>
            <option value="prestation">Les Prestations</option>
          </select><br/><br/>
          <input type="submit" value="Choisir" name="choisir" />
        </form>
        <hr/>
        <?php
          if ($nom == 'ligue') 
          {
          ?>
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
        <?php   
          }elseif ($nom == 'prestation') 
          {
        ?>
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
        <?php   
          }//lse header('Location:index.php?nom=fail');
          ?>

  		

  	</section>
    <?php }else header('Location:index.php?nom=ligue'); ?>
    </body>
</html>
