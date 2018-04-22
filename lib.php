<?php

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

?>