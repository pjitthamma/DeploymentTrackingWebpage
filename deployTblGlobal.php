<?php
error_reporting(0);
require_once 'db_query.php';
function elapseCal($start, $end)
{
    if (($start != null) && ($end != null)) {
        $to_time = strtotime($end);
        $from_time = strtotime($start);
        $total_min = round(abs($to_time - $from_time) / 60);
        $hour = (int) ($total_min / 60);
        $min = $total_min - (60 * $hour);
        $ElapseTime = $hour.'h '.$min.'m';
    // $ElapseTime = str_pad($hour, 2, "0", STR_PAD_LEFT ) .":" . str_pad($min, 2, "0", STR_PAD_LEFT );
    } else {
        $ElapseTime = null;
    }

    return $ElapseTime;
}

if ($pageType == 'bf') {
    $DeploymentRecordTbl = 'DeploymentRecord_bf';
    $RegressionFailReasonRecordTbl = 'RegressionFailReasonRecord_bf';
    $DelayReasonRecordTbl = 'DelayReasonRecord_bf';
    $OtherCauseRecordTbl = 'OtherCauseRecord_bf';
    $TeamTbl = 'Team_bf';
} elseif ($pageType == 'website') {
    $DeploymentRecordTbl = 'DeploymentRecord';
    $RegressionFailReasonRecordTbl = 'RegressionFailReasonRecord';
    $DelayReasonRecordTbl = 'DelayReasonRecord';
    $OtherCauseRecordTbl = 'OtherCauseRecord';
    $TeamTbl = 'Team';
} elseif ($pageType == 'mmb') {
    $DeploymentRecordTbl = 'DeploymentRecord_mmb';
    $RegressionFailReasonRecordTbl = 'RegressionFailReasonRecord_mmb';
    $DelayReasonRecordTbl = 'DelayReasonRecord_mmb';
    $OtherCauseRecordTbl = 'OtherCauseRecord_mmb';
    $TeamTbl = 'Team_mmb';
}
if ($pageType == 'website') {
    if (($filterStart == null) and ($filterEnd == null)) {
        $results = getArrayResult('SELECT RecordId , DeploymentDate, Cycle ,PackageVersion,  ReleaseStatus, LiveRollBack, DeploymentNote, SendDeploymentMail, InfraDeployMaster, ReceiveDeploymentMail, DeployAllDone, RegressionTestResult, RegressionTestNote,  SQLCommandTestResult, SQLCommandTestNote, ConnectionTestResult, ConnectionTestNote, OtherCauseNote, rec_status
    FROM '.$DeploymentRecordTbl.' where rec_status = 1 order by DeploymentDate DESC, Cycle DESC;');
        $EditMode = true;
    } else {
        $EditMode = false;
        $filterquery = 'SELECT RecordId , DeploymentDate, Cycle,PackageVersion, ReleaseStatus, LiveRollBack, DeploymentNote, SendDeploymentMail, InfraDeployMaster, ReceiveDeploymentMail, DeployAllDone, RegressionTestResult, RegressionTestNote,  SQLCommandTestResult, SQLCommandTestNote, ConnectionTestResult, ConnectionTestNote, OtherCauseNote, rec_status
    FROM '.$DeploymentRecordTbl." where rec_status = 1 and DeploymentDate >= '".$filterStart."' and DeploymentDate <= '".$filterEnd."' order by DeploymentDate DESC, Cycle DESC;";
        $results = getArrayResult($filterquery);
    }
} else {
    if (($filterStart == null) and ($filterEnd == null)) {
        $results = getArrayResult('SELECT RecordId , DeploymentDate, Cycle ,PackageVersion,  ReleaseStatus, LiveRollBack, DeploymentNote, SendDeploymentMail, InfraDeployMaster, ReceiveDeploymentMail, DeployAllDone, RegressionTestResult, RegressionTestNote, OtherCauseNote, rec_status
    FROM '.$DeploymentRecordTbl.' where rec_status = 1 order by DeploymentDate DESC, Cycle DESC;');
        $EditMode = true;
    } else {
        $EditMode = false;
        $filterquery = 'SELECT RecordId , DeploymentDate, Cycle,PackageVersion, ReleaseStatus, LiveRollBack, DeploymentNote, SendDeploymentMail, InfraDeployMaster, ReceiveDeploymentMail, DeployAllDone, RegressionTestResult, RegressionTestNote, OtherCauseNote, rec_status
    FROM '.$DeploymentRecordTbl." where rec_status = 1 and DeploymentDate >= '".$filterStart."' and DeploymentDate <= '".$filterEnd."' order by DeploymentDate DESC, Cycle DESC;";
        $results = getArrayResult($filterquery);
    }
}

  $TeamNameArray = getArrayResult('SELECT TeamId , TeamName from '.$TeamTbl.' order by TeamId ASC;');
  $DelayReasonArray = getSingleColumnArray('SELECT Reason from DelayReason order by ReasonId ASC;', 'Reason');
  $RegressionFailArray = getSingleColumnArray('SELECT Reason, rec_status FROM RegressionFailReason order by ReasonId ASC;', 'Reason');

  $new_results = array();
  foreach ($results as $row) {
      $ReleaseStatus = $row['ReleaseStatus'];
      $LiveRollBack = $row['LiveRollBack'];
      $RegressionTestResult = $row['RegressionTestResult'];
      $SQLCommandTestResult = $row['SQLCommandTestResult'];
      $ConnectionTestResult = $row['ConnectionTestResult'];
      $DeploymentDate = $row['DeploymentDate'];
      $Cycle = $row['Cycle'];
      $PackageVersion = $row['PackageVersion'];
      $SendDeploymentMail = $row['SendDeploymentMail'];
      $InfraDeployMaster = $row['InfraDeployMaster'];
      $ReceiveDeploymentMail = $row['ReceiveDeploymentMail'];
      $DeployAllDone = $row['DeployAllDone'];
      switch ($ReleaseStatus) {
      case 2:
      $row['ReleaseStatus'] = '<span class="label label-danger">Fail</span>';
      break;
      case 1:
      $row['ReleaseStatus'] = '<span class="label label-success">Success</span>';
      break;
      default:
      $row['ReleaseStatus'] = '<span class="label label-default">N/A</span>';
    }
      switch ($LiveRollBack) {
      case 2:
      $row['LiveRollBack'] = '<span class="label label-danger">Rollback</span>';
      break;
      case 1:
      $row['LiveRollBack'] = '<span class="label label-success">none</span>';
      break;
      default:
      $row['LiveRollBack'] = '<span class="label label-default">N/A</span>';
    }
      switch ($RegressionTestResult) {
      case 1:
      $row['RegressionTestResult'] = '<span class="label label-success">Pass</span>';
      break;
      case 2:
      $row['RegressionTestResult'] = '<span class="label label-danger">Fail</span>';
      break;
      default:
      $row['RegressionTestResult'] = '<span class="label label-default">N/A</span>';
    }
      switch ($SQLCommandTestResult) {
      case 1:
      $row['SQLCommandTestResult'] = '<span class="label label-success">Pass</span>';
      break;
      case 2:
      $row['SQLCommandTestResult'] = '<span class="label label-danger">Fail</span>';
      break;
      default:
      $row['SQLCommandTestResult'] = '<span class="label label-default">N/A</span>';
    }
      switch ($ConnectionTestResult) {
      case 1:
      $row['ConnectionTestResult'] = '<span class="label label-success">Pass</span>';
      break;
      case 2:
      $row['ConnectionTestResult'] = '<span class="label label-danger">Fail</span>';
      break;
      default:
      $row['ConnectionTestResult'] = '<span class="label label-default">N/A</span>';
    }
      if ($DeploymentDate != null || $DeploymentDate != '') {
          $row['DeploymentDate'] = date('j M Y', strtotime($DeploymentDate));
      }
      $DeploymentTimeObj = strtotime($DeploymentDate);

      if ($SendDeploymentMail != null || $SendDeploymentMail != '') {
          $SendDeploymentMailTimeObj = strtotime(explode(' ', $SendDeploymentMail)[0]);
          if ($SendDeploymentMailTimeObj == $DeploymentTimeObj) {
              $row['SendDeploymentMail'] = date('H:i', strtotime($SendDeploymentMail));
          }
      }
      if ($InfraDeployMaster != null || $InfraDeployMaster != '') {
          $InfraDeployMasterDate = strtotime(explode(' ', $InfraDeployMaster)[0]);
          if ($InfraDeployMasterDate == $DeploymentTimeObj) {
              $row['InfraDeployMaster'] = date('H:i', strtotime($InfraDeployMaster));
          }
      }
      if ($ReceiveDeploymentMail != null || $ReceiveDeploymentMail != '') {
          $ReceiveDeploymentMailDate = strtotime(explode(' ', $ReceiveDeploymentMail)[0]);
          if ($ReceiveDeploymentMailDate == $DeploymentTimeObj) {
              $row['ReceiveDeploymentMail'] = date('H:i', strtotime($ReceiveDeploymentMail));
          }
      }
      if ($DeployAllDone != null || $DeployAllDone != '') {
          $DeployAllDoneDate = strtotime(explode(' ', $DeployAllDone)[0]);
          if ($DeployAllDoneDate == $DeploymentTimeObj) {
              $row['DeployAllDone'] = date('H:i', strtotime($DeployAllDone));
          }
      }

      array_push($new_results, $row);
  }
  // print_r($new_results);
  $keys = array_keys($new_results[0]);
  $newkeys = array();
  $selectedColKeys = array();
  foreach ($keys as $key) {
      switch ($key) {
      case 'RecordId':
      array_push($selectedColKeys, $key);
      array_push($newkeys, '#');
      break;
      case 'DeploymentDate':
      array_push($selectedColKeys, $key);
      array_push($newkeys, 'Date');
      break;
      case 'Cycle':
      array_push($selectedColKeys, $key);
      array_push($newkeys, 'Cycle');
      break;
      case 'PackageVersion':
      array_push($selectedColKeys, $key);
      array_push($newkeys, 'Package Version');
      break;
      case 'ReleaseStatus':
      array_push($selectedColKeys, $key);
      array_push($newkeys, 'All cluster Success?');
      break;
      case 'LiveRollBack':
      array_push($selectedColKeys, $key);
      array_push($newkeys, 'Live Rollback?');
      break;
      case 'DeploymentNote':
      // array_push($selectedColKeys ,$key);
      // array_push($newkeys ,"Deployment Note");
      break;
      case 'SendDeploymentMail':
      array_push($selectedColKeys, $key);
      array_push($newkeys, 'Dictator mail sent');
      break;
      case 'InfraDeployMaster':
      array_push($selectedColKeys, $key);
      array_push($newkeys, 'Started Deploy (Infra)');
      break;
      case 'ReceiveDeploymentMail':
      array_push($selectedColKeys, $key);
      array_push($newkeys, 'Ended (Live 1 cluster)');
      break;
      case 'DeployAllDone':
      array_push($selectedColKeys, $key);
      array_push($newkeys, 'Ended (All clusters)');
      array_push($selectedColKeys, 'Elapse');
      array_push($newkeys, 'Elapse Time (hh:mm)');
      break;
      case 'RegressionTestResult':
      array_push($selectedColKeys, $key);
      array_push($newkeys, 'Regression');
      break;
      case 'RegressionTestNote':
      // array_push($selectedColKeys ,$key);
      // array_push($newkeys ,"Test Note");
      break;
      case 'SQLCommandTestResult':
      // Not put in table
      break;
      case 'SQLCommandTestNote':
      // Not put in table
      break;
      case 'ConnectionTestResult':
      // Not put in table
      break;
      case 'ConnectionTestNote':
      // Not put in table
      break;
      case 'OtherCauseNote':
      // array_push($selectedColKeys ,$key);
      // array_push($newkeys ,"Dalay Cause Note");
      break;
      case 'rec_status':
      array_push($selectedColKeys, $key);
      array_push($newkeys, 'rec_status');
      break;
      default:
      array_push($selectedColKeys, $key);
      array_push($newkeys, $key);
    }
  }
  if (count($new_results) > 0) {
      ?>
    <!-- <table class="table table-striped table-condensed"> -->
    <!-- <table class="table table-striped table-bordered"> -->
    <table id="deployTbl" class="table table-striped table-bordered sortable">
      <thead class = "bg-primary">
        <tr>
          <!-- <th>Edit</th> -->
          <?php
          foreach ($newkeys as $key) {
              if ($key != 'rec_status') {
                  ?>
              <th><?php echo $key ?></th><?php

              }
          } ?>
          <!-- <th>Team Cause Delay</th> -->
        <th>Note</th>
        </tr>
      </thead>
     <?php
     $counter = count($results);
      foreach ($new_results as $result) {
          ?>
        <tr class= "pageData">
          <?php
          foreach ($selectedColKeys as $key) {
              if ($key != 'rec_status') {
                  if ($key == 'RecordId') {
                      //echo "<td>" . $result[$key] . "<br>";
                echo '<td>'.$counter--.'<br>';
                      if ($EditMode == true) {
                          ?>
                  <a id="EditRecord" data-toggle="modal" onclick="EditRecord(<?php echo $result[$key]; ?>);" title="Edit this record" class="glyphicon glyphicon-edit"></a>
                  <a id="DeleteRecord" data-toggle="modal" onclick="DeleteRecord(<?php echo $result[$key]; ?>);" title="Delete this record" class="glyphicon glyphicon-remove"></a>
                  <?php

                      } ?>
                </td>
                <?php

                  } elseif ($key == 'Elapse') {
                      echo '<td class="text-nowrap">'.elapseCal($result['SendDeploymentMail'], $result['DeployAllDone']).'</td>';
                  } else {
                      echo '<td class="text-nowrap">'.$result[$key].'</td>';
                  }
              }
          } ?>
            <!-- Team cause delay -->
            <td class="small">
              <?php
              $delay_records = getArrayResult('SELECT TeamId,ReasonId from '.$DelayReasonRecordTbl.' where RecordId = '.$result['RecordId'].';');
          $Other_Reasons = getArrayResult('SELECT TeamId,OtherCauseText from '.$OtherCauseRecordTbl.' where RecordId = '.$result['RecordId'].';');

          if ($result['DeploymentNote'] != '') {
              echo '<b><u>Deployment Note</b></u><br>';
              echo nl2br($result['DeploymentNote']).'<br><br>';
          }

          if (count($delay_records) != 0 || (count($Other_Reasons) != 0)) {
              echo '<u><b>Team cause Delay</b></u><br>';
              foreach ($TeamNameArray as $Team) {
                  $isTeamPrint = false;
                  if (count($delay_records) != 0) {
                      foreach ($delay_records as $records) {
                          if ($Team['TeamId'] == $records['TeamId']) {
                              if (!$isTeamPrint) {
                                  echo '<b>'.$TeamNameArray[$Team['TeamId'] - 1]['TeamName'].'</b><ul>';
                                  $isTeamPrint = true;
                              }
                              echo '<li>'.$DelayReasonArray[$records['ReasonId'] - 1].'</li>';
                          }
                      }
                  }
                  if (count($Other_Reasons) != 0) {
                      foreach ($Other_Reasons as $TeamReason) {
                          if ($Team['TeamId'] == $TeamReason['TeamId']) {
                              if (!$isTeamPrint) {
                                  echo '<b>'.$TeamNameArray[$Team['TeamId'] - 1]['TeamName'].'</b><ul>';
                                  $isTeamPrint = true;
                              }
                              echo '<li>Other:<br>'.nl2br($TeamReason['OtherCauseText']).'</li>';
                          }
                      }
                  }
                  if ($isTeamPrint) {
                      echo '</ul>';
                  }
              } //End TeamGroup
          }
          if ($result['OtherCauseNote'] != '') {
              echo '<p><b><u>Other problem?</b></u><br>';
              echo nl2br($result['OtherCauseNote']).'<br>';
          }
          if ($result['RegressionTestNote'] != '' || (strpos($result['SQLCommandTestResult'], 'N/A') == false && $result['SQLCommandTestNote'] != '') || (strpos($result['ConnectionTestResult'], 'N/A') == false && $result['ConnectionTestNote'] != '')) {
              echo '<p><b><u>Test Note</b></u><br>';
              if ($result['RegressionTestNote'] != '') {
                  echo nl2br($result['RegressionTestNote']).'<br>';
              }
              if (strpos($result['SQLCommandTestResult'], 'N/A') == false && $result['SQLCommandTestNote'] != '') {
                  echo '- Amount of SQLCommand => '.nl2br($result['SQLCommandTestNote']).' '.$result['SQLCommandTestResult'].'<br>';
              }
              if (strpos($result['ConnectionTestResult'], 'N/A') == false && $result['ConnectionTestNote'] != '') {
                  echo '- Amount of Connection => '.nl2br($result['ConnectionTestNote']).' '.$result['ConnectionTestResult'].'<br>';
              }
          }
          $regressionfail_records = getArrayResult('SELECT RecordId, ReasonId FROM '.$RegressionFailReasonRecordTbl.' where RecordId = '.$result['RecordId'].';');
          if (count($regressionfail_records) != 0) {
              echo '<p><b><u>Regression Fail Reason</u></b><ul>';
              foreach ($regressionfail_records as $fail_records) {
                  echo '<li>'.$RegressionFailArray[$fail_records['ReasonId'] - 1].'</li>';
              }
              echo '</ul>';
          } ?>
            </td>
          </tr> <?php

      } // End for each result row?>
      </table> <?php

  }// Endif
    ?>
