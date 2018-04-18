$(document).ready(function () {

  validate();
  $('[required]').change(validate);

  var navListItems = $('div.setup-panel div a'),
  allWells = $('.setup-content'),
  allNextBtn = $('.nextBtn');

  allWells.hide();

  navListItems.click(function (e) {
    e.preventDefault();
    var $target = $($(this).attr('href')),
    $item = $(this);

    if (!$item.hasClass('disabled')) {
      navListItems.removeClass('btn-primary').addClass('btn-default');
      $item.addClass('btn-primary');
      allWells.hide();
      $target.show();
      $target.find('input:eq(0)').focus();
    }
  });

  allNextBtn.click(function(){
    var curStep = $(this).closest(".setup-content"),
    curStepBtn = curStep.attr("id"),
    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
    curInputs = curStep.find("input[type='text'],input[type='url']"),
    isValid = true;

    $(".form-group").removeClass("has-error");
    for(var i=0; i<curInputs.length; i++){
      if (!curInputs[i].validity.valid){
        isValid = false;
        $(curInputs[i]).closest(".form-group").addClass("has-error");
      }
    }

    if (isValid)
    nextStepWizard.removeAttr('disabled').trigger('click');
  });

  $('div.setup-panel div a.btn-primary').trigger('click');

  // $('#overall_result').on('change',function() {
  //   var toggleOff = $("#overall_result .toggle.btn-danger");
  //   if(toggleOff.length){
  //     document.getElementById("nextStepBtn").href = "#Fail";
  //     document.getElementById("nextStepBtn").text = "Next - Input Release Fail Reason";
  //     document.getElementById("nextStepBtn").style("color:red");
  //   } else {
  //     document.getElementById("nextStepBtn").href = "#Review";
  //     document.getElementById("nextStepBtn").text = "Next - Review and Submit";
  //   }
  // });


  var navListItems = $('div.setup-panel div a'),
  allWells = $('.setup-content'),
  allNextBtn = $('.nextBtn');

  allWells.hide();

  navListItems.click(function (e) {
    e.preventDefault();
    var $target = $($(this).attr('href')),
    $item = $(this);

    if (!$item.hasClass('disabled')) {
      navListItems.removeClass('btn-primary').addClass('btn-default');
      $item.addClass('btn-primary');
      allWells.hide();
      $target.show();
      $target.find('input:eq(0)').focus();
    }
  });

  allNextBtn.click(function(){
    var curStep = $(this).closest(".setup-content"),
    curStepBtn = curStep.attr("id"),
    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
    curInputs = curStep.find("input[type='text'],input[type='url']"),
    isValid = true;

    $(".form-group").removeClass("has-error");
    for(var i=0; i<curInputs.length; i++){
      if (!curInputs[i].validity.valid){
        isValid = false;
        $(curInputs[i]).closest(".form-group").addClass("has-error");
      }
    }

    if (isValid)
    nextStepWizard.removeAttr('disabled').trigger('click');
  });

  $('div.setup-panel div a.btn-primary').trigger('click');

}); // End onload
/** Form Function **/
$(document).ready(function () {
  //Initialize tooltips
  $('.nav-tabs > li a[title]').tooltip();

  //Wizard
  $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

    var $target = $(e.target);

    if ($target.parent().hasClass('disabled')) {
      return false;
    }
  });

  $(".next-step").click(function (e) {

    var $active = $('.wizard .nav-tabs li.active');
    $active.next().removeClass('disabled');
    nextTab($active);

  });
  $(".prev-step").click(function (e) {

    var $active = $('.wizard .nav-tabs li.active');
    prevTab($active);

  });

  $("#submitReview").click(function(){
    var x = $("#myForm").serializeArray();
    $.each(x, function(i, field){
      $("#reviewForm").append(field.name + ":" + field.value + "\n");
    });
  });
});

function nextTab(elem) {
  $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
  $(elem).prev().find('a[data-toggle="tab"]').click();
}
/*** Function List **/
function addNow(id) {
  nowDate = moment().tz("Asia/Bangkok").format('YYYY-MM-DD');
  nowTime = moment().tz("Asia/Bangkok").format('HH:mm');
  var dateElem = $('#' + id + '-date');
  var timeElem = $('#' + id + '-time');
  if (dateElem) {
    dateElem.val(nowDate).change();
  }
  if (timeElem) {
    timeElem.val(nowTime).change();
  }
}

function stopNow() {
  clearTimeout(set);
}

function toggleDisplayElement(elementId) {
  if (document.getElementById(elementId).style.display=='none') {
    document.getElementById(elementId).style.display='flex';
  } else {
    document.getElementById(elementId).style.display='none';
  }
}

function createChildElement (childElementName, childElementType, targetDivId) {
  var newChildElement = document.createElement(childElementType);
  newChildElement.setAttribute("name",childElementName);
  newChildElement.setAttribute("id",childElementName);
  newChildElement.setAttribute("style","display:flex");
  var targetDiv = document.getElementById(targetDivId);
  targetDiv.appendChild(newChildElement);
}

function toggleOtherReason (childElementName, childElementType, targetDivId) {
  if (!document.getElementById(childElementName)) {
    var newChildElement = document.createElement(childElementType);
    newChildElement.setAttribute("name",childElementName);
    newChildElement.setAttribute("id",childElementName);
    newChildElement.setAttribute("rows","5");
    newChildElement.setAttribute("cols","40");
    newChildElement.setAttribute("style","display:flex");
    var targetDiv = document.getElementById(targetDivId);
    targetDiv.appendChild(newChildElement);
  } else {
    document.getElementById(childElementName).remove();
  }
}

function validate(){
  var deployDate = $('#deploy-date');
  if (!(deployDate.val() === undefined || deployDate.val() === null)) {
    if (deployDate.val().length > 0) {
      $("#toStep2").prop("disabled", false);
      // $("#deploy-date").prop("disabled", false);
      $("#toStep2").html("Next step");
    }
    else {
      $("#toStep2").prop("disabled", true);
      $("#toStep2").html("Please input \"Deployment Date\" before next step");
    }
  }
}
