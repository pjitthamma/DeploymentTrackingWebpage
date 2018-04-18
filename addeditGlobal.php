<?php

require_once 'db_query.php';

$type = $_GET['type'];
$pageType = $_GET['pageType'];

if ($pageType == 'bf') {
    $DeploymentRecordTbl = 'DeploymentRecord_bf';
    $RegressionFailReasonRecordTbl = 'RegressionFailReasonRecord_bf';
    $DelayReasonRecordTbl = 'DelayReasonRecord_bf';
    $OtherCauseRecordTbl = 'OtherCauseRecord_bf';
    $RegressionFailReasonRecordTbl = 'RegressionFailReasonRecord_bf';
} elseif ($pageType == 'website') {
    $DeploymentRecordTbl = 'DeploymentRecord';
    $RegressionFailReasonRecordTbl = 'RegressionFailReasonRecord';
    $DelayReasonRecordTbl = 'DelayReasonRecord';
    $OtherCauseRecordTbl = 'OtherCauseRecord';
    $RegressionFailReasonRecordTbl = 'RegressionFailReasonRecord';
} elseif ($pageType == 'mmb') {
    $DeploymentRecordTbl = 'DeploymentRecord_mmb';
    $RegressionFailReasonRecordTbl = 'RegressionFailReasonRecord_mmb';
    $DelayReasonRecordTbl = 'DelayReasonRecord_mmb';
    $OtherCauseRecordTbl = 'OtherCauseRecord_mmb';
    $RegressionFailReasonRecordTbl = 'RegressionFailReasonRecord_mmb';
}

$DeploymentDate = $_POST['DeploymentDate'] != '' ? $_POST['DeploymentDate'] : null;
$Cycle = $_POST['CycleTime'] != '' ? $_POST['CycleTime'] : null;
$PackageVersion = $_POST['PackageVersion'] != '' ? $_POST['PackageVersion'] : null;
$ReleaseStatus = $_POST['ReleaseStatus'] != '' ? $_POST['ReleaseStatus'] : 0;
$LiveRollBack = $_POST['LiveRollBack'] != '' ? $_POST['LiveRollBack'] : 0;
$DeploymentNote = $_POST['DeploymentNote'] != '' ? htmlspecialchars($_POST['DeploymentNote'], ENT_QUOTES) : null;
$SendDeploymentMail = $_POST['SendDeploymentMailDate'] != '' ? $_POST['SendDeploymentMailDate'].' '.$_POST['SendDeploymentMailTime'] : null;
$InfraDeployMaster = $_POST['InfraDeployMasterDate'] != '' ? $_POST['InfraDeployMasterDate'].' '.$_POST['InfraDeployMasterTime'] : null;
$ReceiveDeploymentMail = $_POST['ReceiveDeploymentMailDate'] != '' ? $_POST['ReceiveDeploymentMailDate'].' '.$_POST['ReceiveDeploymentMailTime'] : null;
$DeployAllDone = $_POST['DeployAllDoneDate'] != '' ? $_POST['DeployAllDoneDate'].' '.$_POST['DeployAllDoneTime'] : null;
$RegressionTestResult = $_POST['RegressionTestResult'] ? $_POST['RegressionTestResult'] : 0;
$RegressionTestNote = $_POST['RegressionTestNote'] != '' ? htmlspecialchars($_POST['RegressionTestNote'], ENT_QUOTES) : null;
if ($pageType == 'website') {
    $SQLCommandTestResult = $_POST['SQLCommandTestResult'] ? $_POST['SQLCommandTestResult'] : 0;
    $SQLCommandTestNote = $_POST['SQLCommandTestNote'] != '' ? htmlspecialchars($_POST['SQLCommandTestNote'], ENT_QUOTES) : null;
    $ConnectionTestResult = $_POST['ConnectionTestResult'] ? $_POST['ConnectionTestResult'] : 0;
    $ConnectionTestNote = $_POST['ConnectionTestNote'] != '' ? htmlspecialchars($_POST['ConnectionTestNote'], ENT_QUOTES) : null;
}
$OtherCauseNote = $_POST['OtherCauseNote'] != '' ? htmlspecialchars($_POST['OtherCauseNote'], ENT_QUOTES) : null;
$delayTeams = $_POST['delayTeam'];
$failReasons = $_POST['failReason'];

