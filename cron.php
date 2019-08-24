<?php 

require "conn.php";

$allInvestments = $pdo->prepare("SELECT investment.*, invoice.amount, plans.schedule, plans.plantype, plans.schedule FROM investment LEFT JOIN invoice ON investment.p_invoice = invoice.id LEFT JOIN plans ON invoice.id_plan = plans.id");
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
            $schedule = $investments[$i]["schedule"];
            $pay = ($percentage / 100) * $amount;

            if($investments[$i]["plantype"] === "Compounding") {
                $payment = $amount + $pay + 50;
            } else {
                $payment = $amount + $pay;
            }

            $mkTime = strtotime("+{$schedule} days");
            $nxtPayment = date("Y-m-d H:i:s", $mkTime);

            $pdo->prepare("UPDATE investment SET amount = $payment, next_payment = '$nxtPayment' WHERE id = $_id")->execute();
            
            echo "Done!";

        } else {
            echo "No investment is available for additional payment";
        }
        
    }
}


?>