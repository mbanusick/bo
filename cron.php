<?php 

require "conn.php";

$allInvestments = $pdo->prepare("SELECT investment.*, users.plan, invoice.usd_amount, invoice.p_user, plans.schedule, plans.plantype, plans.schedule, plans.percentage, wallet.wallet_amount, wallet.wallet_id FROM investment 
LEFT JOIN invoice ON investment.p_invoice = invoice.id 
LEFT JOIN plans ON invoice.id_plan = plans.id
LEFT JOIN users ON invoice.p_user = users.id 
LEFT JOIN wallet ON invoice.p_user = wallet.id_user
");
$allInvestments->execute();

$investments = [];
while ($row = $allInvestments->fetch(PDO::FETCH_ASSOC)) { 
    array_push($investments, $row); 
}
echo "<pre>";

if(empty($investments)) {
    echo "No investment";
} else {
    // print_r($investments);
    for($i = 0; $i < count($investments); $i++) {
        $now = date("Y-m-d H:i:s", time());
       
        if($now >= $investments[$i]["next_payment"]) {
            $_id = $investments[$i]["id"];
            $percentage = $investments[$i]["percentage"];
            $amount = $investments[$i]["amount"];
            $usd_amount = $investments[$i]["usd_amount"];
            $pay = ($percentage / 100) * $usd_amount;
            $final_pay = "";
            switch($investments[$i]["plan"]) {
                case "1":
                    $final_pay = $pay;
                    $payment = $amount + $final_pay;
                    $schedule = $investments[$i]["schedule"];
                    break;
                case "2":
                    $final_pay = $pay + 50;
                    $payment = $amount + $final_pay;
                    $schedule = $investments[$i]["schedule"];
                    break;
            }   

           
            try {
                
                $pdo->beginTransaction();

                $dayOfWeek = date("l", strtotime($investments[$i]["next_payment"]));

                if($dayOfWeek == "Saturday" || $dayOfWeek == "Sunday") {
                    $mkTime = strtotime("+1 day");
                    $nxtPayment = date("Y-m-d H:i:s", $mkTime);

                    $pdo->prepare("UPDATE investment SET next_payment = '$nxtPayment' WHERE id = $_id")->execute();
                } else {
                    $mkTime = strtotime("+$schedule");
                    $nxtPayment = date("Y-m-d H:i:s", $mkTime);
        
                    $pdo->prepare("UPDATE investment SET amount = $payment, next_payment = '$nxtPayment' WHERE id = $_id")->execute();
                    
                    $p_user = $investments[$i]["p_user"];
                    $wallet_amount = $investments[$i]["wallet_amount"];
                    
                    if(empty($investments[$i]["wallet_id"])) {
                        $pdo->prepare("INSERT INTO wallet (id_user, wallet_amount) VALUES($p_user, $payment)")->execute();
                    } else {
                        $payment = $wallet_amount + $final_pay;
                        // var_dump($wallet_amount); var_dump($final_pay);
                        $pdo->prepare("UPDATE wallet SET wallet_amount = $payment WHERE id_user = $p_user")->execute();
                    }

                     // Save to Transaction..
                     $pdo->prepare("INSERT INTO transaction (details, amount, user_id) VALUES (2, $final_pay, $p_user)")->execute();
                    
                    echo "Done! <br> \n";
                }
                
                $pdo->commit();
            } catch(PDOException $e) {
                $pdo->rollBack();
            } 
            

        } else {
            echo "This investment is not ready for additional payment <br> \n";
        }
    }
}

echo "</pre>";

?>