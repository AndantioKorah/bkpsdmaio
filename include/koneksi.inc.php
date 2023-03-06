<?php
$my['host']	= "localhost";
$my['user']	= "root";
$my['pass']	= "";
$my['dbs']	= "simpegd";

$koneksi	= mysql_connect($my['host'], $my['user'], $my['pass']);
if (! $koneksi) {
  echo "Tidak bisa koneksi ciks...!";
  mysql_error();
}
// memilih database pda server
mysql_select_db($my['dbs'])
	 or die ("Database tidak ada".mysql_error());

?>