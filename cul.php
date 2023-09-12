<?php



if (isset($_GET['cul'])) {
    # code...
    //echo"0";
    if (isset($_GET['Sale_Price'])) { $Sale_Price = (float)$_GET['Sale_Price'];}else{header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); echo '<br>[Sale_Price] 404<br>'; die;}
    if (isset($_GET['category'])) { $category = (float)$_GET['category'];}else{header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); echo '<br>[category] 404<br>'; die;}
    if (isset($_GET['weighs'])) { $weighs = (float)$_GET['weighs'];}else{header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); echo '<br>[weighs] 404<br>'; die;}
    if (isset($_GET['length'])) { $length = (float)$_GET['length'];}else{header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); echo '<br>[length] 404<br>'; die;}
    if (isset($_GET['witdth'])) { $witdth = (float)$_GET['witdth'];}else{header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); echo '<br>[witdth] 404<br>'; die;}
    if (isset($_GET['height'])) { $height = (float)$_GET['height'];}else{header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); echo '<br>[height] 404<br>'; die;}
    if (isset($_GET['shipping_charge'])) { $shipping_charge = (float)$_GET['shipping_charge'];}else{header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); echo '<br>[shipping_charge] 404<br>'; die;}
    if (isset($_GET['vat'])) { $vat = (float)$_GET['vat'];}else{header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); echo '<br>[vat] 404<br>'; die;}

    include_once "Referral_Fees.php";
    include_once "Shipping.php";

    function vat(float $amount = 0) : float {
        global $vat;
        (float) $vat_amount = ($vat / 100) * $amount;
        return $vat_amount;
    }

    (float) $category = $category; // category in Referral_Fees.json

    (float) $weight = $weighs; // in KG
    (float) $length = $length; // in cm
    (float) $witdth = $witdth; // in cm
    (float) $height = $height; // in cm 
    (float) $price = $Sale_Price;
    (float) $shipping_charge = $shipping_charge;
   // (float) $final = 0;


    (float) $price_vat = vat($price);
   // (float) $shipping_charge_vat = vat($shipping_charge);
    (float) $shipping_charge_price = $shipping_charge ;//+ $shipping_charge_vat;
    (float) $sale_price = $price + $shipping_charge; //+ vat($price + $shipping_charge);
    
    
    
    
    
      (float) $Referral_Fees = Referral_Fees($sale_price,$category);
      (float) $Referral_Fees_vat = vat($Referral_Fees);
      (float) $Referral_price = $Referral_Fees + $Referral_Fees_vat; 
      
    
      (float) $Easy_Ship = Easy_Ship($Referral_price,$weight,$length, $witdth, $height);
      (float) $Easy_Ship_vat = vat($Easy_Ship);
      (float) $Easy_Ship_price = $Easy_Ship + $Easy_Ship_vat;
      (float) $total_cost = $Referral_price + $Easy_Ship_price - $shipping_charge;
      (float) $net =  $sale_price - $Easy_Ship_price - $Referral_price ;
      
      (float) $x = $price;
    
    
    while($x <= $sale_price) {
    
        (float) $sale_price = $sale_price++ ; $x++;
        if ($x >= $net) {(float) $diff = (float)$sale_price - (float)$net ; (float) $final =  (float)$price + (float)$shipping_charge + (float)$diff ; /* final sale price  */ break;}
        
    
    }
 
    
    $cul_array = array("price" => (float)$price ,"final" => (float)$final, "shipping_charge_price" => (float)$shipping_charge_price, "Referral_Fees" => (float)$Referral_Fees, "Referral_Fees_vat" => (float)$Referral_Fees_vat, "Referral_price" => (float)$Referral_price, "Easy_Ship" => (float)$Easy_Ship, "Easy_Ship_vat" => (float)$Easy_Ship_vat, "Easy_Ship_price" => (float)$Easy_Ship_price, "net" => (float)$net );
    
    
 
     echo $data = json_encode($cul_array);
     



}else{header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); echo 404; die;}








?>
