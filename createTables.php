<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "siteTAR";


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // begin the transaction
    $conn->beginTransaction();
    // our SQL statements
    $conn->exec("CREATE TABLE Users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	fullname VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
	email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
	verified INT NOT NULL,
	country VARCHAR(50) NOT NULL,
	btcwallet VARCHAR(50) NOT NULL,
	role INT NOT NULL,
	plan INT NOT NULL,
    date_created DATETIME DEFAULT CURRENT_TIMESTAMP
	)");
    $conn->exec("CREATE TABLE Wallet (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    id_user VARCHAR(30) NOT NULL,
    amount INT NOT NULL,
    date_created DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    $conn->exec("CREATE TABLE Plans (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    plantype VARCHAR(30) NOT NULL,
	percentage FLOAT NOT NULL,
    schedule INT NOT NULL,
    date_created DATETIME DEFAULT CURRENT_TIMESTAMP
	)");
	$conn->exec("CREATE TABLE Affiliate (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    p_id VARCHAR(30) NOT NULL,
    user_id VARCHAR(30) NOT NULL,
    date_created DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
	$conn->exec("CREATE TABLE PaymentA (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    address VARCHAR(40) NOT NULL,
    amount INT(10) NOT NULL,
    date_created DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
	$conn->exec("CREATE TABLE Invoice (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    p_user VARCHAR(30) NOT NULL,
    id_plan VARCHAR(30) NOT NULL,
	p_address VARCHAR(30) NOT NULL,
	amount FLOAT NOT NULL,
    btc_amount FLOAT NOT NULL,
	tx_id VAR(60) NOT NULL,
	status INT NOT NULL,
    date_created DATETIME DEFAULT CURRENT_TIMESTAMP
	)");
	$conn->exec("CREATE TABLE Investment (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    p_invoice VARCHAR(255) NOT NULL,
    amount FLOAT NOT NULL,
	next_payment DATETIME NOT NULL,
	date_updated DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
	$conn->exec("CREATE TABLE Transaction (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    details VARCHAR(30) NOT NULL,
    amount VARCHAR(30) NOT NULL,
	user_id INT NOT NULL,
	date_updated DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
	$conn->exec("CREATE TABLE Log (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    ip VARCHAR(55) NOT NULL,
    browser VARCHAR(255) NOT NULL,
	date_updated DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    
    // commit the transaction
    $conn->commit();
    echo "New records created successfully";
    }
	
    
    
	
catch(PDOException $e)
    {
    // roll back the transaction if something failed
    $conn->rollback();
    echo "Error: " . $e->getMessage();
    }
	

	
$conn = null;
?>