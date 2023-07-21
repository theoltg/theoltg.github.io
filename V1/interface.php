<?php
session_start();

            //Fonction bouton supprimer


if (isset($_POST['Supprimer'])) {
    $_SESSION['listeformule'] = array();
    $_SESSION['nomsFormules'] = array();
}

            // Vérifier si la liste listeformule n'est pas vide

if(!isset($_SESSION['listeformule'])){
    $_SESSION['listeformule'] = array();
    $_SESSION['nomsFormules'] = array();
}

            //Ajouter une formule dans la liste


if (isset($_POST['nomformule'])&& isset($_POST['nombreformule']) && isset($_POST['typeformule'])) {
    $nomFormule = $_POST['nomformule'];
    $quantiteFormule = $_POST['nombreformule'];
    $typeFormule = $_POST['typeformule'];
    $descFormule = $_POST['description'];
    $formule = array(
        'nom' => $nomFormule,
        'quantite' => $quantiteFormule,
        'type' => $typeFormule,
        'ingredients' =>  $descFormule
    );

    $_SESSION['listeformule'][] = $formule;
    $_SESSION['nomsFormules'][] = $nomFormule;
    

}
$listeFormules = $_SESSION['listeformule'];
$nomsFormules=$_SESSION['nomsFormules'];
?>

<script>
    function afficherDes(nomFormule, description) {
        alert("Description de " + nomFormule + " :\n" + description);
    }
</script>


<?php

            //Fonction du bouton Commander

if (isset($_POST['AjouterC'])) {
    
    $quantiteC= $_POST['quantiteCommandee'];
    foreach ($listeFormules as $key => $formule) {
        if ($_POST['nomformule'] == $formule['nom']) {
            $NewQuantite = $formule['quantite'] - $quantiteC;
            $listeFormules[$key]['quantite'] = $NewQuantite;
            if($NewQuantite==0){
                ?>
                <script type="text/javascript">
                    alert("Attention !\nIl ne reste plus de <?php echo $formule['nom']; ?>");
                </script>
                <?php
       
            }
            if($NewQuantite<0){
                $QuantiteTROP=abs($NewQuantite);
                ?>
                <script type="text/javascript">
                    alert("Erreur !\nIl y a trop de formule commandée, il y a : <?php echo $QuantiteTROP." ".$formule['nom']; ?>  en trop ");
                </script>
                <?php
                
            }
            
        }
    }
    $_SESSION['listeformule'] = $listeFormules;
    

    
}

                // Fonction bouton ajout rapide +1
if (isset($_POST['ajout1'])) {
    foreach ($listeFormules as $key => $formule) {
        if ($_POST['nomformule'] == $formule['nom']) {
            $NewQuantite = $formule['quantite'] + 1;
            $listeFormules[$key]['quantite'] = $NewQuantite;
        }
    }
    $_SESSION['listeformule'] = $listeFormules;  
}
                // Fonction bouton ajout rapide -1


if (isset($_POST['soustraction1'])) {
    foreach ($listeFormules as $key => $formule) {
        if ($_POST['nomformule'] == $formule['nom']) {
            $NewQuantite = $formule['quantite'] - 1;
            $listeFormules[$key]['quantite'] = $NewQuantite;
        }
    }
    $_SESSION['listeformule'] = $listeFormules;  
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ancre Marine Gestion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        fieldset {
            border: none;
            padding: 0;
            margin: 0;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #f5f5f5;
        }

        .empty-message {
            text-align: center;
            color: #777;
        }
        fieldset {
        border: 3px solid #ccc;
        padding: 10px;
        margin-bottom: 20px;
        }


    </style>
</head>
<body>
    <h1>Ancre Marine Gestion</h1>

    
    <form method="POST" action="identification.php">
        <input type="submit" name="Retour" value="Retour">
    </form>

    <form method="POST" action="interface.php">
        <fieldset>

            <legend>Ajouter une formule</legend>
            <label for="nomformule">Nom de la Formule:</label>
            <input type="text" name="nomformule" required><br>
            <label for="nombreformule">Quantité préparée:</label>
            <input type="number" min="1" max="30" step="1" name="nombreformule" required><br>
            <label for="typeformule">Type de formule:</label>
            <select name="typeformule" required>
                <option value="">Sélectionnez un type</option>
                <option value="plat">Plat</option>
                <option value="dessert">Dessert</option>
            </select><br>
            <label for="description"> Liste des ingrédients : </label>
            <input type="text" name="description"> <br>
            <input type="submit" name="Ajouter" value="Ajouter">
        </fieldset>   
        
    </form>

    

    <form method="POST" action="interface.php">
        <fieldset>
            <legend>Ajout rapide</legend>
            <select name="nomformule">
                <option value="">Sélectionnez une formule</option>
                <?php
                if (isset($nomsFormules)) {
                    foreach ($nomsFormules as $nom) {
                        echo "<option value='$nom'>$nom</option>";
                    }
                }
                ?>
            </select><br>
            <input type="submit" name="ajout1" value="+1"><br>
            <input type="submit" name="soustraction1" value="-1">
        </fieldset>
    </form>
    
    

    <?php
    usort($listeFormules, function($a, $b) {
        if ($a['type'] === 'plat' && $b['type'] === 'dessert') {
            return -1;
        } elseif ($a['type'] === 'dessert' && $b['type'] === 'plat') {
            return 1;
        }
        return 0;
    });
    ?>

    <?php if (empty($listeFormules)) { ?>
        <p class="empty-message">Aucune formule disponible.</p>
    <?php } else { ?>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Quantité</th>
                    <th>Type</th>
                    <th>Composition<th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listeFormules as $formule) { ?>
                    <tr>
                        <td><?php echo $formule['nom']; ?></td>
                        <td><?php echo $formule['quantite']; ?></td>
                        <td><?php echo $formule['type']; ?></td>
                        <td><button onclick="afficherDes('<?php echo $formule['nom']; ?>', '<?php echo $formule['ingredients']; ?>')">Description</button></td>

                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php }  ?>
    <form method="POST" action="interface.php">
        <input type="submit" name="Supprimer" value="Nouveau service">
    </form>
</body>
</html>
