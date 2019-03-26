function checkSignin(username, password)
{
    alert(username);
    alert(password);
    $.getJSON('./asset/data/user.json', { get_param: 'value' }, function (data)
    {
        $.each(data, function (index, element)
        {
            if (username == element.username && password == element.password)
                return element;
        });
    });
};