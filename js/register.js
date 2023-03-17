$(document).ready(function () {
  if (localStorage.getItem("redisId")) {
    window.location.replace("http://localhost/guvi/profile.html");
  }
});
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
    dob:dob,
    age:age,
  };
  console.log(formData);
  $.ajax({
    url: "http://localhost/guvi/php/register.php",
    type: "POST",
    data: formData,
    sucess: function (response) {
      console.log(response);
    },
  });
}
