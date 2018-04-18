<script src="js/project.js"></script>
<script>
function postAdd() {
  $.ajax({
    type: 'post',
    url: '<?php echo $formpost; ?> ',
    data: $('form').serialize(),
    success: function () {
    }
  });
  window.location.reload();
  window.location = "<?php header($endtarget); ?>";
 //window.location = "<?php echo $endtarget; ?>";
}
</script>
<div class="modal-dialog modal-lg">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title"><?php echo $header; ?></h4>
    </div>
    <div class="modal-body">
      <!-- <div class="row"> -->
      <section>
        <div class="wizard">
          <div class="wizard-inner">
            <div class="connecting-line"></div>
            <ul class="nav nav-tabs" role="tablist">

              <li role="presentation" class="active">
                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Deployment">
                  <span class="round-tab">
                    <i class="glyphicon glyphicon-send"></i>
                  </span>
                </a>
              </li>

              <li role="presentation" class="disabled">
                <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Deployment Time">
                  <span class="round-tab">
                    <i class="glyphicon glyphicon-eye-open"></i>
                  </span>
                </a>
              </li>

              <li role="presentation" class="disabled">
                <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Release Fail Reason">
                  <span class="round-tab danger">
                    <i class="glyphicon glyphicon-fire"></i>
                  </span>
                </a>
              </li>

              <li role="presentation" class="disabled">
                <a href="#step4" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                  <span class="round-tab">
                    <i class="glyphicon glyphicon-ok"></i>
                  </span>
                </a>
              </li>
            </ul>
          </div>
        </div>

        <form role="form" id="myForm" method="post">
          <div class="tab-content">
            <div class="tab-pane active" role="tabpanel" id="step1">
              <div class="row">
                <div class="col-xs-12">
                  <div class="col-md-12">
                    <h4 class="page-header">Deployment Cycle</h4>
                    <div class="form-group">
                      <div class="form-group deployment-date">
                        <label class="control-label col-sm-4" for="registration-date">Deployment Date: *</label>
                        <div class="input-group registration-date-time col-sm-3">
                          <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                          <input class="form-control" id="deploy-date" name="DeploymentDate" type="date" required>
                          <span class="input-group-btn">
                            <button class="btn btn-default" type="button" onclick="addNow('deploy')"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> Today</button>
                          </span>
                        </div>
                      </div> <!-- End formgroup Date -->
                      <div class="form-group registration-date">
                        <label class="control-label col-sm-4">Cycle:</label>
                        <div class="input-group registration-date-time col-sm-4">
                          <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-time" aria-hidden="true"></span></span>
                          <input class="form-control" name="CycleTime" id="cycle-time" type="time">
                          <span class="input-group-btn">
                            <button class="btn btn-default" type="button" onclick="addNow('cycle')"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> Now</button>
                          </span>
                        </div>
                      </div> <!-- End formgroup Date -->
                           <div class="form-group">
                        <label class="control-label col-sm-4" for="registration-date">Package Version:</label>
                        <div class="input-group col-sm-7">
                          <input name="PackageVersion"  id="PackageVersion">
                        </div>
                      </div> <!-- End formgroup Date -->
                      <div class="form-group">
                        <label class="control-label col-sm-4">Release Status:</label>
                        <div class="input-group col-sm-4">
                          <div>
                            <label class="radio-inline"><input type="radio" name="ReleaseStatus" value="0"><span class="label label-default">N/A</span></label>
                            <label class="radio-inline"><input type="radio" name="ReleaseStatus" value="1"><span class="label label-success">Success</span></label>
                            <label class="radio-inline"><input type="radio" name="ReleaseStatus" value="2"><span class="label label-danger">Fail</span></label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-4">Live roll back:</label>
                        <div class="input-group col-sm-4">
                          <div>
                            <label class="radio-inline"><input type="radio" name="LiveRollBack" value="0"><span class="label label-default">N/A</span></label>
                            <label class="radio-inline"><input type="radio" name="LiveRollBack" value="1"><span class="label label-success">None</span></label>
                            <label class="radio-inline"><input type="radio" name="LiveRollBack" value="2"><span class="label label-danger">Rollback</span></label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-4" for="registration-date">Deployment Note:</label>
                        <div class="input-group col-sm-7">
                          <textarea name="DeploymentNote" class="form-control" rows="6" id="DeploymentNote" placeholder="Put your Deployment note here"></textarea>
                        </div>
                      </div> <!-- End formgroup Date -->
                    </div> <!-- End form group 1 -->
                  </div>
                </div>
              </div>
              <ul class="list-inline pull-right">
                <li><button type="button" id="toStep2" class="btn btn-primary next-step">Next step</button></li>
              </ul>
            </div>
            <div class="tab-pane" role="tabpanel" id="step2">
              <div class="row">
                <div class="col-xs-12">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="col-md-12">
                          <h4 class="page-header">Deployment Time</h4>
                          <div class="form-group col-sm-9">
                            <div class="form-group registration-date">
                              <label class="control-label col-sm-4">Dictator mail sent:</label>
                              <div class="input-group registration-date-time col-sm-4">
                                <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                                <input class="form-control" name="SendDeploymentMailDate" id="sendmail-date" type="date">
                                <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-time" aria-hidden="true"></span></span>
                                <input class="form-control" name="SendDeploymentMailTime" id="sendmail-time" type="time">
                                <span class="input-group-btn">
                                  <button class="btn btn-default" type="button" onclick="addNow('sendmail')"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> Now</button>
                                </span>
                              </div>
                            </div> <!-- End formgroup Date -->
                            <div class="form-group registration-date">
                              <label class="control-label col-sm-4" for="registration-date">Started Deploy (Infra):</label>
                              <div class="input-group registration-date-time col-sm-3">
                                <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                                <input name="InfraDeployMasterDate" class="form-control" id="start2h-date" type="date">
                                <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-time" aria-hidden="true"></span></span>
                                <input name="InfraDeployMasterTime" class="form-control" id="start2h-time" type="time">
                                <span class="input-group-btn">
                                  <button class="btn btn-default" type="button" onclick="addNow('start2h')"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> Now</button>
                                </span>
                              </div>
                            </div> <!-- End formgroup Date -->
                            <div class="form-group registration-date">
                              <label class="control-label col-sm-5" for="registration-date">Ended (Live 1 cluster):</label>
                              <div class="input-group registration-date-time col-sm-3">
                                <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                                <input class="form-control" name="ReceiveDeploymentMailDate" id="receivemail-date" type="date">
                                <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-time" aria-hidden="true"></span></span>
                                <input class="form-control" name="ReceiveDeploymentMailTime" id="receivemail-time" type="time">
                                <span class="input-group-btn">
                                  <button class="btn btn-default" type="button" onclick="addNow('receivemail')"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> Now</button>
                                </span>
                              </div>
                            </div> <!-- End formgroup Date -->
                            <div class="form-group registration-date">
                              <label class="control-label col-sm-5" for="registration-date">Ended (All clusters):</label>
                              <div class="input-group registration-date-time col-sm-3">
                                <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                                <input class="form-control" name="DeployAllDoneDate" id="deployall-date" type="date">
                                <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-time" aria-hidden="true"></span></span>
                                <input class="form-control" name="DeployAllDoneTime" id="deployall-time" type="time">
                                <span class="input-group-btn">
                                  <button class="btn btn-default" type="button" onclick="addNow('deployall')"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> Now</button>
                                </span>
                              </div>
                            </div> <!-- End formgroup Date -->
                          </div>
                        </div>
                      </div>
                    </div> <!-- End Row -->
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="col-md-12">
                          <h4 class="page-header">Regression Test</h4>
                          <div class="form-group col-sm-12">
                            <div class="form-group registration-date">
                              <label class="control-label col-sm-4">Test Result:</label>
                              <div class="input-group registration-date-time col-sm-5">
                                <div role="group">
                                  <form>
                                  <label class="radio-inline"><input type="radio" name="RegressionTestResult" onclick="setHide('RegressionFailReason')" value="0" checked /><span class="label label-default">N/A</span></label>
                                  <label class="radio-inline"><input type="radio" name="RegressionTestResult" onclick="setHide('RegressionFailReason')" value="1" /><span class="label label-success">Pass</span></label>
                                  <label class="radio-inline"><input type="radio" name="RegressionTestResult" onclick="setShow('RegressionFailReason')" value="2" /><span class="label label-danger">Fail</span></label>
                                </form>
                                </div>
                              </div>
                            </div>
                            <?php
                            if ($pageType == 'website') {
                                ?>
                            <div class="form-group SQL">
                              <label class="control-label col-sm-4">Amount of SQLCommand:</label>
                              <div class="input-group SQL col-sm-7" >
                                <div role="group">
                                  <form>
                                  <label class="radio-inline"><input type="radio" name="SQLCommandTestResult" onclick="setHide('SQLCommandTestNote')" value="0" checked /><span class="label label-default">N/A</span></label>
                                  <label class="radio-inline"><input type="radio" name="SQLCommandTestResult" onclick="setShow('SQLCommandTestNote')" value="1" /><span class="label label-success">Pass</span></label>
                                  <label class="radio-inline"><input type="radio" name="SQLCommandTestResult" onclick="setShow('SQLCommandTestNote')" value="2" /><span class="label label-danger">Fail</span></label>
                                  <label class="radio-inline"><input class="col-sm-4 input-sm" id="SQLCommandTestNote" type="text" name="SQLCommandTestNote" value="" style="display:none" /><label>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <div class="form-group Connection">
                              <label class="control-label col-sm-4">Amount of Connection:</label>
                              <div class="input-group Connection col-sm-8" >
                                <div role="group">
                                  <form>
                                  <label class="radio-inline"><input type="radio" name="ConnectionTestResult" onclick="setHide('ConnectionTestNote')" value="0" checked /><span class="label label-default">N/A</span></label>
                                  <label class="radio-inline"><input type="radio" name="ConnectionTestResult" onclick="setShow('ConnectionTestNote')" value="1" /><span class="label label-success">Pass</span></label>
                                  <label class="radio-inline"><input type="radio" name="ConnectionTestResult" onclick="setShow('ConnectionTestNote')" value="2" /><span class="label label-danger">Fail</span></label>
                                  <label class="radio-inline"><input class="col-sm-4 input-sm" id="ConnectionTestNote" type="text" name="ConnectionTestNote" value="" style="display:none" /><label>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <?php

                            }
                            ?>
                            <div class="form-group registration-date" id="RegressionFailReason" style="display:none">
                              <label class="control-label col-sm-4" >Fail Reason:</label>
                              <div class="input-group col-sm-4">
                                <div>
                                  <?php
                                  foreach ($failreasons as $failreason) {
                                      ?>
                                    <input name="failReason[]" type="checkbox" value="<?php echo $failreason['ReasonId']; ?>"> <?php echo $failreason['Reason']; ?></input><p>
                                      <?php

                                  }
                                    ?>
                                  </div>
                                </div>
                              </div> <!-- End formgroup Date -->
                              <div class="form-group registration-date">
                                <label class="control-label col-sm-4">Test Note:</label>
                                <div class="input-group col-sm-7">
                                  <textarea name="RegressionTestNote" class="form-control" rows="6" id="regressionNote" placeholder="Put your test note here"></textarea>
                                </div>
                              </div> <!-- End formgroup Date -->
                            </div> <!-- End Big Form Group -->
                          </div>
                        </div>
                      </div> <!-- End Row -->
                    </div>
                  </div>
                </div>
                <ul class="list-inline pull-right">
                  <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                  <li><button type="button" class="btn btn-default next-step">Skip</button></li>
                  <li><button type="button" class="btn btn-primary next-step">Next step</button></li>
                  <!-- <li><button type="submit" class="btn btn-primary btn-info-full next-step">Save and continue</button></li> -->
                </ul>
              </div>
              <div class="tab-pane" role="tabpanel" id="step3">
                <div class="row">
                  <div class="col-xs-12">
                    <div class="col-md-12">
                      <h4 class="page-header">Release Fail Reason</h4>
                      <h5>Note : Can leave this form blank if there is no issue during deployment.</h5>
                      <p>
                        <div class="form-group col-sm-12">
                          <div class="form-group">
                            <label class="control-label col-sm-4">Team cause a delay:</label>
                            <!-- Start Button Group Section -->
                            <div class="input-group col-sm-5 btn-group" data-toggle="buttons">
                              <?php
                              foreach ($teamnames as $team) {
                                  ?>
                                <div onclick="toggleDisplayElement('<?php echo $team['TeamId']; ?>_reasonForm')">
                                  <label class="btn btn-danger">
                                    <input name="delayTeam[]" type="checkbox" value="<?php echo $team['TeamId']; ?>"> <?php echo $team['TeamName']; ?>
                                  </label>
                                </div>
                                <div class="form-group col-sm-12" id="<?php echo $team['TeamId']; ?>_reasonForm" style="display:none">
                                  <label class="control-label col-sm-3">Reason:</label>
                                  <div class="input-group">
                                    <?php
                                    foreach ($reasons as $reason) {
                                        ?>
                                      <div class="checkbox">
                                        <label><input name="<?php echo $team['TeamId']; ?>_delaycause[]" type="checkbox" value="<?php echo $reason['ReasonId']; ?>"><?php echo $reason['Reason']; ?></label>
                                      </div>
                                      <?php

                                    } ?>
                                      <div class="checkbox">
                                        <label><input id="<?php echo $team['TeamId']; ?>_delay_OtherReason" type="checkbox" value="true" onclick="toggleOtherReason('<?php echo $team['TeamId']; ?>_Other_Input','textarea' , '<?php echo $team['TeamId']; ?>_other_reason')">Other</label>
                                        <div class="input-group col-sm-7" id="<?php echo $team['TeamId']; ?>_other_reason">
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <?php

                              }
                                ?>
                              </div> <!-- End Button Group -->
                            </div> <!-- End formgroup -->
                            <div class="form-group registration-date">
                              <label class="control-label col-sm-4" for="OtherCauseNote">Other Reason:</label>
                              <div class="input-group col-sm-7">
                                <textarea name="OtherCauseNote" class="form-control" rows="6"></textarea>
                              </div>
                            </div> <!-- End formgroup Date -->
                          </div> <!-- End form group 1 -->
                        </div>
                      </div>
                    </div>
                    <ul class="list-inline pull-right">
                      <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                      <li><button type="button" class="btn btn-primary btn-info-full next-step" onclick="postAdd();">Save and continue</button></li>
                    </ul>
                  </div>
                </form>
                <!--<div class="tab-pane" role="tabpanel" id="complete">
                  <h3>Complete</h3>
                  <p>You have successfully completed all steps.</p>
                  <div class="row">
                    <div class="col-xs-12">
                      <div class="col-md-12">
                        DONE
                      </div>
                    </div>
                  </div> <!--end row-->
               <!-- </div>-->
                <div class="clearfix"></div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
