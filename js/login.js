$(document).ready(function () {
//   console.log("Hi");
  $("#my-form").submit(function (event) {
    event.preventDefault();

    let formData = {
      email: $("#email").val(),
      password: $("#password").val(),
    };
    $.ajax({
        type: "POST",
        url: "http://localhost/guvi/php/login.php",
        data: formData,
        
        success: function (response) {
            let res = JSON.parse(response);
            localStorage.setItem("access_token", res.access_token);
            console.log(formData);

        if (res.status == "success") {
          window.location.replace("http://localhost:8000/profile.html");
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        // console.log(errorThrown); // log error message to console
        // console.log("sdf");
      },
    });
  });
});
