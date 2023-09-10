<?php declare(strict_types=1);

function Self_Ship(float $Sale_Price = 100) : float {
    $cost = 0;
    return $cost;
}

function FBA(float $Sale_Price = 100) : float {
    $cost = 0;
    return $cost;
}



function Easy_Ship(float $Sale_Price = 0, float $weighs = 0.25 , float $length = 25 ,float $witdth = 25 ,float $height = 25 ) : float {
        ## Sale Price include shipping charge
    
    // grap json data
    $json_url = "EasyShip.json";
    $data = file_get_contents($json_url);
    $data = json_decode($data, false);

    // sort length,witdth,height
    $numbers = array($length , $witdth, $height);
    rsort($numbers);
    $longest= $numbers[0];
    $median = $numbers[1];
    $shortest= $numbers[2];



    //dimensions
    $dimensions_longest = (float) $data->dimensions->longest; // json
    $dimensions_median = (float) $data->dimensions->median; // json
    $dimensions_shortest = (float) $data->dimensions->shortest; // json
    $max_weight = (float) $data->dimensions->max_weight; // json

    //heavy
    $heavy_weight = (float) $data->heavy->weight; // json
    $heavy_Longest = (float) $data->heavy->Longest; // json
    $heavy_sides = (float) $data->heavy->sides; // json
    $heavy_grith = (float) $data->heavy->grith; // json





    // calculate  weighs
    if ($weighs > $max_weight && $weighs < $heavy_weight) { $type = false;} // weighs not standard_size
    elseif ($weighs <= $max_weight && $weighs <= $heavy_weight ) {$type = true;} // weighs not heavy
    else{ return $shipping_cost = 0;  die;} // weighs not allowed


    // calculate  dimensions
    if ($longest < $dimensions_longest &&  $median < $dimensions_median && $shortest < $dimensions_shortest) { if ($type == true) {$type = true;}} // dimensions standard_size 
    elseif ($longest >= $heavy_Longest || $median >= $heavy_sides || $shortest >= $heavy_sides) { return $shipping_cost = 0; $type = false; die;} // dimensions heavy
    else{$type= false;} // dimensions oversize

 

    if ($type == true) {
        # standard_size Calculations
        $shipping_cost = 0;
        $standard_size_extra_weight = (float) $data->standard_size->extra_weight;
        $standard_size_extra_fee = (float) $data->standard_size->extra_fee;
        $standard_size_shipping_fee =  (array) $data->standard_size->shipping_fee;
        $alength = count($standard_size_shipping_fee); // array alength

    if ($weighs >= $standard_size_extra_weight) {
        # code... over extra
            # code...
        $size = $standard_size_shipping_fee[$alength]->size; // json 
        $fee = $standard_size_shipping_fee[$alength]->fee;
        $weighs = $weighs - 2; // extra weighs - First 2KG
        $ceil_weighs = floor($weighs); // ceil weighs
        $extra = $standard_size_extra_fee * $ceil_weighs; // extra ceil
        $shipping_cost  = $extra + $fee; // cost
    }else{

        $x = 1;
        while($x <= $alength) {
    
        $size = $standard_size_shipping_fee[$x]->size; // json shipping_fee size
      
        $fee = $standard_size_shipping_fee[$x]->fee; // json shipping_fee fee
    
        if ($weighs > $size) { $shipping_cost = $fee; $x++;} // next loop if $weighs > $size
        else{$shipping_cost = $fee; $x = $alength + 1;} // stop loop for max size

}



    
  }


    
    }elseif($type == false){
        # oversize Calculations
        $oversize_shipping_fee = (float) $data->oversize->shipping_fee; // json
        $oversize_extra_weight = (float) $data->oversize->extra_weight; // json
        $oversize_extra_fee = (float) $data->oversize->extra_fee; // json

        $Volumetric_Weight = ($length * $witdth * $height) / 5000 ; // Volumetric_Weight
        $weights_arr = array($weighs,$Volumetric_Weight ); // array Volumetric and Weight
        rsort($weights_arr); // sort array
        $weights = $weights_arr[0]; // select bigger value
        $weighs = $weighs - 1; //  Remove First 1KG
        $ceil_weighs = ceil($weighs); // ceil weighs
        $cul_extra_kg = $ceil_weighs * $oversize_extra_fee; // price for extra KG
        $shipping_cost = $oversize_shipping_fee + $cul_extra_kg; // shipping_fee +  extra kg price

    }else{$shipping_cost = 0; die;} // error



    

    return $shipping_cost;

}

//echo Easy_Ship();
?>
