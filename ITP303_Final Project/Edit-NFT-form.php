<?php
require "config/config.php";

// var_dump($_GET);

// Check to make sure we received a nft_id at this point
if( 
	!isset($_GET["nft_id"]) || empty($_GET["nft_id"])
	|| !isset($_GET['title']) || empty($_GET['title']) 
	|| !isset($_GET['metadata_id']) || empty($_GET['metadata_id']) 
	|| !isset($_GET['attributes_id']) || empty($_GET['attributes_id']) 
	|| !isset($_GET['contract_address']) || empty($_GET['contract_address'])
	|| !isset($_GET['data_url']) || empty($_GET['data_url'])
	|| !isset($_GET['token_type']) || empty($_GET['token_type'])
	|| !isset($_GET['nft_description']) || empty($_GET['nft_description']) 
	|| !isset($_GET['trait_1']) || empty($_GET['trait_1']) 
	|| !isset($_GET['trait_2']) || empty($_GET['trait_2']) 
	|| !isset($_GET['trait_3']) || empty($_GET['trait_3']) 
	|| !isset($_GET['value_1']) || empty($_GET['value_1']) 
	|| !isset($_GET['value_2']) || empty($_GET['value_2']) 
	|| !isset($_GET['value_3']) || empty($_GET['value_3']) 
	) {

	echo "Invalid GET somewhere.";
	exit();
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
                            <a class="nav-link active" href="Saved-NFTs.php"><strong>Saved NFTs</strong> | Edit NFT</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Create-NFT-form.html">Create NFT</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Edit NFT Form</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->


    <!-- Create NFT Form Input Rows -->
	<div id="body-section">
        <div class="container">
            <div id="nfts-section" class="row">

				<form action="Edit-NFT-confirmation.php" method="POST">

					<!-- Hidden NFT_id input -->
					<input type="hidden" class="form-control" id="title-id" name="nft_id" value="<?php echo $_GET["nft_id"]; ?>">

					<!-- Hidden metddata id input -->
					<input type="hidden" class="form-control" id="metadata-id" name="metadata_id" value="<?php echo $_GET["metadata_id"]; ?>">

					<!-- Hidden attributes id input -->
					<input type="hidden" class="form-control" id="attributes-id" name="attributes_id" value="<?php echo $_GET["attributes_id"]; ?>">

					<!-- NFT Name -->
					<div class="form-group row">
						<label for="name-id" class="col-sm-3 col-form-label text-sm-right">
							<strong>NFT Name: </strong><span class="text-danger">*</span>
						</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="name-id" name="title" value="<?php echo $_GET["title"]; ?>">
						</div>
					</div> <!-- .form-group -->

					<!-- NFT Contract Address -->
					<div class="form-group row">
						<label for="address-id" class="col-sm-3 col-form-label text-sm-right">
							<strong>NFT Contract Address: </strong><span class="text-danger">*</span>
						</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="address-id" name="contract_address" value="<?php echo $_GET["contract_address"]; ?>">
						</div>
					</div> <!-- .form-group -->

					<!-- NFT Token Type -->
					<div class="form-group row">
						<label for="token-type-id" class="col-sm-3 col-form-label text-sm-right">
							<strong>NFT Token Type: </strong><span class="text-danger">*</span>
						</label>
						<div class="col-sm-9">
							<select name="token_type" id="token-type-id" class="form-control">
								<option value="ERC721" >ERC721</option>
								<option value="ERC1155" >ERC1155</option>
								<option value="" selected disabled>-- Select One Token Type --</option>
							</select>
						</div>
					</div> <!-- .form-group -->

					<!-- NFT Description -->
					<div class="form-group row">
						<label for="description-id" class="col-sm-3 col-form-label text-sm-right">
							<Strong>NFT Description: </Strong><span class="text-danger">*</span>
						</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="description-id" name="nft_description" value="<?php echo $_GET['nft_description']; ?>">
						</div>
					</div> <!-- .form-group -->

					<!-- NFT Data Link (Image) -->
					<div class="form-group row">
						<label for="data-link-id" class="col-sm-3 col-form-label text-sm-right">
							<strong>NFT Data Link (Image): </strong><span class="text-danger">*</span>
						</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="data-link-id" name="data_url" value=" <?php echo $_GET['data_url']; ?>">
						</div>
					</div> <!-- .form-group -->

					<!-- NFT Attributes -->
					<div class="form-group row">
						<label for="attributes-id" class="col-sm-3 col-form-label text-sm-right">
							<strong>NFT Attributes: </strong><span class="text-danger">*</span>
						</label>
					</div> <!-- .form-group -->

					<div id="nft-traits">
						<!-- Trait Types -->
						<div class="form-group row">
							<label for="attributes-id" class="col-sm-3 col-form-label text-sm-right">
								<i>Trait Types: </i><span class="text-danger">*</span>
							</label>
						</div> <!-- .form-group -->

						<div class="form-group row">
							<div class="col-sm-9">
								<input type="text" class="form-control" id="data-link-id" name="trait_1" value="<?php echo $_GET['trait_1']; ?>">
							</div>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="data-link-id" name="trait_2" value="<?php echo $_GET['trait_2']; ?>">
							</div>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="data-link-id" name="trait_3" value="<?php echo $_GET['trait_3']; ?>">
							</div>
						</div> <!-- .form-group -->

						<!-- Values for Trait Types -->
						<div class="form-group row">
							<label for="attributes-id" class="col-sm-3 col-form-label text-sm-right">
								<i>Values: </i><span class="text-danger">*</span>
							</label>
						</div> <!-- .form-group -->

						<div class="form-group row">
							<div class="col-sm-9">
								<input type="text" class="form-control" id="data-link-id" name="value_1" value="<?php echo $_GET['value_1']; ?>">
							</div>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="data-link-id" name="value_2" value="<?php echo $_GET['value_2']; ?>">
							</div>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="data-link-id" name="value_3" value="<?php echo $_GET['value_3']; ?>">
							</div>
						</div> <!-- .form-group -->
					</div>

					<!-- Show what properties are required to create the NFT -->
					<div class="form-group row">
						<div class="ml-auto col-sm-9">
							<span class="text-danger font-italic">* Required</span>
						</div>
					</div> <!-- .form-group -->

					<!-- Create NFT and Reset Properties Button -->
					<div class="form-group row" style="margin-bottom: 15%;">
						<!-- <div class="col-sm-9 mt-2"> -->
							<button type="submit" class="btn btn-primary">Edit NFT</button>
							<button type="reset" class="btn btn-light">Reset NFT Properties</button>
						<!-- </div> -->
					</div> 

				</form>

			</div>
		</div>
	</div> <!-- .container -->

	 <!-- Script to Bootstrap JS -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>