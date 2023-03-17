$(document).ready(function () {
  if (localStorage.getItem("redisId")) {
    window.location.replace("http://localhost/guvi/profile.html");
  }
  $("#my-form").submit(function (event) {
    event.preventDefault();
    console.log(formData);
    $.ajax({
      type: "POST",
      url: "http://localhost/guvi/php/login.php",
      data: {
        email: $("#email").val(),
        password: $("#password").val(),
      },

      success: function (res) {
        response = JSON.parse(res);
        if (response.status == "success") {
          localStorage.setItem("redisId", response.session_id);
          if (localStorage.getItem("redisId") != null)
            window.location.replace("http://localhost/guvi/profile.html");
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(errorThrown);
      },
    });
  });
});
