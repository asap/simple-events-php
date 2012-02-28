<?php

function sanitize( $value, $type ) {
  $value = (!get_magic_quotes_gpc()) ? addslashes($value) : $value;

  switch ($type) {
    case "text":
      $value = ($value != "") ? "'" . $value . "'" : "NULL";
      break;
    case "long":
    case "int":
      $value = ($value != "") ? intval($value) : "NULL";
      break;
    case "double":
      $value = ($value != "") ? "'" . doubleval($value) . "'" : "NULL";
      break;
    case "date":
      $value = ($value != "") ? "'" . $value . "'" : "NULL";
      break;
  }

  return $value;
}

function convert_to_mysqldate($date){
	return date( 'Y-m-d H:i:s', strtotime( $date ) );
}

function clean_phone_number($number){
	return preg_replace( '/[^0-9,]|,[0-9]*$/','', $number );
}

function format_phone_number($number){
	//$data = '+11234567890';

	if(  preg_match( '/^\+?\d?(\d{3})(\d{3})(\d{4})$/', $number,  $matches ) )
	{
	    $result = $matches[1] . '-' .$matches[2] . '-' . $matches[3];
	    return $result;
	}
}

function format_date($date, $format = "l F d, Y, g:i a"){
	return strtoupper( date( $format , strtotime( $date ) ) );
}

function today($format = "Y-m-d"){
	return Date($format);
}

function nextMonth($format = "Y-m-d"){
	return Date($format, strtotime( "+1 month" ) );
}
?>