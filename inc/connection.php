<?php
try{
  $db = new PDO("mysql:host=v360d.db.11440322.2d3.hostedresource.net;dbname=v360d", "v360d", "Wakandaforever10!");
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e)
{
  echo "Connection Error: ". $e->getMessage();
  exit;
}
 ?>
