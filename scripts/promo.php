<?php

require '../db.php';

if ($_GET['promo'] == null) {
	header("Location: /");
}



	$promo = R::findOne('promo', 'promo = ?', [$_GET['promo']]);

	// ограничения
	$i = false;
	if (isset($promo->ogr)) {
		if ($promo->ogr == "on") {
			if ($promo->isp <= 0) {
	        	$i = true;
	        }
		}
	}

    if ($promo != null) {
    	if ($promo->date >= date("Y-m-d") and $i == false) {
    		echo "true ".$promo->sale;
    	} else {
    		echo "false";
    	}
    } else {
    	echo "false";
    }

?>