<?php declare(strict_types=1);

function Referral_Fees(float $Sale_Price = 100,  int $Category = 38) : float {
    ## Sale Price include shipping charge
    
    // grap json data
    $json_url = "Referral_Fees.json";
    $data = file_get_contents($json_url);
    $data = json_decode($data, false);

    if (empty($data->$Category)) {die(json_encode(array('error' => 'يجب تحديد القسم الخاص بالمنتج من القائمة ')));}

    $category_name = (string) $data->$Category->Category;
    $category_perentage =  (int)   $data->$Category->Referral_Fee_perentage;
    $category_minimum =    (int)   $data->$Category->Referral_fee_minimum;

    // is it multi perentage?
    if ($category_perentage == false) {
        # code...
        $limit_price = (int) $data->$Category->multi_perentage->limit_price;
        $less =  (int)   $data->$Category->multi_perentage->less;
        $more =  (int)   $data->$Category->multi_perentage->more;
        if ($Sale_Price <= $limit_price) { $category_perentage = $less;}else{$category_perentage = $more;}
    }
    

    // Commission perentage
    (float)$Commission_fee = ($category_perentage / 100) * $Sale_Price; 


    // limit Commission to the minimun
    if ($Commission_fee <= $category_minimum) { $Commission_fee = $category_minimum;}


  
 
    return $Commission_fee;
}


//echo Referral_Fees();
?>
