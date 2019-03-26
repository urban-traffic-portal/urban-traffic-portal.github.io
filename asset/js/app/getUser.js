$(document).ready(function () {
    $.getJSON('./asset/data/user.json', { get_param: 'value' }, function (data) {
        $.each(data, function (index, element) {
           console.log(element.username);
        });
    });
});