if ($type == 'edit') {
    $RecordId = $_POST['RecordId'];
    if (($SendDeploymentMail != null) && ($ReceiveDeploymentMail != null)) {
        $to_time = strtotime($ReceiveDeploymentMail);
        $from_time = strtotime($SendDeploymentMail);
        $ElapseTime = round(abs($to_time - $from_time) / 60, 2).' min';
    } else {
        $ElapseTime = null;
    }

    if ($pageType == 'website') {
        $update_DeploymentRecord = '
              UPDATE ' .$DeploymentRecordTbl."
              SET DeploymentDate = '" .$DeploymentDate."'
              , Cycle = '" .$Cycle."'
              , PackageVersion = '" .$PackageVersion."'
              , ReleaseStatus = '" .$ReleaseStatus."'
              , LiveRollBack = '" .$LiveRollBack."'
              , DeploymentNote = '" .$DeploymentNote."'
              , SendDeploymentMail = '" .$SendDeploymentMail."'
              , InfraDeployMaster = '" .$InfraDeployMaster."'
              , ReceiveDeploymentMail = '" .$ReceiveDeploymentMail."'
              , DeployAllDone = '" .$DeployAllDone."'
              , RegressionTestResult = '" .$RegressionTestResult."'
              , RegressionTestNote = '" .$RegressionTestNote."'
              , SQLCommandTestResult = '" .$SQLCommandTestResult."'
              , SQLCommandTestNote = '" .$SQLCommandTestNote."'
              , ConnectionTestResult = '" .$ConnectionTestResult."'
              , ConnectionTestNote = '" .$ConnectionTestNote."'
              , OtherCauseNote = '" .$OtherCauseNote."'
              WHERE RecordId = " .$RecordId.';';
    } else {
        $update_DeploymentRecord = '
              UPDATE ' .$DeploymentRecordTbl."
              SET DeploymentDate = '" .$DeploymentDate."'
              , Cycle = '" .$Cycle."'
              , PackageVersion = '" .$PackageVersion."'
              , ReleaseStatus = '" .$ReleaseStatus."'
              , LiveRollBack = '" .$LiveRollBack."'
              , DeploymentNote = '" .$DeploymentNote."'
              , SendDeploymentMail = '" .$SendDeploymentMail."'
              , InfraDeployMaster = '" .$InfraDeployMaster."'
              , ReceiveDeploymentMail = '" .$ReceiveDeploymentMail."'
              , DeployAllDone = '" .$DeployAllDone."'
              , RegressionTestResult = '" .$RegressionTestResult."'
              , RegressionTestNote = '" .$RegressionTestNote."'
              , OtherCauseNote = '" .$OtherCauseNote."'
              WHERE RecordId = " .$RecordId.';';
    }

    update($update_DeploymentRecord);

    $delete_failReasons = 'DELETE from '.$RegressionFailReasonRecordTbl.' where RecordId = '.$RecordId.';';
    delete($delete_failReasons);

    $delete_delayTeams = 'DELETE from '.$DelayReasonRecordTbl.' where RecordId = '.$RecordId.';';
    delete($delete_delayTeams);

    $delete_OtherCauses = 'DELETE from '.$OtherCauseRecordTbl.' where RecordId = '.$RecordId.';';
    delete($delete_OtherCauses);
} elseif ($type == 'add') {
    if ($pageType == 'website') {
        $insert_DeploymentRecord = '
              INSERT INTO ' .$DeploymentRecordTbl."
              (RecordId, DeploymentDate, Cycle, ReleaseStatus, LiveRollBack, DeploymentNote, SendDeploymentMail, InfraDeployMaster, ReceiveDeploymentMail, DeployAllDone, RegressionTestResult, RegressionTestNote, SQLCommandTestResult, SQLCommandTestNote, ConnectionTestResult, ConnectionTestNote, OtherCauseNote, PackageVersion, rec_status)
              VALUES(
              NULL,'" .
              $DeploymentDate."' , '".
              $Cycle."' , ".
              $ReleaseStatus.' , '.
              $LiveRollBack." , '".
              $DeploymentNote."' , '".
              $SendDeploymentMail."' , '".
              $InfraDeployMaster."' , '".
              $ReceiveDeploymentMail."' , '".
              $DeployAllDone."' , ".
              $RegressionTestResult." , '".
              $RegressionTestNote."' , ".
              $SQLCommandTestResult." , '".
              $SQLCommandTestNote."' , ".
              $ConnectionTestResult." , '".
              $ConnectionTestNote."' , '".
              $OtherCauseNote."' , '".
              $PackageVersion."' , ".
              '1);';
    } else {
        $insert_DeploymentRecord = '
              INSERT INTO ' .$DeploymentRecordTbl."
              (RecordId, DeploymentDate, Cycle, ReleaseStatus, LiveRollBack, DeploymentNote, SendDeploymentMail, InfraDeployMaster, ReceiveDeploymentMail, DeployAllDone, RegressionTestResult, RegressionTestNote, OtherCauseNote, PackageVersion, rec_status)
              VALUES(
              NULL,'" .
              $DeploymentDate."' , '".
              $Cycle."' , ".
              $ReleaseStatus.' , '.
              $LiveRollBack." , '".
              $DeploymentNote."' , '".
              $SendDeploymentMail."' , '".
              $InfraDeployMaster."' , '".
              $ReceiveDeploymentMail."' , '".
              $DeployAllDone."' , ".
              $RegressionTestResult." , '".
              $RegressionTestNote."' , '".
              $OtherCauseNote."' , '".
              $PackageVersion."' , ".
              '1);';
    }
    $RecordId = insert($insert_DeploymentRecord);
} elseif ($type == 'deleterow') {
    $RecordId = $_POST['RecordId'];
    $deleterow_DeploymentRecord = 'DELETE from '.$DeploymentRecordTbl.' where RecordId = '.$RecordId.';';
    delete($deleterow_DeploymentRecord);

    $delete_failReasons = 'DELETE from '.$RegressionFailReasonRecordTbl.' where RecordId = '.$RecordId.';';
    delete($delete_failReasons);

    $delete_delayTeams = 'DELETE from '.$DelayReasonRecordTbl.' where RecordId = '.$RecordId.';';
    delete($delete_delayTeams);

    $delete_OtherCauses = 'DELETE from '.$OtherCauseRecordTbl.' where RecordId = '.$RecordId.';';
    delete($delete_OtherCauses);
}

if ($RegressionTestResult == 2) {
    foreach ($failReasons as $failReason) {
        $insert_RegressionFailReasonRecord = '
    INSERT INTO ' .$RegressionFailReasonRecordTbl.'
    (RecordId, ReasonId)
    VALUES('.$RecordId.','.$failReason.');';
        $failRecordId = insert($insert_RegressionFailReasonRecord);
    }
}

foreach ($delayTeams as $delayTeam) {
    $delayElementName = $delayTeam.'_delaycause';
    $delayCauses = $_POST[$delayElementName];
    foreach ($delayCauses as $delayCause) {
        $insert_DelayReasonRecord = '
    INSERT INTO ' .$DelayReasonRecordTbl.'
    (RecordId, TeamId, ReasonId)
    VALUES('.$RecordId.', '.$delayTeam.', '.$delayCause.');';
        $delayRecordId = insert($insert_DelayReasonRecord);
    }

    $otherElementName = $delayTeam.'_Other_Input';
    $OtherCauseText = htmlspecialchars($_POST[$otherElementName], ENT_QUOTES);
    if ($OtherCauseText) {
        $insert_OtherCauseRecord = '
    INSERT INTO ' .$OtherCauseRecordTbl.'
    (RecordId, TeamId, OtherCauseText)
    VALUES('.$RecordId.','.$delayTeam.",'".$OtherCauseText."');
    ";
        $otherRecordId = insert($insert_OtherCauseRecord);
    }
}
