function submitForm() {
  var name = $("input[name=name]").val();
  var email = $("input[name=email]").val();
  var password = $("input[name=password]").val();
  var mobile = $("input[name=mobile]").val();
  var formData = {
    name: name,
    email: email,
    password: password,
    phone: mobile,
  };
  $.ajax({
    url: "http://localhost/guvi/php/register.php",
    type: "POST",
    data: formData,
    sucess: function (response) {
      console.log(response)
    },
  });
  console.log(formData);
//   alert(name);
}
