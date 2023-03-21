# NFT-Blockchain-Explorer-Using-Alchemy-NFT-API

NFT Wallet Blockchain Explorer built for NFT and crypto enthusiasts.

### Project Summary
This web app is a blockchain explorer for NFTs in wallets on the Ethereum mainnet (ERC721 and ERC1155 Token NFTs). This website allows the user to enter an Ethereum wallet address and retrieve all of the Ethereum NFTs (metadata) in that specific wallet using a FETCH request to Alchmey’s NFT API. Additonally, this web app supports CRUD functionality for NFTs where users can create NFTs, can edit NFTs, can delete NFTs, and can view the NFTs that they create from the SQL database. The front-end is built with bootstraps UI library.

Whenever a user hovers over the “Search Wallet” button on the main page after entering a wallet address, upon clicking on the button, JS is used to FETCH the Alchemy API and retrieve all of the NFTs in that wallet. Check out file NFT-API.js file to see.

### BACK-END:
Database: tgavin_nft_db

Credentials to access the DB can be found in config.php:
- "DB_HOST", "303.itpwebdev.com"
- "DB_USER", "tgavin_db_user"
- "DB_PASS", "Stringking" 
- "DB_NAME", "tgavin_nft_db"

#### Where in your project do you insert a record to the database (the ‘C’ in CRUD)?
Create NFT - Creates an NFT record using a form and inserts its data into the SQL database.
- `Create NFT Button - Navigation Barr`
- `Create NFT Form - Create-NFT-form.html`
- `Create NFT Confirmation - Create-NFT-confirmation.php`

#### Where in your project do you search and display record(s) from the database (the ‘R’ in CRUD)?
Read NFTs - Pulls NFT record data from the SQL database and displays it on the frontend for users to view.
Pages and Functionality:
- `View Saved NFTs Button - Navigation Bar View Saved NFTs - Saved-NFTs.php`

#### Where in your project do you update and existing record(s) the database (the ‘U’ in CRUD)?
Edit NFT - Allows the user to edit the data of a specific NFT record where it updates that respective NFTs data in the SQL database.
Pages and Functionality:
- `Edit NFT Button - Saved-NFTs.php`
- `Edit NFT Form - Edit-NFT-form.php`
- `Edit NFT Confirmation - Edit-NFT-confirmation.php`

#### Where in your project do you delete existing record(s) from the database (the ‘D’ in CRUD)?
Delete NFT - Allows the user to delete an NFT record and its data from the SQL database.
Pages and Functionality:
- `Delete NFT Button - Saved-NFTs.php`
- `Delete NFT Confirmation - Delete-NFT-confirmation.php`

### Alchemy NFT API
Alchemy’s NFT API - https://docs.alchemy.com/alchemy/enhanced-apis/nft-api

Here are some wallet addresses you can enter to test the API: (I recommend the one in yellow)
- Gabe's Hot Wallet: 0xd3A7D070720f3fb8A4932C7A02218337eC300fe4
- Gabe's Cold Wallet: 0x93358578c602bf4294e2ef39c12e45bd907ac16c
- const ownerAddr = 0xF5FFF32CF83A1A614e15F25Ce55B0c0A6b5F8F2c
- const ownerAddr = 0xC33881b8FD07d71098b440fA8A3797886D831061
- const ownerAddr = 0xdaAF5F4d339006ea87960f79a08027B4fD3d7Eb1
