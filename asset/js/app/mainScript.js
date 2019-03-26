function showAlert(title, message)
{
  $("#alert .modal-title").html(title);
  $("#alert .modal-body").html(message);
  $("#alert").modal("show");
}

function updateViews()
{
  if ($(window).innerWidth() < 335)
    $("#inputGuestName").removeAttr("placeholder");
  else if ($(window).innerWidth() < 381)
    $("#inputGuestName").attr("placeholder", "Type yourname");
  else $("#inputGuestName").attr("placeholder", "Type yourname here");
}

function reString(str)
{
  return str = str.replace(/ +(?= )/g, "").replace(/\w\S*/g, function (txt)
  {
    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
  }).trim();
}

updateViews();
$(window).resize(function ()
{
  updateViews();
});

var guestName = "";
var regName = /^[a-zA-Z ]{1,30}$/;
$("#buttonGo").click(function ()
{
  guestName = reString($("#inputGuestName").val());
  if (!regName.test(guestName))
    showAlert("<span class=\"text-danger\"><i class=\"fas fa-exclamation-triangle\"></i> Alert</span>", "<b class=\"text-danger\">Invalid name</b>. Please check again.");
  else
  {
    $("#mainNavbar .navbar-nav .nav-item:nth-child(1)").addClass("active");
    $(".textGuestName").text(guestName);
    $("#pageWelcome").fadeOut(function () { $("#pageMain").fadeIn(); });
  }
});
$("#inputGuestName").keyup(function (event)
{
  if (event.keyCode === 13) $("#buttonGo").click();
});

//----------------------------------------

$("#sidebar").mCustomScrollbar({
  theme: "minimal"
});

$("#dismiss, .overlay").on("click", function ()
{
  $("#sidebar").removeClass("active");
  $(".overlay").removeClass("active");
});

$("#buttonSidebar").click(function ()
{
  $("#sidebar").addClass("active");

  $(".overlay").addClass("active");
  $(".collapse.in").toggleClass("in");
  $("a[aria-expanded=true]").attr("aria-expanded", "false");
});

//----------------------------------------
var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "No", "Dec"];
var days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
function updateDate()
{
  var date = new Date();
  var ampm = date.getHours() < 12 ? "AM" : "PM";
  var hours = date.getHours() == 0 ? 12 : date.getHours() > 12 ? date.getHours() - 12 : date.getHours();
  var minutes = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
  var seconds = date.getSeconds() < 10 ? "0" + date.getSeconds() : date.getSeconds();
  var dayOfWeek = days[date.getDay()];
  var month = months[date.getMonth()];
  var day = date.getDate();
  var year = date.getFullYear();
  $("#widgetDate").text(dayOfWeek + ", " + month + " " + day + ", " + year);
  $("#widgetTime").text(hours + " : " + minutes + " : " + seconds + " " + ampm);
}
updateDate();
window.setInterval(updateDate, 1000);
//-------------------------------------
if (localStorage.getItem("views") != null)
  localStorage.views++;
else localStorage.views = Math.floor((Math.random() * 1000000) + 100000);

$("#widgetViews").html(localStorage.views + " <small>visited</small>");
$("#widgetOnline").html(Math.floor((Math.random() * 10000) + 10000) + " <small>online</small>");

//--------------------------------------
$("#buttonSignin").click(function ()
{
  if (checkSignin($("#inputUsername").val().toLowerCase(), $("#inputPassword").val()) != null)
    alert("dung");
  else alert("sai");
});
