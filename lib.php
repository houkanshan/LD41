<?php

function formatIp($ip) {
  $ds = explode('.', $ip);
  $ds[3] = '***';
  return join(".", $ds);
}

function formatId($id) {
  return str_pad($id, 4, "0", STR_PAD_LEFT);
}

function get_ip() {
  // Known prefix
  $v4mapped_prefix_hex = '00000000000000000000ffff';
  $v4mapped_prefix_bin = pack("H*", $v4mapped_prefix_hex);

  // Or more readable when using PHP >= 5.4
  $v4mapped_prefix_bin = hex2bin($v4mapped_prefix_hex);

  // Parse
  $addr = $_SERVER['REMOTE_ADDR'];
  $addr_bin = inet_pton($addr);
  if( $addr_bin === FALSE ) {
    // Unparsable? How did they connect?!?
    die('Invalid IP address');
  }

  // if (strlen($addr_bin) === 16) {
  //   for($i = 0; $i < 8; $i += 2)
  //     $ipv4 .= chr(ord($addr_bin[$i]) ^ ord($addr_bin[$i+1]));
  // }

  // Check prefix
  // if( substr($addr_bin, 0, strlen($v4mapped_prefix_bin)) == $v4mapped_prefix_bin) {
  if (strlen($addr_bin) === 16) {
    // Strip prefix
    $addr_bin = substr($addr_bin, strlen($v4mapped_prefix_bin));
  }
  return inet_ntop($addr_bin);
}

function formatDateDiff($_start, $_end=null) {
  if(!($_start instanceof DateTime)) {
      $start = new DateTime();
      $start->setTimestamp($_start);
  }

  if($_end === null) {
      $end = new DateTime();
  }

  if(!($_end instanceof DateTime)) {
      $end = new DateTime();
      $end->setTimestamp($_end);
  }

  $interval = $end->diff($start);
  $doPlural = function($nb,$str){return $nb>1?$str.'s':$str;}; // adds plurals

  $format = array();
  if($interval->y !== 0) {
      $format[] = "%y ".$doPlural($interval->y, "year");
  }
  if($interval->m !== 0) {
      $format[] = "%m ".$doPlural($interval->m, "month");
  }
  if($interval->d !== 0) {
      $format[] = "%d ".$doPlural($interval->d, "day");
  }
  if($interval->h !== 0) {
      $format[] = "%h ".$doPlural($interval->h, "hour");
  }
  if($interval->i !== 0) {
      $format[] = "%i ".$doPlural($interval->i, "minute");
  }
  if($interval->s !== 0) {
      if(!count($format)) {
          return "less than a minute";
      } else {
          $format[] = "%s ".$doPlural($interval->s, "second");
      }
  }

  // We use the two biggest parts
  if(count($format) > 1) {
      $format = array_shift($format)." and ".array_shift($format);
  } else {
      $format = array_pop($format);
  }

  // Prepend 'since ' or whatever you like
  return $interval->format($format);
}

?>