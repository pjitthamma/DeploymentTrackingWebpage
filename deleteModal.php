<script src="js/project.js"></script>
<script>
function postDelete() {
  $.ajax({
    type: 'post',
    url: '<?php echo $formpost; ?>',
    data: $('form').serialize(),
    success: function () {
    }
  });
  //$('#editModal').modal('hide');
  //window.location = "<?php header("Refresh:3; url=$endtarget"); ?>";
  window.location = "<?php echo $endtarget; 
                            header("refresh: 0;"); ?>";
}
</script>
<!-- Modal -->
<div class="modal-dialog modal-lg">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title"><?php echo $header; ?></h4>
    </div>

    <div class="modal-body">
	<form role="form" id="myForm" action=editRecord_bf.php method="post">
          <input type=hidden name="RecordId" value="<?php echo $RecordId; ?>"></input>
          <div class="tab-content">
            <div class="tab-pane active" role="tabpanel">
				<h4>Are you sure to delete this record?</h4>
					<ul class="list-inline pull-right">
                      <li><button type="button" class="btn btn-default" data-dismiss="modal">Cancle</button></li>
                      <li><button type="button" onclick="postDelete();" data-dismiss="modal" class="btn btn-primary btn-info-full next-step">Delete</button></li>
                    </ul>
                  </div>
                  </div>
                </form>
                <div class="clearfix"></div>
			</form>
            </div>
      </div>
    </div>
  </div>
</div>
