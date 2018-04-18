<?php
error_reporting(0);
require_once "db_query.php";
// Count from Monday - Friday
$StartDate = getArrayResult("SELECT DeploymentDate from DeploymentRecord_mmb order by RecordId ASC LIMIT 1;")[0]["DeploymentDate"];
$EndDate = getArrayResult("SELECT DeploymentDate from DeploymentRecord_mmb order by RecordId DESC LIMIT 1;")[0]["DeploymentDate"];
$weekCount = 1;

$CurrentDate = date('Y-m-d',strtotime($StartDate));
// $weekMonday = date('Y-m-d',strtotime($CurrentDate . "last Monday"));
$weekMonday = $CurrentDate;
$weekFriday = date('Y-m-d',strtotime($weekMonday . "Friday"));

$mainTable = array();
$dataSource = array();

while (strtotime($weekMonday) <= strtotime("today")) {
  $mainTableSrc = "";
  if ((date('M' , strtotime($weekMonday))) != (date('M' , strtotime($weekFriday)))) {
    $Week = date('j M',strtotime($weekMonday)) . " - " . date('j M', strtotime($weekFriday));
  } else {
    $Week = (date('j',strtotime($weekMonday))) . " - " .  (date('j M',strtotime($weekFriday)));
  }
  $query = "SELECT count(*) as times from DeploymentRecord_mmb where DeploymentDate >= '".$weekMonday."' and DeploymentDate <= '".$weekFriday."' and ReleaseStatus = 2;";
  $FailedRelease = getArrayResult($query)[0]["times"];

  $query = "SELECT count(*) as times from DeploymentRecord_mmb where DeploymentDate >= '".$weekMonday."' and DeploymentDate <= '".$weekFriday."' and ReleaseStatus = 1;";
  $SuccessRelease = getArrayResult($query)[0]["times"];

  $query = "SELECT count(*) as times from DeploymentRecord_mmb where DeploymentDate >= '".$weekMonday."' and DeploymentDate <= '".$weekFriday."' and LiveRollBack = 2;";
  $Rollback = getArrayResult($query)[0]["times"];

  $query = "SELECT count(*) as times from DeploymentRecord_mmb where DeploymentDate >= '".$weekMonday."' and DeploymentDate <= '".$weekFriday."' and ReleaseStatus != 0;";
  $Total = getArrayResult($query)[0]["times"];

  if ($Total != 0) {
    $SuccessRatio = number_format((float)($SuccessRelease/$Total*100),'2','.','');
  } else {
    $SuccessRatio = 0;
  }

  if ($Total == 0) {
    $indicator = "";
  } else if ($SuccessRatio <= 50) {
    $indicator = "danger";
  } else if ($SuccessRatio <= 75) {
    $indicator = "warning";
  } else {
    $indicator = "success";
  }

  /** Write Table **/
  array_push($dataSource,
  array(
    'weekCount' => $weekCount,
    'Week' => $Week,
    'FailedRelease' => $FailedRelease,
    'SuccessRelease' => $SuccessRelease,
    'Rollback' => $Rollback,
    'Total' => $Total,
    'SuccessRatio' => $SuccessRatio
  )
);

$filterStart = $weekMonday;
$filterEnd = $weekFriday;

$mainTableSrc .= "<tr class = '" . $indicator . " pageData2'>";
$mainTableSrc .= "<td>" . $weekCount . "</td>";
$mainTableSrc .= "<td>" . $Week . "</td>";
$mainTableSrc .= "<td>" . $FailedRelease . "</td>";
$mainTableSrc .= "<td>" . $SuccessRelease . "</td>";
$mainTableSrc .= "<td>" . $Total . "</td>";
$mainTableSrc .= "<td>" . $SuccessRatio . " %</td>";
$mainTableSrc .= "</tr>";

array_push($mainTable, $mainTableSrc);
$weekMonday = date('Y-m-d',strtotime($weekMonday . "next Monday"));
$weekFriday = date('Y-m-d',strtotime($weekFriday . "next Friday"));
$weekCount += 1;

}//end while

