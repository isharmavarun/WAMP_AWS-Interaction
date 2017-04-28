<?php
	require('../config/config.php');

	// Amazon Class to make the AWS request with the necessary parameters
	class AWS{
		
		private $public_key;
		private $secret_key;
		private $associate_tag;
		private $operation;
		private $response_group;
		private $service;
		private $version;
		
		// Constructor
		public function __construct($publicKey, $secretKey, $associateTag, $operation, $responseGroup, $ersion){
			if(!empty($publicKey)){
				$this->public_key = $publicKey;
			}
			if(!empty($secretKey)){
				$this->secret_key = $secretKey;
			}
			if(!empty($associateTag)){
				$this->associate_tag = $associateTag;
			}
			if(!empty($operation)){
				$this->operation = $operation;
			}
			if(!empty($responseGroup)){
				$this->response_group = $responseGroup;
			}
			if(!empty($service)){
				$this->service = $service;
			}
			if(!empty($version)){
				$this->version = $version;
			}
		}

		// Retrieve item details from AWS corresponding to the ASIN ID sent.
		function itemLookup($ASIN){

			$Timestamp = urlencode(gmdate("Y-m-d\TH:i:s\Z", time()));

			// construct request URL for making the AWS request
			$prepend = "GET\nwebservices.amazon.com\n/onca/xml\n";

			$prependUrl = "http://webservices.amazon.com/onca/xml?";
			
			$url =  'AWSAccessKeyId=' . $this->public_key .
					'&AssociateTag=' . $this->associate_tag .
					'&ItemId=' . $ASIN .
					'&Operation=' . $this->operation .
					'&ResponseGroup=' . $this->response_group .
					'&Service=' . $this->service .
					'&Timestamp=' . $Timestamp .
					'&Version=' . $this->version;

			$Signature = urlencode(base64_encode(hash_hmac('SHA256', $prepend . $url, $this->secret_key, True)));

			$requestUrl = $prependUrl . $url . '&Signature=' . $Signature;

			// Send the request to AWS
			$response = file_get_contents($requestUrl);
			$parsedXml = simplexml_load_string($response);

			// Process the response
			$dom = new DOMDocument;
			$dom -> loadXml($response);

			// Get the count of items retrieved from the request to check if lookup was successful
			$retrievedItems = $dom -> getElementsByTagName('Item')->length;

			if($retrievedItems!=0){

				// Get all the parameters from XML response
				$asin = $parsedXml -> Items -> Item -> ASIN;
				$title = $parsedXml -> Items -> Item -> ItemAttributes -> Title;
				$mpn = $parsedXml -> Items -> Item -> ItemAttributes -> MPN;
				$price = $parsedXml -> Items -> Item -> ItemAttributes -> ListPrice -> FormattedPrice;

				// Construct HTML response and send back to the static HTMl page to load the response
				return '<td id="fetched_asin">'.
						$asin.'</td><td id="fetched_title">'.
						$title.'</td><td id="fetched_mpn">'.
						$mpn.'</td><td id="fetched_price">'.
						$price.'</td>';
			}else {
				return '';
			}
		}
	}

	// Insert looked up Item in the local database
	if(isset($_POST['ASIN'])){

		// Check if entry is present in the local Database
		$asin = trim($_POST['ASIN']);

		$query = "SELECT `ASIN` FROM `QUANTUM_TABLE` WHERE ASIN='".$asin."'";

		$result = mysqli_query($dbc, $query);

		if(mysqli_num_rows($result) == 0) {

			$title = trim($_POST['TITLE']);
			$mpn = trim($_POST['MPN']);
			$price = trim($_POST['PRICE']);

			// Insert entry into local database
			$query = "INSERT INTO QUANTUM_TABLE (ASIN, Title, MPN, Price, DATE_ADDED)
						VALUES(?, ?, ?, ?, NOW())";

			$stmt = mysqli_prepare($dbc, $query);
			mysqli_stmt_bind_param($stmt, "ssss", $asin, $title, $mpn, $price);
			mysqli_stmt_execute($stmt);
			$affected_rows = mysqli_stmt_affected_rows($stmt);

			if($affected_rows == 1) {
				echo 'Success';
			} else {
				echo 'Failed';
			}
		} else {
			echo 'Failed - Already exists';
		}
		exit();
		
	}

	// Retrieve Item from AWS
	if(isset($_GET['ASIN'])) {

		$asin = $_GET['ASIN'];

		// Create new AWS instance with all the necessary parameters and lookup item
		$aws = new AWS(AWSAccessKeyId, SecretKey, AssociateTag, "ItemLookup", "ItemAttributes", Service, Version);
		$htmlResponse = $aws -> itemLookup($asin);

		echo $htmlResponse;
		exit();

	} else {					// Populate column 1 from the local database

		// Select all entries from the MYSQL database
		$query = "SELECT ASIN, TITLE, MPN, PRICE from QUANTUM_TABLE;";

		$response = @mysqli_query($dbc, $query);

		if($response) {

			while($row = mysqli_fetch_array($response)) {

				echo '<tr><td>'.
				$row['ASIN'].'</td><td>'.
				$row['TITLE'].'</td><td>'.
				$row['MPN'].'</td><td>'.
				$row['PRICE'].'</td></tr>';
			}
		} else {
			echo "Failed.";
			echo mysqli_error($dbc);
		}

		exit();
	}

?>