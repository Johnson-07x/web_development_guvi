function registerUser() {
  $.ajax({
    url: "php/register.php",
    type: "POST",
    data: JSON.stringify({
      username: $("#username").val(),
      password: $("#password").val(),
    }),
    success: function (response) {
      let res = JSON.parse(response);
      if (res.status === "success") {
        alert("Registration successful");
        window.location = "login.html";
      } else {
        alert("Registration failed");
      }
    },
  });
}