$reverse_table = array_reverse($mainTable);
$lastIndex = count($dataSource) - 1;
$linechart_data = "";
//$startWeek = $weekCount - 20;
foreach(array_reverse($dataSource) as $data){
  //if($data["weekCount"] >= $startWeek){
  $linechart_data .= "['W" . $data["weekCount"] ."' , " . $data["SuccessRatio"] . " , '" . $data["SuccessRatio"] ."%'] ,";
//}
}
// echo $linechart_data;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Agoda Deployment Tracking</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/project.css">
  <link rel="stylesheet" href="css/bootstrap-toggle.min.css" >
  <link rel="stylesheet" href="css/filtergrid.css">
  <link rel="stylesheet" href="css/simplePagination.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/project.js"></script>
  <script src="js/moment-with-locales.js"></script>
  <script src="js/moment-timezone-with-data.js"></script>
  <script src="js/bootstrap-toggle.min.js"></script>
  <script src="js/sorttable.js"></script>
  <script src="js/jquery.simplePagination.js"></script>
  <script src="js/tablefilter_all_min.js"></script>
  <script src="js/tableExport.js"></script>
  <script src="js/jquery.base64.js"></script>
  
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <script type="text/javascript">
  google.load('visualization', '1', {packages: ['corechart', 'line'] });
  google.setOnLoadCallback(drawLineChart);

  function drawLineChart() {

    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Week');
    data.addColumn('number', '% Success');
    data.addColumn({type:'string', role:'annotation'});

    data.addRows([
      <?php
      echo $linechart_data;
      ?>
    ]);

    var options = {
      title: 'My.agoda Deployment Success Ratio',
      bar: {groupWidth: 20},
      legend: {
        position: 'none'
      },
      titleTextStyle : {
        fontName: 'Helvetica',
        fontSize: 20,
        bold: true,
        italic: false,
        opacity: 1.0,
        color: '#337ab7',
      } ,
      titlePosition: 'out',
      subtitle: 'Data from <?php echo "W".$dataSource[0]["weekCount"]." " . $dataSource[0]["Week"] ." to W".$dataSource[$lastIndex]["weekCount"]. " " . $dataSource[$lastIndex]["Week"];?>',
      hAxis: {
        title: 'Week',
        slantedText: false,
        slantedTextAngle : 60,
        maxAlternation : 5,
        titleTextStyle: {
          color: '#337ab7',
          fontName: 'Helvetica',
          fontSize: 16,
          bold: false,
          italic: true
        }
      },
      vAxis: {
        title: '% Success ratio',
        titleTextStyle: {
          color: '#337ab7',
          fontName: 'Helvetica',
          fontSize: 16,
          bold: false,
          italic: true
        }
      },
      colors: ['#337ab7'],

      width: 1900,
      height: 300,

      annotations: {
        textStyle: {
          fontName: 'Helvetica',
          fontSize: 10,
          bold: false,
          italic: false,
          opacity: 1.0,
          color: 'black',
        }
      }
    };

    var chart = new google.visualization.LineChart(document.getElementById('linechart'));
    chart.draw(data, options);
  }

      jQuery(function($) {
    var items = $(".pageData2");
    var selector = ".pagination-page";
    var numItems = items.length;
    var perPage = 10;

    items.slice(perPage).hide();

    $(selector).pagination({
      items: numItems, 
      itemsOnPage: perPage,
      cssStyle: "light-theme",
      onPageClick: function(pageNumber) { 
        var showFrom = perPage * (pageNumber - 1);
        var showTo = showFrom + perPage;

        items.hide()
          .slice(showFrom, showTo).show();
        }
    });
  });
  </script>

