$(document).ready(function () {
  console.log("Hi");
  $("#my-form").submit(function (event) {
    event.preventDefault();
    let formData = {
      email: $("#email").val(),
      password: $("#password").val(),
    };
    console.log(formData);
    $.ajax({
      type: "POST",
      url: "http://localhost/guvi/php/login.php",
      data: formData,

      success: function (res) {
        res = JSON.parse(res);
        console.log(res);
        if (res.status == "success") {
          window.location.replace("http://localhost/guvi/register.html");
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(errorThrown); // log error message to console
      },
    });
  });
});
