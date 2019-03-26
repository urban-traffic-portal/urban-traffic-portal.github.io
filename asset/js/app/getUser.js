function checkSignin(user, pass)
{
  $.getJSON('../../data/user.json', { get_param: 'value' }, function (data)
  {
    $.each(data, function (index, element)
    {
      if (element.username == user && element.password == pass)
      {
        return element;
      }
      else
      {
        return null;
      }
    });
  });
}

