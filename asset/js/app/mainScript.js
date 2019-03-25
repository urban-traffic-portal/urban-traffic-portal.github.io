function showAlert(title, message)
{
  $("#alert .modal-title").html(title);
  $("#alert .modal-body").html(message);
  $("#alert").modal("show");
}

var guestName = "";
var regName = /^[a-zA-Z ]{1,30}$/;
$("#buttonGo").click(function ()
{
  guestName = $("#inputGuestName").val();
  if (!regName.test(guestName))
    showAlert("<span class=\"text-danger\"><i class=\"fas fa-exclamation-triangle\"></i> Alert</span>", "<b class=\"text-danger\">Invalid name</b>. Please check again.");
  else
  {
    $(".textGuestName").text(guestName);
    $("#pageWelcome").fadeOut(function () { $("#pageMain").fadeIn(); });
  }
});
$("#inputGuestName").keyup(function (event)
{
  if (event.keyCode === 13) $("#buttonGo").click();
});

