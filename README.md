# Algorand-blockchain-payment
This project is a PHP/Javascript implementation of an Algorand ecommerce payment module on a custom PHP shopping cart. It allows the user to pay for goods and services using the Algorand blockchain cryptocurrencies and stablecoins. Users will have to sign transactions before payment is successful and the transaction is recorded on the blockchain with the payment details attached to the Algorand blockchain transaction note field

# Dependencies
This implementation uses the Algorand Javascript SDK which you can download and link in your script or import if you have NPM installed. Check the Algorand Javascript SDK for the instructions or simply download the latest file for quick test and implementation. 
To get the cryptocurrency rates to USD or any other currencies, the Binance API found here https://api.binance.com/api/v3/ticker/24hr 

# Interacting with Algorand chain
There are two ways of sending and retrieving transactions on Algorand. First option is to run an Algorand Node and use it to process the transactions. As you may understand, setting up and running your own node is costly, and also involves deeper technical knowledge about nodes. The second option is to use community APIs to interact with the blockchain. The APIs offer endpoints to post and retrive transactions on the chain. While some are free, others are paid after certain transactions limits. Since this script's goal is to post and retrieve payment transaction data to the Algorand chain, the second option is chosen. There are currently 2 Algorand rest APIs namely Purestake (requires an account to ge API keys) and Algoexplorer which requires no account signup. We combined the two APIs for different purposes but if you don't want to create an account with Purestake, just stick with AlgoExplorer API. 

# Testnet vs Mainnet
We used the testnets for all testing but you could just switch the API endpoints in either Purestake or AlgoExplorer to use the mainnet when you are ready. It is really that simple. 

# Deployment
This is a PHP implementation which will run on any linux server that supports PHP. This implementation was done on a Xampp localhost. To deploy and test this
1. Simple upload the folder into the htdocs folder or on your public_html on a shared hosting for example. Run the index.php script to start the script
2. You will need to create the databases using the tblproducts.sql
3. We have included the Algosdk as but you should import this using NPM or always make sure you link to the latest version
4. In the js/scrips.js file, set the address to receive payments. The Mnemonic keys of this address will be used to sign transactions as well
5. In check.php, this is where the Algorand payment transaction processing happens. You can edit as much as you want. 

# Note
This is meant to be a guide to PHP developers to understand how to interact with the chain. So no framework was used neither did is use an OOP approach which may be far advanced for a beginner. An experienced developer should be able to abstract this for any higher level implemenation. 

You are free to contribute to this and improve it. 
