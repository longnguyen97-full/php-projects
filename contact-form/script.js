$(document).ready(function () {
  const form = $("#contact-form");
  const messageResponse = $("#message-response");

  form.submit(function (e) {
    e.preventDefault();
    messageResponse.removeClass("hide");

    // initial variables
    let email = $("#input-email");
    let message = $("#input-message");
    let data = "";
    let delay = 1000;

    // validate data
    if (email.val() !== "" && message.val() !== "") {
      if (validateEmail(email.val())) {
        data = $(form).serialize();
      } else {
        messageResponse.html("Enter a valid email address!");
        return;
      }
    } else {
      messageResponse.html("Email and message fields are required!");
      return;
    }

    $.ajax({
      method: "POST",
      url: "message.php",
      data: data,
    }).done(function (msg) {
      console.log(msg);
      setTimeout(function () {
        messageResponse.html(msg);
      }, delay);
    });
  });

  const validateEmail = (email) => {
    var regex =
      /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return !regex.test(email) ? false : true;
  };
});
