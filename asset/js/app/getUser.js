function checkSignin(user, pass)
{
  $.getJSON('../data/user.json', { get_param: 'value' }, function (data)
  {
    $.each(data, function (index, element)
    {
      if (element.username == user && element.password == pass)
         console.log(element.username +  + user)
        return element;
    });
  });
  return null;
}

