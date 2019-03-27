window.onload = function ()
{
  var href = location.href.substr((location.href.lastIndexOf("/") + 1));
  if (href != "home") location.href = "./index.html";
  sessionStorage.setItem('location', '');
}

function activeLink(link)
{
  $(".nav-item").not(link).removeClass("active");
  $(link).addClass("active");
}

$(".nav-link").click(function ()
{
  activeLink("." + $(this).parent().attr("class").replace("nav-item ", ""));
  if ($(this).text() == "Home")
    $("#pageName").html("<h2 class=\"text-primary\">Traffic</h2>");
  else $("#pageName").html("<h2 class=\"text-primary\">" + $(this).text() + "</h2>");
});

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
  $("#map").css("min-height", $(window).innerHeight() - $("#loadContent").offset().top - 170);
});

$(".navbar-brand").click(function ()
{
  location.href = "./index.html";
});

var role = "";
var regName = /^[a-zA-Z ]{1,30}$/;
$("#buttonGo").click(function ()
{
  var guestName = reString($("#inputGuestName").val());
  if (guestName == "")
  {
    $("#inputGuestName").val("").focus();
    showAlert("#alertInputGuestName", "Please type <strong>yourname</strong> to continue.");
  }
  else if (!regName.test(guestName))
  {
    $("#inputGuestName").val("").focus();
    showAlert("#alertInputGuestName", "Sorry, yourname is <strong>invalid</strong>. Please check again.");
  }
  else
  {
    role = "Guest";
    activeLink(".linkHome");
    $(".textGuestName").text(guestName);
    $("#pageWelcome").fadeOut(function ()
    {
      $("#pageMain").fadeIn();
      $("#dropdownGuest").fadeIn();
    });
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
if (views == null || views == "" || localStorage.views == undefined)
{
  localStorage.setItem("views", Math.floor((Math.random() * 1000000) + 100000));
  $("#widgetViews").html(localStorage.getItem("views") + " <small>visited</small>");
}
else
{
  localStorage.setItem("views", ++views);
  $("#widgetViews").html(views + " <small>visited</small>");
}

$("#widgetOnline").html(Math.floor((Math.random() * 10000) + 10000) + " <small>online</small>");

//--------------------------------------
$("#inputUsername").keyup(function (event)
{
  if (event.keyCode == 13) $("#buttonSignin").click();
});

$("#inputPassword").keyup(function (event)
{
  if (event.keyCode == 13) $("#buttonSignin").click();
});

var username = "";
var fullname = "";
var birthday = "";
var email = "";
var phone = "";
var address = "";
$("#buttonSignin").click(function ()
{
  var user = getUser($("#inputUsername").val().toLowerCase(), $("#inputPassword").val());
  if (user == undefined)
    showAlert("#alertSignin", "<strong>Login failed!</strong>");
  else
  {
    username = user.username;
    role = user.role;
    fullname = user.fullname;
    birthday = user.birthday;
    email = user.email;
    phone = user.phone;
    address = user.address;
    $("#mainNavbar .navbar-nav .nav-item:nth-child(1)").addClass("active");
    $("#pageWelcome").fadeOut(function ()
    {
      $("#pageMain").fadeIn();

      $(".userUsername").text(username);
      $(".userRole").text(role);
      $(".userFullname").text(fullname);
      $(".userBirthday").text(birthday);
      $(".userEmail").text(email);
      $(".userPhone").text(phone);
      $(".userAddress").text(address);

      $("#dropdownUser").fadeIn();
    });
  }

  $("#inputUsername").val("");
  $("#inputPassword").val("");
});

$("#buttonLogout").click(function ()
{
  location.reload();
});

//----------------------------

//$("#btn-rules").children("a").click(function ()
//{//
//  $("html, body").stop().animate({ scrollTop: $("#ruleContent").offset().top }, 500);
//});

$("#buttonScrollup").click(function ()
{
  $("html, body").stop().animate({ scrollTop: 0 }, 600);
});