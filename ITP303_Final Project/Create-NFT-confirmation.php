<?php

// var_dump($_POST);

if ( !isset($_POST['title']) || empty($_POST['title']) 
	|| !isset($_POST['contract_address']) || empty($_POST['contract_address'])
	|| !isset($_POST['data_url']) || empty($_POST['data_url'])
	|| !isset($_POST['token_type']) || empty($_POST['token_type'])
	|| !isset($_POST['nft_description']) || empty($_POST['nft_description']) 
	|| !isset($_POST['trait_1']) || empty($_POST['trait_1']) 
	|| !isset($_POST['trait_2']) || empty($_POST['trait_2']) 
	|| !isset($_POST['trait_3']) || empty($_POST['trait_3']) 
	|| !isset($_POST['value_1']) || empty($_POST['value_1']) 
	|| !isset($_POST['value_2']) || empty($_POST['value_2']) 
	|| !isset($_POST['value_3']) || empty($_POST['value_3']) 
	) {

	// Missing required fields.
	$error = "Please fill out all required fields.";

} else {
	// All required fields provided.
	require "config/config.php";

	// DB Connection
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}

	$mysqli->set_charset('utf8');

	// Need 3 SQL INSERT statement for the 3 tables 

	// INSERT into NFT_metadata table
	$statement = $mysqli->prepare("INSERT INTO NFT_metadata (title, data_url, tokenType, description) VALUES(?, ?, ?, ?)");
	
	$statement->bind_param("ssss", $_POST['title'], $_POST['data_url'], $_POST['token_type'], $_POST['nft_description']);
	
	$executed = $statement->execute();
	
	if(!$executed){
		echo $mysqli->error;
	}
	
	$statement->close();

	// INSERT into NFT_attributes table
	$statement = $mysqli->prepare("INSERT INTO NFT_attributes (trait1, value1, trait2, value2, trait3, value3) VALUES(?, ?, ?, ?, ?, ?)");
	
	$statement->bind_param("ssssss", $_POST['trait_1'], $_POST['value_1'], $_POST['trait_2'], $_POST['value_2'], $_POST['trait_3'], $_POST['value_3']);
	
	$executed = $statement->execute();
	
	if(!$executed){
		echo $mysqli->error;
	}
	
	$statement->close();




	// Get metadata ID
	$sql_metadata_id = "SELECT id FROM NFT_metadata ORDER BY id DESC LIMIT 1";
	$sql_metadata_id = $sql_metadata_id . ";";
	
	$select_results_metadata = $mysqli->query($sql_metadata_id);

	if ( $select_results_metadata == false ) {
		echo $mysqli->error;
		exit();
	}

	$id_metadata = $select_results_metadata->fetch_assoc();

	// Get metadata ID
	$sql_attributes_id = "SELECT id FROM NFT_attributes ORDER BY id DESC LIMIT 1";
	$sql_attributes_id = $sql_attributes_id . ";";
	
	$select_results_attributes = $mysqli->query($sql_attributes_id);

	if ( $select_results_attributes == false ) {
		echo $mysqli->error;
		exit();
	}

	$id_attributes = $select_results_attributes->fetch_assoc();


	// var_dump($id_metadata["id"]);
	// var_dump($id_attributes["id"]);


	// INSERT into NFT table
	$statement = $mysqli->prepare("INSERT INTO NFT (contract_address, NFT_metadata_id, NFT_attributes_id) VALUES(?, ?, ?)");
	
	$statement->bind_param("sii", $_POST["contract_address"], $id_metadata["id"], $id_attributes["id"]);
	
	$executed = $statement->execute();
	
	if(!$executed){
		echo $mysqli->error;
	}
	
	$statement->close();

	// echo "End of Prepared Statements";

	$mysqli->close();

}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="nft.css">
    <title>NFT Blockchain Wallet Explorer | Create NFT</title>
	<style>
		.form-check-label {
			padding-top: calc(.5rem - 1px * 2);
			padding-bottom: calc(.5rem - 1px * 2);
			margin-bottom: 0;
		}
	</style>
</head>
<body style="background-image: linear-gradient(to bottom right, rgb(83, 0, 0), rgb(0, 0, 79));">

    <!-- Expandable and Collapsable Navigation Bar -->
    <div id="navbar">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <img src="images/NFTS.png" alt="NovaLaunch NFTs">
                <button style="background-color: rgba(255, 255, 255, 0.375)"  class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Check CSS from assignment03 to see if there is code for a collapsing navbar -->

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="NFT-API.html">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Saved-NFTs.php">Saved NFTs</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link active" aria-current="page" href="Create-NFT-form.html"><strong>Create NFT</strong> | Confirmation Page</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

	<div class="confirmation container">
		<div class="row">
			<h1 class="col-12 mt-4">Create NFT Confirmation</h1>
		</div> <!-- .row -->
		<div class="row mt-4">
			<div class="col-12">

				<!-- Display Error Message Here -->
				<?php if ( isset($error) && !empty($error) ) : ?>

					<div class="text-danger">
						<?php echo $error; ?>
					</div>

				<?php else : ?>

					<div class="text-success">
						<span class="font-italic"><?php echo $_POST['title']; ?></span> was successfully added to your Saved NFTs.
					</div>

				<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->

		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="Create-NFT-form.html" role="button" class="btn btn-primary">Back to Add Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->

	</div> <!-- .container -->

	 <!-- Script to Bootstrap JS -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>