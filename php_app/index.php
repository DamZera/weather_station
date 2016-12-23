<html>
	<head>
		<?php include('config.php'); ?>
		<meta charset="UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<?php
		try
		{
			$bdd = new PDO('mysql:host='.$config['host'].';dbname='.$config['dbname'],$config['user'],$config['pass'],$pdo_options);
		}
		catch (Exception $e)
		{
			die('Erreur : ' . $e->getMessage());
		}

		$timezone  = +1; //(GMT -5:00) EST (U.S. & Canada) 
		
		$date=gmdate("Y-m-j H:i:s", time() + 3600*($timezone+date("I")));
		$heure=gmdate("H:i", time() + 3600*($timezone+date("I")));
		$temp=$_POST['temp'];
		$press=$_POST['press'];
		$humi=$_POST['humi'];
		$volt=$_POST['volt'];
		
		$req = $bdd->prepare('INSERT INTO '.$config['dbtable'].'(temperature,voltage,pression,humidite,date) VALUES(:temperature, :voltage, :pression, :humidite, :date)');
		$req->execute(array(
			'temperature' => $temp,
			'pression' => $press,
			'humidite'=> $humi,
			'voltage'=> $volt,
			'date'=>$date,
		));
		
		
		$reponse = $bdd->query('SELECT * FROM mesure ORDER BY date DESC');
		
		$donnees = $reponse->fetch();
		$heure = gmdate("H:i", time() + 3600*($timezone+date("I")));
	?>
		<div class="row"  style="margin-left: 0px; margin-right: 0px;">
				
				<div class="col-lg-offset-3 col-lg-6" style="align:center">
						<a href="./graph.php">
							<div id="g1" style="align:center">

							</div>	
						</a>
				</div>
				

		</div>	
				<div class="row"  style="margin-left: 0px; margin-right: 0px;">
				<div class="col-lg-offset-3 col-lg-2">
					<div id="gauge">
							
								<div id="g2">

								</div>
						
					</div>

				</div>
				<div class="col-lg-2" >
						<div id="gauge">
							<div id="g3">

							</div>
						</div>
				</div>
				<div class="col-lg-2">
						<div id="gauge">
							<div id="g4">

							</div>
						</div>
				</div>
		</div>
		(Dernière mesure :<?php echo $donnees['date']; ?>)
    <script src="js/raphael-2.1.4.min.js"></script>
    <script src="js/justgage.js"></script>
	
	<script>
      var g1, g2, g3, g4;

      window.onload = function(){
        var g1 = new JustGage({
          id: "g1",
		  	  decimals: true,
          value:<?php echo str_replace(',', '.', $donnees['temperature']); ?>,
          min: -20,
          max: 40,
          title: "<?php echo $heure ?> ",
          label: "Temperature ( °C )"
        });

        var g2 = new JustGage({
          id: "g2",
          value: <?php echo $donnees['humidite']; ?>,
          min: 0,
          max: 100,
	customSectors: [{
        color : "#00ff00",
        lo : 0,
        hi : 50
      },{
        color : "#0040FF",
        lo : 50,
        hi : 100
      }],
          title: "Humidité ( % )",
          label: ""
        });

        var g3 = new JustGage({
          id: "g3",
          value: <?php echo $donnees['pression']; ?> ,
          min: 100000,
          max: 104000,
          title: "Préssion ( hPa )",
          label: ""
        });

        var g4 = new JustGage({
          id: "g4",
		  decimals: true,
          value:<?php echo str_replace(',', '.', $donnees['voltage']); ?> ,
          min: 3.3,
          max: 4.5,
 customSectors: [{
        color : "#000",
        lo : 3.3,
        hi : 4.5

      }],
          title: "Voltage( V )",
          label: ""
        });
      };
    </script>
		
	</body>
</html>