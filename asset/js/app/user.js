function data()
{
    return [
        {
            "username": "admin",
            "password": "admin",
            "role": "Admin",
            "fullname": "Thuan Dao",
            "birthday": "18/09/1999",
            "email": "thuan@utp.com",
            "phone": "84 939 908 568",
            "address": "CanTho city"
        },
        {
            "username": "ad2019",
            "password": "admin",
            "role": "Admin",
            "fullname": "Henry Tran",
            "birthday": "25/08/1975",
            "email": "henry@utp.com",
            "phone": "84 1562 582 369",
            "address": "WashingTon DC"
        },
        {
            "username": "user001",
            "password": "user",
            "role": "Verifier",
            "fullname": "Sceret Mark",
            "birthday": "10/06/1995",
            "email": "user001@utp.com",
            "phone": "84 2256 357 951",
            "address": "CanTho city"
        },
        {
            "username": "user002",
            "password": "user",
            "role": "Verifier",
            "fullname": "Hunmer Curt",
            "birthday": "29/12/1990",
            "email": "user002@utp.com",
            "phone": "84 9256 357 956",
            "address": "Tokyo city"
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
