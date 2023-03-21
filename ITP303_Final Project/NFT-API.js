// Setup request options:
var requestOptions = {
method: 'GET',
redirect: 'follow'
};

// Replace with your Alchemy API key:
const apiKey = "wfH80GCf0aIUA5EHXdHEKur9ZhofUUWG";

// https://eth-mainnet.alchemyapi.io/v2/wfH80GCf0aIUA5EHXdHEKur9ZhofUUWG
const baseURL = `https://eth-mainnet.alchemyapi.io/v2/${apiKey}/getNFTs/`;

// Some Wallet Addresses to Chose from *************************
// Gabe's Hot Wallet: 0xd3A7D070720f3fb8A4932C7A02218337eC300fe4
// Gabe's Cold Wallet: 0x93358578c602bf4294e2ef39c12e45bd907ac16c
// const ownerAddr = "0xF5FFF32CF83A1A614e15F25Ce55B0c0A6b5F8F2c";
// const ownerAddr = "0xC33881b8FD07d71098b440fA8A3797886D831061";
// const ownerAddr = "0xdaAF5F4d339006ea87960f79a08027B4fD3d7Eb1";

document.querySelector("#wallet-search-form").onsubmit = function(event) {
    event.preventDefault();
    console.log("Wallet Search form has been submitted...");

    let ownerAddr = document.querySelector("#wallet-address").value.trim();
    console.log("ownerAddr = " + ownerAddr);

    let removeNFTs = document.querySelector('#nfts-section');

    while (removeNFTs.firstChild) {
        removeNFTs.removeChild(removeNFTs.firstChild);
        console.log("Removing child node...");
    }

    // Create FETCH API variable with base URL and wallet address
    const fetchURL = `${baseURL}?owner=${ownerAddr}`;
    // Make the request and print the formatted response:
    fetch(fetchURL, requestOptions)

    // Returns a JSON object of the API response to the console
    .then(response => {return response.json() })

    .then(result => {

    // Printing to console the JSON object response we recieved from the API fetch
    console.log("Result Response:");
    console.log(result);

    // Number of NFTs returned in the JSON object
    let nftnum = `<div id="num-nfts" style="text-align: left; margin-top: 2.5%; margin-bottom: 1%; font-size: 18px;"><strong>Number of NFTs:</strong> <i>${result.totalCount}</i></div>`;

    // Adding html code to frontend html
    document.getElementById('nfts-section').insertAdjacentHTML("beforeend", nftnum);

    // Looping through all of the NFTs in the JSON object
    for(let i = 0; i < result.ownedNfts.length; i++) {

        // ID, title, image link display, contract address, token type, description
        let htmlStringNft = `
            <div class="col-lg-3 col-md-6 col-sm-8">
                <div class="nft-col">
                    <div class="nft-title" style=" font-size: 18px;" >${i+1}: <strong>${result.ownedNfts[i].title}</strong><hr></hr></div>
                    
                    <img src="${result.ownedNfts[i].metadata.image}" alt="${result.ownedNfts[i].title} image here..." class="row-10 nft-img">

                    <div class="nft-info"><hr></hr><strong>Contract Address:</strong></div>

                    <div class="nft-info"><i>${result.ownedNfts[i].contract.address}</i></div>

                    <div class="nft-info"> <hr></hr><strong>Token Type: </strong><i>${result.ownedNfts[i].id.tokenMetadata.tokenType}</i></div>

                    <div class="nft-info"> <hr></hr><strong>Description:</strong></div>

                    <div class="nft-info">${result.ownedNfts[i].description}</div>

        `;        

        // Check if the NFT has a data link to an image
        // If it doesn't, skip this part
        let dataLink = ``;   
        if (result.ownedNfts[i].metadata.hasOwnProperty("image")) {

            dataLink += `<div class="nft-info"> <hr></hr><strong>Data Link:</strong></div>
            `;

            // Limit the length of the data link to 100 characters
            dataLink += `<div class="nft-info">${JSON.stringify(result.ownedNfts[i].metadata.image).substring(0,100)}</div>
            `;

        }

        // Add the data link address to part 1 of the html string
        htmlStringNft+=dataLink;

        // Check if the NFT has an attributes array, if it does, add corresponding key and value attributes 
        if (result.ownedNfts[i].metadata.hasOwnProperty("attributes")) {

            htmlStringNft += `<div class="nft-info"> <hr></hr><strong>Attributes:</strong></div>`;

            // Loop through each attribute within the attributes array and add corresponding key and value attributes 
            for(let j = 0; j < result.ownedNfts[i].metadata.attributes.length; j++) {
                let attribute = `
                    <div class="nft-info">${result.ownedNfts[i].metadata.attributes[j].trait_type}: <i>${result.ownedNfts[i].metadata.attributes[j].value}</i></div>
                `;

                htmlStringNft+=attribute;
            }

        }

        // Add the button to save the NFT to "Saved NFTs" list

        // ***** Maybe need to use this JS function encodeURIComponent(myUrl)

        // htmlStringNft += 
        //     `<hr></hr>
        //             <a href="Edit-NFT-form.php?id=${i}

        //             nft_id=

        //             &metadata_id=

        //             &attributes_id=
                    
        //             &contract_address=${result.ownedNfts[i].contract.address}
        //             &title=${result.ownedNfts[i].title}
        //             &data_url=${result.ownedNfts[i].metadata.image}
        //             &token_type=${result.ownedNfts[i].id.tokenMetadata.tokenType}
        //             &nft_description=${result.ownedNfts[i].description}

        //             &trait_1=${result.ownedNfts[i].metadata.attributes[0].trait_type}
        //             &value_1=${result.ownedNfts[i].metadata.attributes[0].value}
        //             &trait_2=${result.ownedNfts[i].metadata.attributes[1].trait_type}
        //             &value_2=${result.ownedNfts[i].metadata.attributes[1].value}
        //             &trait_3=${result.ownedNfts[i].metadata.attributes[2].trait_type}
        //             &value_3=${result.ownedNfts[i].metadata.attributes[2].value}
                    
        //             class="btn btn-primary">Save NFT</a>
        //         </div>
        //     </div>
        // `;

        // Add all NFT html to frontend
        document.getElementById('nfts-section').insertAdjacentHTML("beforeend", htmlStringNft);
    };

    })
    
    // Log out error if there is an error with the API call
    .catch(error => {
    console.log("Error: ");
    console.log('Error:' + error)
    });

}
