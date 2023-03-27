$(".select2").select2({
  width: "100%",
});
$(document).ready(function () {
  $("#form_access").validate({
    rules: {
      fullname: {
        required: true,
      },
      email: {
        required: true,
      },
      username: {
        required: true,
      },
      password: {
        required: true,
      },
      role: {
        required: true,
      },
    },
    messages: {
      fullname: "Nama lengkap harus diisi.",
      email: "E-mail harus diisi.",
      username: "Username harus diisi.",
      password: "Password harus diisi.",
      role: "Role harus dipilih.",
    },
    errorElement: "small",
    errorPlacement: function (error, element) {
      var placement = $(element).data("error");
      error.insertAfter(element);
    },
    highlight: function (element) {
      //$(element).parent().addClass("text-danger");
    },
    submitHandler: function (form, event) {
      event.preventDefault();
      $.ajax({
        type: "POST",
        url: hostname + "user-access/add-access",
        data: $("#form_access").serialize(),
        success: function (data) {
          Swal.fire({
            icon: "success",
            title: "Berhasil!",
            html: "Menyimpan akses berhasil.",
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.reload();
            }
          });
        },
      });
    },
  });

  $("#form_access_edit").validate({
    rules: {
      fullname: {
        required: true,
      },
      email: {
        required: true,
      },
      username: {
        required: true,
      },
      role: {
        required: true,
      },
    },
    messages: {
      fullname: "Nama lengkap harus diisi.",
      email: "E-mail harus diisi.",
      username: "Username harus diisi.",
      role: "Role harus dipilih.",
    },
    errorElement: "small",
    errorPlacement: function (error, element) {
      var placement = $(element).data("error");
      error.insertAfter(element);
    },
    highlight: function (element) {
      //$(element).parent().addClass("text-danger");
    },
    submitHandler: function (form, event) {
      event.preventDefault();
      $.ajax({
        type: "POST",
        url: hostname + "user-access/update-access",
        data: $("#form_access_edit").serialize(),
        success: function (data) {
          Swal.fire({
            icon: "success",
            title: "Berhasil!",
            html: "Edit akses berhasil.",
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.reload();
            }
          });
        },
      });
    },
  });
});

function selectAll(menu_id) {
  if ($("#menu" + menu_id).is(":checked")) {
    $(".menu" + menu_id).attr("checked", true);
  } else {
    $(".menu" + menu_id).attr("checked", false);
  }
}

$(document).on("change", "#username", function () {
  var username = $(this).val();

  $.ajax({
    type: "POST",
    url: hostname + "user-access/check-account",
    data: { username: username },
    success: function (data) {
      var exist = JSON.parse(data);
      if (exist.status == false) {
        $("#username").focus();
        $("#username").val("");
        $("#username-exist").removeClass("d-none");
      } else {
        $("#username-exist").addClass("d-none");
      }
    },
  });
});

$(document).on("change", "#email", function () {
  var email = $(this).val();

  $.ajax({
    type: "POST",
    url: hostname + "user-access/check-account",
    data: { username: email },
    success: function (data) {
      var exist = JSON.parse(data);
      if (exist.status == false) {
        $("#email").focus();
        $("#email").val("");
        $("#email-exist").removeClass("d-none");
      } else {
        $("#email-exist").addClass("d-none");
      }
    },
  });
});
