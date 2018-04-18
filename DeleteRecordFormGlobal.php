<?php
error_reporting(0);
require_once 'db_query.php';
$RecordId = $_POST['RecordId'];
$pageType = $_POST['pageType'];

if ($pageType=="bf") {

  $header = "Booking Form - Delete Deployment Record";

  $formpost = "addeditGlobal.php?type=deleterow&pageType=bf";
  $endtarget = "index_bf.php";

} else if ($pageType=="website") {

  $header = "Website - Delete Deployment Record";
  $formpost = "addeditGlobal.php?type=deleterow&pageType=website";
  $endtarget = "index.php";


} else if ($pageType=="mmb") {

  $header = "My.agoda - Delete Deployment Record";
  $formpost = "addeditGlobal.php?type=deleterow&pageType=mmb";
  $endtarget = "index_mmb.php";
}

require_once 'deleteModal.php';
?>