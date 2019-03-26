function check(user,pass){
    $.getJSON('./countries.json', { get_param: 'value' }, function (data) {
      $.each(data, function (index, element) {
         if(element.username==user && element.password==pass){
           return element;
         }
         else{
           return null;
         }
      });
  });
  }