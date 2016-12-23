<head>
	<?php include('config.php'); ?>
	<meta charset="UTF-8">
</head>
<body>
date,temperature,humidite,pression,voltage<br/>
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
	echo $donnees['date']; ?>,<?php echo $donnees['temperature']; ?>,<?php echo $donnees['humidite']; ?>,<?php echo $donnees['pression']; ?>,<?php echo $donnees['voltage']; ?>
	<br/>
	<?php
	}
	
?>

</body>