<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


//  home page URL
$home_url="http://localhost/REST-API.v3/Api/";

//  page given in URL parameter, default page is one
$page =isset($_GET['page']) ? $_GET['page'] : 1;

// numbers of records per page
$records_per_page=5;

//  calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;
?>
