<?php
session_start();
if (!session_is_registered("SES_USER")) {
	echo "<br /><div align=center><b><font color=ff0000 >Maaf, Anda Harus Login untuk masuk ke sini</font></b></div>";
	include"index.php";
	exit;
	}

?> 