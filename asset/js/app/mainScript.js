var guestName = "";

function showAlert(title, message)
{
  $("#alert .modal-title").html(title);
  $("#alert .modal-body").html(message);
  $("#alert").modal("show");
}

$(document).ready(function ()
{
  var regName = /^[a-zA-Z ]{1,30}$/;
  $("#buttonGo").click(function ()
  {
    var guestName = $("#inputGuestName").val();
    if (!regName.test(guestName))
    {
      showAlert("<span class=\"text-danger\"><i class=\"fas fa-exclamation-triangle\"></i> Alert</span>", "<b class=\"text-danger\">Invalid name</b>. Please check again.");
    }
    else
    {
      alert("Dung");
    }
  });
});
