<?php

// var_dump($_GET);

$isDeleted = false;

if ( !isset($_GET['nft_id']) || empty($_GET['nft_id']) 
	|| !isset($_GET['metadata_id']) || empty($_GET['metadata_id']) 
	|| !isset($_GET['attributes_id']) || empty($_GET['attributes_id']) 
	) {

	// Missing required fields.
	$error = "Invalid IDs.";

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

	//  NFT Table
	$statement = $mysqli->prepare("DELETE FROM NFT WHERE id = ?");
	$statement->bind_param("i", $_GET["nft_id"]);

	$executed = $statement->execute();
	if(!$executed) {
		echo $mysqli->error;
		exit();
	}

	// Metadata Table
	$statement = $mysqli->prepare("DELETE FROM NFT_metadata WHERE id = ?");
	$statement->bind_param("i", $_GET["metadata_id"]);

	$executed = $statement->execute();
	if(!$executed) {
		echo $mysqli->error;
		exit();
	}

	// Attributes Table
	$statement = $mysqli->prepare("DELETE FROM NFT_attributes WHERE id = ?");
	$statement->bind_param("i", $_GET["attributes_id"]);

	$executed = $statement->execute();
	if(!$executed) {
		echo $mysqli->error;
		exit();
	}

	// Check that only one row was affected
	if($statement->affected_rows == 1) {
		$isDeleted = true;
	}

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
                            <a class="nav-link active" href="Saved-NFTs.php"><strong>Saved NFTs</strong> | Delete NFT Confirmation</a>
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
		<div class="row">
			<h1 class="col-12 mt-4">Delete NFT Confirmation</h1>
		</div> <!-- .row -->
		<div class="row mt-4">
			<div class="col-12">

				<?php if ( isset($error) && !empty($error) ) : ?>

					<div class="text-danger">
						<?php echo $error; ?>
					</div>

				<?php else : ?>

					<div class="text-success">
						<span class="font-italic">NFT with ID:<?php echo $_GET['nft_id']; ?></span> was successfully deleted from Saved NFTs.
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