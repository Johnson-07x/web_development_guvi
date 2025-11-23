$(document).ready(() => {
  const token = localStorage.getItem("token");

  $.ajax({
    url: "php/profile.php",
    type: "POST",
    data: JSON.stringify({ action: "get", token }),
    success: function (response) {
      let res = JSON.parse(response);

      if (res.status === "success") {
        $("#username").text(res.data.username);
        $("#age").val(res.data.age);
        $("#dob").val(res.data.dob);
        $("#contact").val(res.data.contact);
      } else {
        alert("Session expired");
        window.location = "login.html";
      }
    },
  });
});

function updateProfile() {
  const token = localStorage.getItem("token");

  $.ajax({
    url: "php/profile.php",
    type: "POST",
    data: JSON.stringify({
      action: "update",
      token,
      age: $("#age").val(),
      dob: $("#dob").val(),
      contact: $("#contact").val(),
    }),
    success: function (response) {
      let res = JSON.parse(response);
      if (res.status === "updated") {
        alert("Profile updated successfully");
      }
    },
  });
}
