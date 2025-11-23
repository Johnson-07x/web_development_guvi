function loginUser() {
  $.ajax({
    url: "php/login.php",
    type: "POST",
    data: JSON.stringify({
      username: $("#username").val(),
      password: $("#password").val(),
    }),
    success: function (response) {
      let res = JSON.parse(response);

      if (res.status === "success") {
        localStorage.setItem("token", res.token);
        window.location = "profile.html";
      } else {
        alert("Invalid login!");
      }
    },
  });
}
