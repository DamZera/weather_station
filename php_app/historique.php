<head>
	<?php include('config.php'); ?>
	<meta charset="UTF-8">
</head>
<body>
	<a href="index.php">Accueil</a><br/>
	<a href="graph.php">Graphique</a><br/>
<?php
	try
	{
		$bdd = new PDO('mysql:host='.$config['host'].';dbname='.$config['dbname'],$config['user'],$config['pass'],$pdo_options);
	}
	catch (Exception $e)
	{
        die('Erreur : ' . $e->getMessage());
	}
	
	$reponse = $bdd->query('SELECT * FROM mesure ORDER BY date DESC');
	
	while ($donnees = $reponse->fetch())
	{
	echo $donnees['date']; ?>  :  Temperature : <?php echo $donnees['temperature']; ?> °C   |   Humidité : <?php echo $donnees['humidite']; ?> %    |   Préssion : <?php echo $donnees['pression']; ?> hPa    |   Voltage(TEST): <?php echo $donnees['voltage']; ?> V
	<br/>
	<?php
	}
	
?>

</body>