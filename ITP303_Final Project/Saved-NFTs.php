<?php
require "config/config.php";

// DB Connection
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ( $mysqli->connect_errno ) {
	echo $mysqli->connect_error;
	exit();
}

$mysqli->set_charset('utf8');

$sql = "SELECT 
NFT.id AS nft_id, 
NFT.NFT_metadata_id AS metadata_id,
NFT.NFT_attributes_id AS attributes_id,
NFT.contract_address AS contract_address, 
NFT_metadata.title AS title, 
NFT_metadata.data_url AS data_url, 
NFT_metadata.tokenType AS token_type, 
NFT_metadata.description AS nft_description, 
NFT_attributes.trait1 AS trait_1, 
NFT_attributes.value1 AS value_1,  
NFT_attributes.trait2 AS trait_2, 
NFT_attributes.value2 AS value_2,  
NFT_attributes.trait3 AS trait_3, 
NFT_attributes.value3 AS value_3  
				FROM NFT
				LEFT JOIN NFT_metadata
					ON NFT.NFT_metadata_id = NFT_metadata.id
				LEFT JOIN NFT_attributes
					ON NFT.NFT_attributes_id = NFT_attributes.id
				WHERE 1 = 1";

$sql = $sql . ";";

$results = $mysqli->query($sql);

if ( $results == false ) {
	echo $mysqli->error;
	exit();
}

// Close DB Connection.
$mysqli->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="nft.css">
    <title>NFT Blockchain Wallet Explorer | Saved NFTs</title>
</head>
<body id="body-section" style="background-color: rgb(21, 21, 21);">

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
                            <a class="nav-link active" href="Saved-NFTs.php"><strong>Saved NFTs</strong></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Create-NFT-form.html">Create NFT</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <!-- Saved NFT Displays Body Structure -->
    <div id="body-section">
        <div class="container">
            <div class="row">
                <h1 class="col-12 mt-4">Saved NFTs</h1>
            </div> <!-- .row -->
            <div id="nfts-section" class="row">

                <!-- Number of Saved NFTs displayed -->
                <!-- Saved NFTs are pulled from the SQL database -->
                <div id="num-nfts" style="text-align: left; margin-top: 2.5%; margin-bottom: 1%; font-size: 18px;"><strong>Number of NFTs Saved:</strong> <i><?php echo $results->num_rows; ?></i></div>

                <?php while($row = $results->fetch_assoc()) : ?>
                                        
                    <div class="col-lg-3 col-md-6 col-sm-8">
                        <div class="nft-col" >
                            <div class="nft-title" style=" font-size: 18px;">
                                <!-- NFT ID --> 
                                <!-- NFT Title -->
                                <?php echo $row['nft_id']; ?>:<strong> <?php echo $row['title']; ?></strong>
                                <hr></hr>
                            </div>
                            
                            <!-- Add NFT Data Link Here -->
                            <img src="<?php echo $row['data_url']; ?>" alt="<?php echo $row['data_url']; ?>" class="row-10 nft-img">

                            <div class="nft-info"><hr></hr><strong>Contract Address:</strong></div>

                            <div class="nft-info"><i>
                                <!-- Echo out Contract Address -->
                                <?php echo $row['contract_address']; ?>
                            </i></div>

                            <div class="nft-info"> <hr></hr><strong>Token Type: </strong><i>
                                <!-- Echo out Token Type -->
                                <?php echo $row['token_type']; ?>
                            </i></div>

                            <div class="nft-info"> <hr></hr><strong>Description:</strong></div>

                            <div class="nft-info">
                                <!-- Echo out Description -->
                                <?php echo $row['nft_description']; ?>
                            </div>

                            <div class="nft-info"> <hr></hr><strong>Data Link:</strong></div>
                            
                            <div class="nft-info">
                                <!-- Echo out Data Link -->
                                <?php echo $row['data_url']; ?>
                            </div>
                                    
                            <div class="nft-info"> <hr></hr><strong>Attributes:</strong></div>

                            <!-- Echo out Atrributes: Trait-type -> Value -->
                            <div class="nft-info">
                                <?php echo $row['trait_1']; ?>: <i><?php echo $row['value_1']; ?></i>
                            </div>
                            <div class="nft-info">
                                <?php echo $row['trait_2']; ?>: <i><?php echo $row['value_2']; ?> </i>
                            </div>
                            <div class="nft-info">
                                <?php echo $row['trait_3']; ?>: <i><?php echo $row['value_3']; ?> </i>
                            </div>

                            <hr></hr>

                            <a href="Edit-NFT-form.php?
                            nft_id=<?php echo urlencode($row['nft_id']); ?>
                            &metadata_id=<?php echo urlencode($row['metadata_id']);?>
                            &attributes_id=<?php echo urlencode($row['attributes_id']);?>
                            &contract_address=<?php echo urlencode($row['contract_address']);?>
                            &title=<?php echo urlencode($row['title']);?>
                            &data_url=<?php echo urlencode($row['data_url']);?>
                            &token_type=<?php echo urlencode($row['token_type']);?>
                            &nft_description=<?php echo urlencode($row['nft_description']);?>
                            &trait_1=<?php echo urlencode($row['trait_1']);?>
                            &value_1=<?php echo urlencode($row['value_1']);?>
                            &trait_2=<?php echo urlencode($row['trait_2']);?>
                            &value_2=<?php echo urlencode($row['value_2']);?>
                            &trait_3=<?php echo urlencode($row['trait_3']);?> 
                            &value_3=<?php echo urlencode($row['value_3']);?>" 
                            
                            class="btn btn-primary">Edit NFT</a>

                            <a href="Delete-NFT-confirmation.php?
                            nft_id=<?php echo urlencode($row['nft_id']); ?>
                            &metadata_id=<?php echo urlencode($row['metadata_id']);?>
                            &attributes_id=<?php echo urlencode($row['attributes_id']);?>"
                            
                            class="btn btn-primary">Delete NFT</a>

                        </div>
                    </div>

                <?php endwhile; ?>

            </div>
        </div>
    </div>

     <!-- Script to Bootstrap JS -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>