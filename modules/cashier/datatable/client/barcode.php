<script src="http://html2canvas.hertzen.com/build/html2canvas.js"></script>
<html>
<head>
	<style type="text/css">
		#mydiv{
			width: 600px;
    		height: 400px;
    	
    		 background-image: url("../../../../img/blank_barcode.jpg"); 
		}

		#image{
			margin-left: 27%;
			margin-top: 5%;
		}

	</style>
</head>
<body style="background-color: #000000">
<?php 
	include '../../../../rsc/barcodeGenerator/src/BarcodeGenerator.php';
	include '../../../../rsc/barcodeGenerator/src/BarcodeGeneratorPNG.php';
	include '../../../../library/config.php';
	include '../../../../classes/class.client.php';

	$generatorPNG = new \Picqer\Barcode\BarcodeGeneratorPNG();
    $client = new Client();

    $id = $_GET['id'];
    
    $details = $client->get_client($id);
    foreach($details as $row){
        $barcode = $row['cust_code'];
        $name = $row['cust_firstname'].' '.$row['cust_lastname']; 
    }
	//$custname = $_POST['custname'];


?>
<div id="mydiv">
 <p style="position: absolute; font-size: 2em; top: 180; left: 30; font-family: 'Roboto', 'Helvetica Neue', Arial, sans-serif; color: white;"><?php echo $name;?></p>

<?php echo '<img style="position: absolute; top: 333; left: 30;"src="data:image/png;base64,' . base64_encode($generatorPNG->getBarcode($barcode, $generatorPNG::TYPE_CODE_128)) . '">';
?>
</div> 
 <div id="image">
        <p>Image:</p>
 </div>

 <div id="canvas">
    <p>Canvas:</p>
 </div>
</body>
</html>

<script type="text/javascript">

	html2canvas([document.getElementById('mydiv')], {
    onrendered: function (canvas) {
        document.getElementById('canvas').appendChild(canvas);
        var data = canvas.toDataURL('image/jpeg');
        // AJAX call to send `data` to a PHP file that creates an image from the dataURI string and saves it to a directory on the server

        var image = new Image();
        image.src = data;
        document.getElementById('image').appendChild(image);
        document.getElementById("mydiv").style.display = "none";
         document.getElementById("canvas").style.display = "none";
    }
});
</script>
