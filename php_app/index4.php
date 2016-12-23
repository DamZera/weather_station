<head>
			<?php include('config.php'); ?>
			<meta charset="UTF-8">
			<script src="js/plotly-latest.min.js"></script>
</head>
<body>
	<a href="index.php">Accueil</a><br/>
	<a href="historique.php">Historique</a>$
	
	<div id="myDiv" style="width: 1600px; height: 400px; margin:auto;"><!-- Plotly chart will be drawn inside this DIV --></div>
	
	<div id="myDiv2" style="width: 1600px; height: 400px;  margin:auto;"><!-- Plotly chart will be drawn inside this DIV --></div>
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
		?>
				  
					<?php 	$x="";
					$y="";
					$z="";
					$g="'";
					$g2="',";
					$c=",";
					for($i=0;$i<48;$i++){
					
					$donnees = $reponse->fetch();
					$x.=$g.$donnees['date'].$g2;
					$y.=str_replace(',', '.', $donnees['temperature']).$c;
					$z.=$donnees['humidite'].$c;	
					 } 

					 ?>
					 
	<script>
	var data = [
	  {
		x: [<?php echo $x ?>],
		y: [<?php echo $y ?>],
		type: 'scatter'
	  }
	];
	var layout = {
	  autosize: false,
	  width: 1600,
	  height: 500,
	  margin: {
		l: 50,
		r: 50,
		b: 100,
		t: 100,
		pad: 4
	  },

	};
		
	Plotly.newPlot('myDiv', data,layout);
	var data = [
	  {
		x: [<?php echo $x ?>],
		y: [<?php echo $z ?>],
		type: 'scatter'
	  }
	];
	var layout = {
	  autosize: false,
	  width: 1600,
	  height: 500,
	  margin: {
		l: 50,
		r: 50,
		b: 100,
		t: 100,
		pad: 4
	  },

	};
		
	Plotly.newPlot('myDiv2', data,layout);
	</script>
</body>