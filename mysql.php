<?php

if(in_array($_SERVER['SERVER_NAME'],array('localhost'),true))
{
	mysql_connect("127.0.0.1","root","");
	mysql_select_db("magicosona");
}
else
{
	mysql_connect("127.0.0.1","root","raspberry");
	mysql_select_db("Magicosona");
}

?>
