<?php

require "config/config.php";

// var_dump($_POST);

$isUpdated = false;

// Checks that required fields are filled in
if ( !isset($_POST['nft_id']) || empty($_POST['nft_id']) 
	|| !isset($_POST['title']) || empty($_POST['title']) 
	|| !isset($_POST['metadata_id']) || empty($_POST['metadata_id']) 
	|| !isset($_POST['attributes_id']) || empty($_POST['attributes_id']) 
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

	// All required fields are given, so connect to the database to update this song!
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}


	// UPDATE NFT_metadata table
	$statement = $mysqli->prepare("UPDATE NFT_metadata SET title = ?, data_url = ?, tokenType = ?, description = ? WHERE id = ?");

	$description = urldecode($_POST['nft_description']);
		
	$statement->bind_param("ssssi", $_POST['title'], $_POST['data_url'], $_POST['token_type'], $description, $_POST['metadata_id']);

	$executed = $statement->execute();

	if(!$executed){
		echo $mysqli->error;
	}

	$statement->close();

	// UPDATE NFT_attributes SET trait1 = "Background", value1 = "Orange", trait2 = "Fur", value2 = "Red", trait3 = "Character", value3 = "Unicorn" WHERE id = 5

	// UPDATE NFT_attributes table
	$statement = $mysqli->prepare("UPDATE NFT_attributes SET trait1 = ?, value1 = ?, trait2 = ?, value2 = ?, trait3 = ?, value3 = ? WHERE id = ?");
		
	$statement->bind_param("ssssssi", $_POST['trait_1'], $_POST['value_1'], $_POST['trait_2'], $_POST['value_2'], $_POST['trait_3'], $_POST['value_3'], $_POST['attributes_id']);

	$executed = $statement->execute();

	if(!$executed){
		echo $mysqli->error;
	}

	$statement->close();

	// UPDATE NFT table
	$statement = $mysqli->prepare("UPDATE NFT SET contract_address = ?,  NFT_metadata_id = ?, NFT_attributes_id = ? WHERE id = ?");
		
	$statement->bind_param("siii", $_POST['contract_address'], $_POST['metadata_id'], $_POST['attributes_id'], $_POST['nft-id']);

	$executed = $statement->execute();

	if(!$executed){
		echo $mysqli->error;
	}


	$isUpdated = true;

	$statement->close();

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
    
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item active">
                            <a class="nav-link" aria-current="page" href="NFT-API.html">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="Saved-NFTs.php"><strong>Saved NFTs</strong> | Edit NFT Confirmation</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Create-NFT-form.html">Create NFT</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

	<div class="confirmation container">
		<div class="row mt-4">
			<h1 class="col-12 mt-4">Edit NFT Confirmation</h1>
			<div class="col-12">

				<?php if ( isset($error) && !empty($error) ) : ?>
					<div class="text-danger">
						<?php echo $error; ?>
					</div>
				<?php endif; ?>

				<?php if ($isUpdated) : ?>
					<div class="text-success">
						<span class="font-italic"><?php echo $_POST['title']; ?></span> was successfully edited.
					</div>
				<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->

	 <!-- Script to Bootstrap JS -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>