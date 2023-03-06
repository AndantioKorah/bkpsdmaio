 <?
$today = getdate(); 
$month = $today['mon']; 
$mday = $today['mday']; 
$year = $today['year']; 
$hours = $today['hours']; 
$minutes = $today['minutes']; 
$seconds = $today['seconds'];
$waktu=$year.'-'.$month.'-'.$mday.' '.$hours.':'.$minutes.':'.$seconds;
echo $waktu;
 ?>