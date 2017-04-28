<?php
	// Opens a connection to the database
	// Since it is a php file it won't open in a browser 
	// It should be saved outside of the main web documents folder
	// and imported when needed

	// Defined as constants so that they can't be changed
	DEFINE ('DB_USER', 'root');
	DEFINE ('DB_PASSWORD', '');
	DEFINE ('DB_HOST', 'localhost');
	DEFINE ('DB_NAME', 'quantumDB');

	// $dbc will contain a resource link to the database
	// @ keeps the error from showing in the browser

	$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
	OR die('Could not connect to MySQL: ' .
	mysqli_connect_error());

	// Define all the necessary AWS parameters
	DEFINE ("AWSAccessKeyId", "AKIAIOWFZ4KTTJAKNLFQ");
	DEFINE ("AssociateTag", "q0d9b-20");
	DEFINE ("SecretKey", "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");
	DEFINE ("Service", "AWSECommerceService");
	DEFINE ("Version", "2013-08-01");
?>