<?php $conn = mysqli_connect("localhost", "root", "", "xmldatabase"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
	<title>Breaking News Ticker Examples</title>

	<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>

	<!--Adding demo page css file -->
	<link rel="stylesheet" type="text/css" href="./demo-page-styles.css">

	<!--Adding plugin css file -->
	<link rel="stylesheet" type="text/css" href="./breaking-news-ticker.css">
</head>


<body>
	<section class="demo-section-box" style="background-color: #f2f2f0;">
		<div class="section-container">
			<div class="demo-box">

				
				<div class="breaking-news-ticker" id="newsTicker1">
				  <div class="bn-label">Ticker Label</div>
				  
				  <div class="bn-news">
					<ul>
					<?php 
						$sql = "SELECT * FROM dse";
						$result = mysqli_query($conn,$sql);
						if (mysqli_num_rows($result) > 0) {
							while($row = mysqli_fetch_array($result)) {
								
					?>
						<li>
							<a href="#"><?php echo $row['SecurityCode']; ?>  <?php echo $row['High']; ?></a>
						</li>
					<?php
							}
						}
					?>
					  
					</ul>
				  </div>
				  <div class="bn-controls">
					<button><span class="bn-arrow bn-prev"></span></button>
					<button><span class="bn-action"></span></button>
					<button><span class="bn-arrow bn-next"></span></button>
				  </div>
				</div>
			    <!-- *********************** -->

			</div>
		</div>
	</section>


	<div class="section-container">
		<form action="" method="post" enctype="multipart/form-data">
			<strong>Select File</strong>
			<input type="file" name="xmlfile" required>
			<input type="submit" value="Upload">
		</form>
	</div>


	<?php 

		$rowaffected = 0;

		if (isset($_FILES['xmlfile']) && ($_FILES['xmlfile']['error'] == UPLOAD_ERR_OK)) {
			$xml = simplexml_load_file($_FILES['xmlfile']['tmp_name']);

			foreach ($xml->Ticker as $value) {
				$SecurityCode = $value['SecurityCode'];
				$ISIN = $value['ISIN'];
				$AssetClass = $value['AssetClass'];
				$CompulsorySpot = $value['CompulsorySpot'];
				$TradeDate = $value['TradeDate'];
				$Close = $value['Close'];
				$Open = $value['Open'];
				$High = $value['High'];
				$Low = $value['Low'];
				$Var = $value['Var'];
				$VarPercent = $value['VarPercent'];

				$sql = "INSERT INTO `dse`(`SecurityCode`, `ISIN`, `AssetClass`, `CompulsorySpot`, `TradeDate`, `Close`, `Open`, `High`, `Low`, `Var`, `VarPercent`) VALUES ('".$SecurityCode."','".$ISIN."','".$AssetClass."','".$CompulsorySpot."','".$TradeDate."','".$Close."','".$Open."','".$High."','".$Low."','".$Var."','".$VarPercent."')";
				$result = mysqli_query($conn, $sql);
				if (!empty($result)) {
					$rowaffected++;
				}else{
					$errorMsg = mysqli_error()."\n";
				}
				if ($rowaffected > 0) {
					$msg = $rowaffected. "Recorded Insereted";
				}else{
					$errorMsg = "Failed To Insert";
				}
			}

		}
		

	?>

	<div class="alert-alert-success">
		<?php 
			if (isset($msg)) {
				echo $msg;
			}
		?>
	</div>

	<div class="alert-alert-success">
		<?php 
			if (!empty($errorMsg)) {
				echo $errorMsg;
			}
		?>
	</div>

	<!-- Adding jquery library. minimum version 1.10.0 -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="./breaking-news-ticker.min.js"></script>


	<script type="text/javascript">

		jQuery(document).ready(function($){

			$('#newsTicker1').breakingNews();
		});

	</script>

</body>

</html>






<style>
body {  
    font-family: Arial;
}
.affected-row {
	background: #cae4ca;
	padding: 10px;
	margin-bottom: 20px;
	border: #bdd6bd 1px solid;
	border-radius: 2px;
    color: #6e716e;
}
.error-message {
    background: #eac0c0;
    padding: 10px;
    margin-bottom: 20px;
    border: #dab2b2 1px solid;
    border-radius: 2px;
    color: #5d5b5b;
}
</style>
