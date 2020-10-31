<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="apple-touch-icon" sizes="57x57" href="res/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="res/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="res/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="res/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="res/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="res/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="res/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="res/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="res/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="res/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="res/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="res/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="res/favicon/favicon-16x16.png">
	<meta name="msapplication-TileImage" content="res/favicon/ms-icon-144x144.png">
	<link rel="shortcut icon" href="res/favicon/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet"> 

    <title>Assistant - ADD (Derogator)</title>  

</head>
<body>
    <?php
        ini_set("session.auto_start", 0);
        
        require_once 'fpdm-2.9.2/fpdm.php';

        $pdf_source='certif_base.pdf';
        $mode="I";

        function Default_msg(){
            echo('<div class="back"></div>');
            echo('<img class="resumé" src="res/resumé.jpg"></img>');
            echo('
                <center>
                    <div class="title">
                        <h1>Assistant - Attestation de Déplacement Dérogatoire</h1>
                    </div>
                    <div class="main">
                        <hr>
                            <H2>Utilisation de l\'API:</H2>
                        '."http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'?<b>api</b>&<b>name=<a style="color:orange">Prénom NOM</a></b>&<b>b_date=<a style="color:orange">XX/XX/XXXX (DATE NAISSANCE)</a></b>&<b>b_loc=<a style="color:orange">VILLE NAISSANCE</a></b>&<b>loc=<a style="color:orange">ADRESSE HABITATION</a></b>&<b>choice=<a style="color:orange">CHOIX (1 à 9)</a></b>&<b>fait_a=<a style="color:orange">FAIT A (VILLE)</a></b><b><a style="color:blue">&dl (force le téléchargement du PDF)</a></b>
                        <h3 style="color:#ff6c00">AUCUNES INFORMATION N\'EST CONSERVÉ SUR LE SERVEUR !</h3>
                        <h4 style="color:#ff6c00">(code source dispo sur <a href=""> ce github</a>)</h4>
                        <h5>par Gaerisson</h5>
                        <hr>
                    </div>
                </center>
            ');
            exit();
        }

        if(isset($_GET['api'])){
            if(isset($_GET['name']) and isset($_GET['b_date']) and isset($_GET['b_loc']) and isset($_GET['loc']) and isset($_GET['choice']) and isset($_GET['fait_a'])){
                $name=$_GET['name'];
                $b_date=$_GET['b_date'];
                $b_loc=$_GET['b_loc'];

                $loc=$_GET['loc'];

                $choice=$_GET['choice'];
                
                $fait_a=$_GET['fait_a'];
            }else{
                Default_msg();
            }
        }else{
            Default_msg();
        }

        //Tableau contenant les paramètres à passer au PDF
        $fields = array(
            'np_name' => $name,
            'n_date' => $b_date,
            'n_loc' => $b_loc,
            'loc' => $loc,

            's1' =>'',
            's2' =>'',
            's3' =>'',
            's4' =>'',
            's5' =>'',
            's6' =>'',
            's7' =>'',
            's8' =>'',
            's9' =>'',

            'done_at' => $fait_a,
            'cur_date' => date('d/m/Y'),
            'cur_time' => date('H:i'),
        );

        if(isset($fields['s'.$choice])){
            $fields['s'.$choice]='X';
        }else{
            $fields['s1']='X';
        }

        if(isset($_GET['dl'])){$mode="D";}

        //Le paramètre correspond au chemin vers le formulaire PDF
        $pdf = new FPDM($pdf_source);
        $pdf->Load($fields, true); // le second paramètre vaut false si les valeurs sont en ISO-8859-1, vrai si UTF-8
        $pdf->Merge();

        /*
        Le premier paramètre peut prendre 4 valeurs :
        D pour que l’utilisateur soit obligé de télécharger le fichier
        I pour afficher le fichier dans le navigateur
        F pour sauvegarder le document en local
        S pour retourner le document en tant que chaine de caractère.
        Le deuxième paramètre est le nom du fichier
        */
        ob_end_clean();
        $pdf->Output($mode, date('d-m-Y_H\hi')."_attestation_de_déplacement.pdf");

    ?>
</body>