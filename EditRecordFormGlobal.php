<?php

error_reporting(0);
require_once 'db_query.php';
$RecordId = $_POST['RecordId'];
$pageType = $_POST['pageType'];

if ($pageType == 'bf') {
    $editRecord = getArrayResult('SELECT * from DeploymentRecord_bf where RecordId = '.$RecordId.';')[0];
    $reasons = getArrayResult('SELECT ReasonId,Reason from DelayReason where rec_status != 0;');
    $teamnames = getArrayResult('SELECT TeamId,TeamName from Team_bf where rec_status != 0;');
    $delay_records = getArrayResult('SELECT TeamId,ReasonId from DelayReasonRecord_bf where RecordId = '.$RecordId.' order by TeamId ASC;');
    $otherReasonRecords = getArrayResult('SELECT RecordId, TeamId, OtherCauseText FROM OtherCauseRecord_bf WHERE RecordId = '.$RecordId.' order by TeamId ASC;');
    $failreasons = getArrayResult('SELECT ReasonId,Reason from RegressionFailReason where rec_status != 0;');
    $failreasonsRecord = getArrayResult('SELECT ReasonId from RegressionFailReasonRecord_bf where RecordId = '.$RecordId.';');
    $header = 'Booking Form - Edit Deployment Record';
  // $formpost = "editRecord_bf.php";
  $formpost = 'addeditGlobal.php?type=edit&pageType=bf';
    $endtarget = 'index_bf.php';
} elseif ($pageType == 'website') {
    $editRecord = getArrayResult('SELECT * from DeploymentRecord where RecordId = '.$RecordId.';')[0];
    $reasons = getArrayResult('SELECT ReasonId,Reason from DelayReason where rec_status != 0;');
    $teamnames = getArrayResult('SELECT TeamId,TeamName from Team where rec_status != 0;');
    $delay_records = getArrayResult('SELECT TeamId,ReasonId from DelayReasonRecord where RecordId = '.$RecordId.' order by TeamId ASC;');
    $otherReasonRecords = getArrayResult('SELECT RecordId, TeamId, OtherCauseText FROM OtherCauseRecord WHERE RecordId = '.$RecordId.' order by TeamId ASC;');
    $failreasons = getArrayResult('SELECT ReasonId,Reason from RegressionFailReason where rec_status != 0;');
    $failreasonsRecord = getArrayResult('SELECT ReasonId from RegressionFailReasonRecord where RecordId = '.$RecordId.';');
    $header = 'Website - Edit Deployment Record';
    $formpost = 'addeditGlobal.php?type=edit&pageType=website';
    $endtarget = 'index.php';
} elseif ($pageType == 'mmb') {
    $editRecord = getArrayResult('SELECT * from DeploymentRecord_mmb where RecordId = '.$RecordId.';')[0];
    $reasons = getArrayResult('SELECT ReasonId,Reason from DelayReason where rec_status != 0;');
    $teamnames = getArrayResult('SELECT TeamId,TeamName from Team_mmb where rec_status != 0;');
    $delay_records = getArrayResult('SELECT TeamId,ReasonId from DelayReasonRecord_mmb where RecordId = '.$RecordId.' order by TeamId ASC;');
    $otherReasonRecords = getArrayResult('SELECT RecordId, TeamId, OtherCauseText FROM OtherCauseRecord_mmb WHERE RecordId = '.$RecordId.' order by TeamId ASC;');
    $failreasons = getArrayResult('SELECT ReasonId,Reason from RegressionFailReason where rec_status != 0;');
    $failreasonsRecord = getArrayResult('SELECT ReasonId from RegressionFailReasonRecord_mmb where RecordId = '.$RecordId.';');
    $header = 'My.agoda - Edit Deployment Record';
    $formpost = 'addeditGlobal.php?type=edit&pageType=mmb';
    $endtarget = 'index_mmb.php';
}

require_once 'editModal.php';
