<?php 
	//on se connecte à la DB
    $connect = mysql_connect('localhost','root','');

    $cid =mysql_select_db('ouieatfrench',$connect);

    $dropProduct = mysql_query('TRUNCATE TABLE admin_product');
    $dropFilter = mysql_query('TRUNCATE TABLE filter_for_product');
    $dropFilter = mysql_query('TRUNCATE TABLE product_filter');
?>