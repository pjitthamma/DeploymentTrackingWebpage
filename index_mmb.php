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

  <style>
  /* Sortable tables */
  table.sortable thead {
    background-color:#eee;
    color:#666666;
    font-weight: bold;
    cursor: default;
  }
  .table>thead>tr>th {
    vertical-align: top;
  }
  </style>

  <script>
  
(function()
{
  if( window.localStorage )
  {
    if( !localStorage.getItem( 'firstLoad' ) )
    {
      localStorage[ 'firstLoad' ] = true;
      window.location.reload();
    }  
    else
      localStorage.removeItem( 'firstLoad' );
  }
})();

  function EditRecord(RecordId) {
    $("#editModal").empty();
    var dataString = 'pageType=mmb&RecordId='+ RecordId;
    $.ajax( {
      type: "POST",
      url: "EditRecordFormGlobal.php",
      data: dataString,
      cache: false,
      success: function(result){

        $("#editModal").html(result);
      }
    });
    $("#editModal").modal('show');
  }

  function AddRecord() {
    $("#editModal").empty();
    var dataString = 'pageType=mmb';
    $.ajax( {
      type: "POST",
      url: "AddRecordFormGlobal.php",
      data: dataString,
      cache: false,
      success: function(result){

        $("#editModal").html(result);
      }
    });
    $("#editModal").modal('show');
  }

  function DeleteRecord(RecordId) {
    $("#editModal").empty();
    var dataString = 'pageType=mmb&RecordId='+ RecordId;
    $.ajax( {
      type: "POST",
      url: "DeleteRecordFormGlobal.php",
      data: dataString,
      cache: false,
      success: function(result){

        $("#editModal").html(result);
      }
    });
    $("#editModal").modal('show');
  }

  function setShow(elementId) {
    document.getElementById(elementId).style.display='flex';
  }

  function setHide(elementId) {
    document.getElementById(elementId).style.display='none';
  }

  jQuery(function($) {
    var items = $(".pageData");
    var selector = ".pagination-page";
    var numItems = items.length;
    var perPage = 50;

    items.slice(perPage).hide();

    $(selector).pagination({
      items: numItems,
      itemsOnPage: perPage,
      cssStyle: "light-theme",
      onPageClick: function(pageNumber) { 
        var showFrom = perPage * (pageNumber - 1);
        var showTo = showFrom + perPage;
        $("html, body").animate({ scrollTop: 0 }, "slow");
        items.hide()
          .slice(showFrom, showTo).show();
        }
    });
  });

  </script>
</head>
<body>
  <?php require "menubar.php"; ?>
  <div class="container-fluid">
    <div class="row">
      <div>
        <h1 style="margin-left: 20px">My.agoda - Release Manager Tracking</h1>
      </div>
    </div>
    <div class = "row">
       <div class="col-md-5" >
        <a class="btn btn-success" onclick="AddRecord();"><span class="glyphicon glyphicon-plus"></span> Add Deployment Record</a> &nbsp;
    Export File To: <a data-toggle="modal" class="glyphicon glyphicon-save" title="Save to Excel" onClick ="$('#deployTbl').tableExport({type:'excel',escape:'false'});">excel</a>  &nbsp; <a data-toggle="modal" class="glyphicon glyphicon-save" title="Save to CSV" onClick ="$('#deployTbl').tableExport({type:'csv',escape:'false'});">csv</a></div>
    </div>
    <p>
      <div class="row col-lg-12">
        <?php
        $pageType = "mmb";
        include "deployTblGlobal.php";
        ?>
      </div>
      <div id="modalDiv">
        <div class="modal fade" id="editModal" role="dialog">
        </div>
      </div> <!-- End modal div -->
    </div>

<script>
    var table_Props = {
    col_4: "select",
    col_5: "select",
    col_11: "select",
    col_12: "none",
    input_watermark: ['  #', '  dd MM yyy', ' mm:ss','  #.#', null, null,'  mm:ss', '  mm:ss', '  mm:ss', '  mm:ss', '  #h:##m'] ,
    display_all_text: "...",
    sort_select: true
    };
    var tf = setFilterGrid("deployTbl", table_Props);
</script>
</body>
<footer>
  <div class="pagination-page" id="center"> </div>
</footer>
</html>
