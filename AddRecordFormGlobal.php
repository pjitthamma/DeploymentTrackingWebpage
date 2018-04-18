<?php
error_reporting(0);
require_once 'db_query.php' ;
$pageType = $_POST['pageType'];

if ($pageType=="bf") {

  $teamnames = getArrayResult("SELECT TeamId,TeamName from Team_bf where rec_status != 0;");
  $reasons = getArrayResult("SELECT ReasonId,Reason from DelayReason where rec_status != 0;");
  $failreasons = getArrayResult("SELECT ReasonId,Reason from RegressionFailReason where rec_status != 0;");
  $header = "Booking Form - Add Deployment Record";
  $formpost = "addeditGlobal.php?type=add&pageType=bf";
  $endtarget = "index_bf.php";

} else if ($pageType=="website") {

  $teamnames = getArrayResult("SELECT TeamId,TeamName from Team where rec_status != 0;");
  $reasons = getArrayResult("SELECT ReasonId,Reason from DelayReason where rec_status != 0;");
  $failreasons = getArrayResult("SELECT ReasonId,Reason from RegressionFailReason where rec_status != 0;");
  $header = "Website - Add Deployment Record";
  $formpost = "addeditGlobal.php?type=add&pageType=website";
  $endtarget = "index.php";


} else if ($pageType=="mmb") {

  $teamnames = getArrayResult("SELECT TeamId,TeamName from Team_mmb where rec_status != 0;");
  $reasons = getArrayResult("SELECT ReasonId,Reason from DelayReason where rec_status != 0;");
  $failreasons = getArrayResult("SELECT ReasonId,Reason from RegressionFailReason where rec_status != 0;");
  $header = "My.agoda - Add Deployment Record";
  $formpost = "addeditGlobal.php?type=add&pageType=mmb";
  $endtarget = "index_mmb.php";
}

require_once 'addModal.php';
?>
