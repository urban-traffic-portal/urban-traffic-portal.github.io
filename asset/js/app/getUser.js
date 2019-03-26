$(document).ready(function () {
    var result = checkSignin("admin","admin");
    console.log(result);
});
function checkSignin(username, password)
{
    var data=getJSON();
    console.log(data);
};
function getJSON(){
    var mydata = [];
    $.getJSON('./asset/data/user.json', { get_param: 'value' }, function (data)
    {
        $.each( data, function( key, val ) {
            mydata.push(val)
          });
    });
    //console.log(mydata);
    return mydata;
}