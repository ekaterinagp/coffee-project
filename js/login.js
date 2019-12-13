if(document.referrer.indexOf("cart")!=-1){
    console.log("from cart")
    responseClass="fail";
    text = "You have to be logged in to make a purchase";
    showNotification(text, responseClass)
  }

function doLogin(){
    let loginInput = document.querySelector("[name=inputEmail]").value;
    let loginPassword = document.querySelector("[name=password]").value;
    let formData = new FormData();
    formData.append("inputEmail", loginInput);
    formData.append("password", loginPassword);
    let endpoint = "api/api-login.php";
    fetch(endpoint, {
      method: "POST",
      body: formData
    })
      .then(res => res.text())
      .then(response => {
        console.log(response);
        if (response == 1) {
          if(document.referrer.indexOf("cart")!=-1){
            location.href = "cart";
          }else{
            location.href = "profile";
          }
        }
        if (response == 0) {
          document.querySelector("#emailDiv").textContent =
            "Password doesn't match username / user email";
          document.querySelector("#emailDiv").style.maxHeight = "500px";
        }
      });
  };   