</head>
<body>
  <?php require "menubar.php"; ?>
  <div class="container" id="center">
    <h2>MMB Deployment Summary : <small><?php echo date("j M Y" ,strtotime("today")); ?></small></h2>
    <div class="row">
    </div>
    <div class="row">
      <div class="col-md-3">
        <div id="success_ratio">
          <table class="table table-condensed table-bordered">
            <thead class="bg-primary">
              <th class="vert-align text-center">THIS WEEK SUCCESS RATIO</th>
            </thead>
            <tr class="bg-<?php echo $indicator; ?>">
              <td class="vert-align text-center">
                <h2><?php echo $dataSource[$lastIndex]["SuccessRatio"]; ?> %</h2>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div class="col-md-6">
      </div>
      <div id = "minitable" class="col-md-3">
        <table class="table table-condensed table-bordered">
          <thead>
            <th class="vert-align text-center bg-primary" colspan="2">W<?php echo $dataSource[$lastIndex]["weekCount"]." ".$dataSource[$lastIndex]["Week"] ?> Data</th>
          </thead>
          <tr class="bg-info">
            <td>FAIL</td>
            <td class="text-center"><?php echo $dataSource[$lastIndex]["FailedRelease"]; ?></td>
          </tr>
          <tr class="bg-info">
            <td>SUCCESS</td>
            <td class="text-center"><?php echo $dataSource[$lastIndex]["SuccessRelease"]; ?></td>
          </tr>
          <tr class="bg-info">
            <td>ROLLBACK</td>
            <td class="text-center"><?php echo $dataSource[$lastIndex]["Rollback"]; ?></td>
          </tr>
        </table>
      </div>
    </div> <!-- End Row -->
    <div id="linechart">
    </div>
    <p>

            <div>

      <div>Export File To: <a data-toggle="modal" class="glyphicon glyphicon-save" title="Save to Excel" onClick ="$('#filterTable').tableExport({type:'excel',escape:'false'});">excel</a>   &nbsp; <a data-toggle="modal" class="glyphicon glyphicon-save" title="Save to CSV" onClick ="$('#filterTable').tableExport({type:'csv',escape:'false'});">csv</a></div>
      <p></p>

    </div>

      <div id="mainTable">
        <table id = 'filterTable' class="table table-bordered table-striped table-hover table-condensed sortable">
          <thead class="bg-primary">
            <th>#</th>
            <th>Week</th>
            <th>Failed Release</th>
            <th>Success Release</th>
            <th>Total</th>
            <th>Success ratio</th>
          </thead>
          <?php
          foreach($reverse_table as $line) {
            echo $line;
          }
          ?>
        </table>
      </div>

      <div class="pagination-page" id="center"> </div>

      <div class="row col-lg-12">
        <h4>This week data:</h4>
        <div>Export File To: <a data-toggle="modal" class="glyphicon glyphicon-save" title="Save to Excel" onClick ="$('#deployTbl').tableExport({type:'excel',escape:'false'});">excel</a>  &nbsp; <a data-toggle="modal" class="glyphicon glyphicon-save" title="Save to CSV" onClick ="$('#deployTbl').tableExport({type:'csv',escape:'false'});">csv</a></div>
      <p></p>
        
        <?php
        $pageType = "mmb";
        include "deployTblGlobal.php";
        ?>
      </div>
    </div>
    <script>
    var table_Props = {
    input_watermark: ['  #', '# MMM - # MMM', '  #', '  #', '  #', '  #.## %'] ,
    };
    var tf = setFilterGrid("filterTable", table_Props);

    var table_Props2 = {
    col_3: "select",
    col_4: "select",
    col_10: "select",
    col_11: "none",
    input_watermark: ['  #', '  dd MM yyy', ' mm:ss', null, null,'  mm:ss', '  mm:ss', '  mm:ss', '  mm:ss', '  #h:##m'] ,
    display_all_text: "...",
    sort_select: true
    };
    var tf = setFilterGrid("deployTbl", table_Props2);
  </script>
    <style>
    .container{
      width: 1500px;
    }
    
    .table>thead>tr>th {
      vertical-align: top;
    }

    #linechart>div>div{
      margin:auto;
    }

      #linechart {
      margin:auto;
      overflow-x: scroll;
      overflow-y: hidden;     
      width: 1000px;
      }
  </style>
  </body>
  </html>
