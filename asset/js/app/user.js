function data()
{
    return [
        {
            "username": "admin",
            "password": "admin",
            "role": "admin",
            "fullname": "Henry Tran",
            "birthday": "25/08/2010",
            "email": "henry@utp.com",
            "phone": "841562582",
            "address": "WashingTon DC"
        },
        {
            "username": "admin1",
            "password": "admin1",
            "role": "admin1",
            "fullname": "Henry Tran",
            "birthday": "25/08/2010",
            "email": "henry@utp.com",
            "phone": "841562582",
            "address": "WashingTon DC"
        },
        {
            "username": "user1",
            "password": "user1",
            "role": "user",
            "fullname": "Henry Tran",
            "birthday": "25/08/2010",
            "email": "user1@utp.com",
            "phone": "841562582",
            "address": "WashingTon DC"
        }
    ];
}


function getUser(username, password)
{
    var user;
    $(data()).each(function (index, element)
    {
        if (username == element.username && password == element.password)
        {
            user = element;
            return user;
        }
    });
    return user;
}
