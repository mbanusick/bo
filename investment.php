<?php
    require_once "conn.php";

    if(isset($_POST["txId"]) && isset($_POST["payAmount"]) && 
    isset($_POST["btcValue"]) &&  isset($_POST["btcAddress"]) && 
    isset($_POST["userPlan"])) {
	
	$id = $_SESSION["id"];
		extract($_POST);
        // Send to invoice table and set status to 0;
		 $sql = "INSERT INTO invoice (p_user, id_plan, p_address, amount, btc_amount, tx_id, status) VALUES ($id, :userPlan, :btcAddress, :payAmount, :btcValue, :txId, 0)";
		 
		
		 
		 if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":txId", $param_txId, PDO::PARAM_STR);
            $stmt->bindParam(":payAmount", $param_payAmount, PDO::PARAM_STR);
			$stmt->bindParam(":btcValue", $param_btcValue, PDO::PARAM_STR);
           	$stmt->bindParam(":btcAddress", $param_btcAddress, PDO::PARAM_STR);
			$stmt->bindParam(":userPlan", $param_userPlan, PDO::PARAM_INT);
            
            // Set parameters
            $param_txId = $txId;
			$param_payAmount = $payAmount;
			$param_btcValue = $btcValue;
			$param_btcAddress = $btcAddress;
            $param_userPlan = $userPlan;
			
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
               echo true;
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        
    }

?>