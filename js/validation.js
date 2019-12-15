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
// if (document.querySelector("#signupForm")) {
//   checkIfFormValid("#signupForm");
// }

// if (document.querySelector("#loginForm")) {
//   checkIfFormValid("#loginForm");
//   const loginBtn = document.querySelector("#loginBtn");
// loginBtn.addEventListener("click", () => {
//   event.preventDefault();
//   doLogin();
// });
// }
// console.log(document.referrer)
if(document.referrer.indexOf("cart")!=-1 && window.location.pathname =="/db_exam/log-in"){
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
        console.log("profile")
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

// function fvIsEmailAvailable(oElement) {
//   console.log({ oElement });
//   var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
//   if (re.test(String(oElement.value).toLowerCase())) {
//     console.log(re.test(String(oElement.value).toLowerCase()))
//     // oElement.classList.add('error')
//     fvGet(
//       "api/api-is-user-registered.php?email=" + oElement.value,
//       "",
//       function(sData) {
//         console.log({ sData });
//         var jData = JSON.parse(sData);
//         console.log({ jData });
//         if (jData) {
//           // console.log('error')
//           document.querySelector("#emailDiv").innerText =
//             "email already registered";
//           oElement.setCustomValidity("Invalid field.");
//           oElement.classList.add("error");
//           signUpForm.querySelector("button").setAttribute("disabled", true);
//           return;
//         }
//         // console.log('ok')
//         oElement.setCustomValidity("");
//         document.querySelector("#emailDiv").innerText =
//           "email available for registration";
//         oElement.classList.remove("error");
//         signUpForm.querySelector("button").removeAttribute("disabled");
//       }
//     );
//   }
  // else {
  //   // not valid email yet
  //   document.querySelector("#emailDiv").innerText = "email";
  //   oElement.classList.remove("error");
  // }
// }

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


if (document.querySelectorAll("form")) {
  let forms = document.querySelectorAll("form");
  console.log(forms.length)
  forms.forEach(form=>{
  checkIfFormIsValid(form)
  if(form.id == "loginForm"){
    const loginBtn = document.querySelector("#loginBtn");
    loginBtn.addEventListener("click", () => {
      event.preventDefault();
      doLogin();
    });
  }
})
}


function checkIfFormIsValid(form){
  allInputs = form.querySelectorAll("[data-type]");
  allInputs.forEach(input=>{
    input.addEventListener('input', function(){
      if(checkInputFields(input,form) == true){
        form.querySelector(".formBtn").disabled=false;
      }else{
        form.querySelector(".formBtn").disabled=true;
      }
  });
});
}



function checkInputFields(input,form){
  let sValue = input.value;
  let sDataType = input.getAttribute("data-type")
  let iMin = input.getAttribute('data-min') 
  let iMax = input.getAttribute('data-max')
  console.log()
  switch(sDataType){
    case 'string':
      if( sValue.length < iMin || sValue.length > iMax ){ 
        input.classList.add('error')
        input.classList.remove('valid')
      }else{
        input.classList.add('valid');
        input.classList.remove('error');
      }   
    break
    case 'integer':
      if( !parseInt(sValue) || parseInt(sValue) < parseInt(iMin) || parseInt(sValue) > parseInt(iMax) ){ 
        input.classList.add('error')
        input.classList.remove('valid')
      }else{
        input.classList.add('valid');
        input.classList.remove('error');
      }   
    break
    case 'email':
      const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      if( re.test(String(sValue).toLowerCase()) == false ){ 
        input.classList.add('error')
        input.classList.remove('valid')
      }else{
        input.classList.add('valid');
        input.classList.remove('error');
      }   
    break      
    default:        
  }
   if( form.querySelectorAll('.error').length==0 && form.checkValidity()){
    return true;
  }else{
    return false;
  }
 
}   

