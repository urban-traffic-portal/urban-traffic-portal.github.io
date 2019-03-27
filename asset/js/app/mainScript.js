function showModal(title, message)
{
  $("#alert .modal-title").html(title);
  $("#alert .modal-body").html(message);
  $("#alert").modal("show");
}

function showAlert(idAlert, message)
{
  $(idAlert).html(message).fadeIn();
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
  if (guestName == "")
  {
    $("#inputGuestName").val("").focus();
    showAlert("#alertInputGuestName", "Please type yourname to continue.");
  }
  else if (!regName.test(guestName))
  {
    $("#inputGuestName").val("").focus();
    showAlert("#alertInputGuestName", "Sorry, yourname is <strong>invalid</strong>. Please check again.");
  }
  else
  {
    $("#mainNavbar .navbar-nav .nav-item:nth-child(1)").addClass("active");
    $(".textGuestName").text(guestName);
    $("#pageWelcome").fadeOut(function () { $("#pageMain").fadeIn(); });
  }
});
$("#inputGuestName").keyup(function (event)
{
  if (event.keyCode == 13) $("#buttonGo").click();
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
//----------------------------------

var views = localStorage.getItem("views");
if (views == null || views == "")
  localStorage.setItem("views", Math.floor((Math.random() * 1000000) + 100000));
else
  localStorage.setItem("views", ++views);

$("#widgetViews").html(views + " <small>visited</small>");
$("#widgetOnline").html(Math.floor((Math.random() * 10000) + 10000) + " <small>online</small>");

//--------------------------------------
$("#buttonDropdownSignin").click(function () {
  $("#inputUsername").focus();
});

$("#inputUsername").keyup(function (event)
{
  if (event.keyCode == 13) $("#buttonSignin").click();
});

$("#inputPassword").keyup(function (event)
{
  if (event.keyCode == 13) $("#buttonSignin").click();
});

$("#buttonSignin").click(function ()
{
  if (getUser($("#inputUsername").val().toLowerCase(), $("#inputPassword").val()) == undefined)
  {
    showAlert("#alertSignin", "<strong>Login failed!</strong>.");
    $("#buttonDropdownSignin").click();
    $("#buttonDropdownSignin").click();
  }
});
