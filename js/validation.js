function checkIfFormValid(idForm) {
  console.log({ idForm });
  let form = document.querySelector(idForm);
  console.log({ form });
  let allInputs = document.querySelectorAll("input");
  allInputs.forEach(input => {
    input.addEventListener("input", function() {
      // console.log(form.checkValidity());
      if (form.checkValidity()) {
        form.querySelector("button").removeAttribute("disabled");
      } else {
        form.querySelector("button").setAttribute("disabled", true);
      }
    });
  });
}
if (document.querySelector("#signupForm")) {
  checkIfFormValid("#signupForm");
}
if (document.querySelector("#loginForm")) {
  checkIfFormValid("#loginForm");
}

function fvIsEmailAvailable(oElement) {
  console.log({ oElement });
  var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  if (re.test(String(oElement.value).toLowerCase())) {
    // oElement.classList.add('error')
    fvGet(
      "api/api-is-user-registered.php?email=" + oElement.value,
      "",
      function(sData) {
        console.log({ sData });
        var jData = JSON.parse(sData);
        console.log({ jData });
        if (jData) {
          // console.log('error')
          document.querySelector("#emailDiv").innerText =
            "email already registered";
          oElement.setCustomValidity("Invalid field.");
          oElement.classList.add("error");
          signUpForm.querySelector("button").setAttribute("disabled", true);
          return;
        }
        // console.log('ok')
        oElement.setCustomValidity("");
        document.querySelector("#emailDiv").innerText =
          "email available for registration";
        oElement.classList.remove("error");
        signUpForm.querySelector("button").removeAttribute("disabled");
      }
    );
  }
  // else {
  //   // not valid email yet
  //   document.querySelector("#emailDiv").innerText = "email";
  //   oElement.classList.remove("error");
  // }
}

function fvGet(sUrl, sHeader, fCallback) {
  var ajax = new XMLHttpRequest();
  ajax.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      fCallback(ajax.responseText);
    } else if (this.readyState == 4 && this.status != 200) {
      // console.log( this.status )
    }
  };
  ajax.open("GET", sUrl, true);
  if (sHeader == "x-partial") {
    ajax.setRequestHeader("X-PARTIAL", "YES");
  }
  ajax.send();
}

const loginBtn = document.querySelector("#loginBtn");
loginBtn.addEventListener("click", () => {
  event.preventDefault();
  let loginInput = document.querySelector("[name=inputEmail]").value;
  let formData = new FormData();
  formData.append("inputEmail", loginInput);
  let endpoint = "api/api-if-email-registered.php?inputEmail=";
  fetch(endpoint + loginInput, {
    method: "POST",
    body: formData
  })
    .then(res => res.text())
    .then(response => {
      console.log(response);
      if (response == 1) {
        location.href = "profile.php";
      }
      if (response == 0) {
        document.querySelector("#emailDiv").textContent =
          "User with this email or user name is not found";
        document.querySelector("#emailDiv").style.maxHeight = "500px";
      }
    });
});
