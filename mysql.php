<?php

if(in_array($_SERVER['SERVER_NAME'],array('localhost','192.168.1.133'),true))
{
	mysql_connect("localhost","root","");
	mysql_select_db("magicosona");
}
else
{
	mysql_connect("127.0.0.1","root","raspberry");
	mysql_select_db("Magicosona");
}

?>
