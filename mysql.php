<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(in_array($_SERVER['SERVER_NAME'],array('localhost','192.168.1.133'),true))
{
	mysql_connect("localhost","root","");
	mysql_select_db("magicosona");
}
else
{
	mysql_connect("mysql.hostinger.es","u399340612_lluis","lluislluis1");
	mysql_select_db("u399340612_lliga");
}
?>
