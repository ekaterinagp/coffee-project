// UPDATE USER

const editButton = document.querySelector('.button-edit');
const saveButton = document.querySelector('.button-save');

const inputName = document.querySelector("[name=inputName]");
const inputLastName = document.querySelector("[name=inputLastName]");
const inputEmail = document.querySelector("[name=inputEmail]");
const inputAddress = document.querySelector("[name=inputAddress]");
const inputPhoneNo = document.querySelector("[name=inputPhone]");
const inputCity = document.querySelector("[name=cityInput]");
const inputUsername = document.querySelector("[name=inputLoginName]");

editButton.addEventListener('click', function(){
    inputName.classList.remove('not-input');
    inputLastName.classList.remove('not-input');
    inputEmail.classList.remove('not-input');
    inputAddress.classList.remove('not-input');
    inputPhoneNo.classList.remove('not-input');
    inputCity.classList.remove('not-input');
    inputUsername.classList.remove('not-input');

    event.preventDefault();
    showSaveButton();
});

function showSaveButton(){
    document.querySelector('input').focus();

    saveButton.classList.remove('hide-button');
    editButton.classList.add('hide-button');

    saveButton.addEventListener('click', updateUser);    
}

function updateUser(){
    console.log('saved')
    event.preventDefault();
        
    let inputNameValue = inputName.value;
    let inputLastNameValue = inputLastName.value;
    let inputEmailValue = inputEmail.value;
    let inputAddressValue = inputAddress.value;
    let inputPhoneNoValue = inputPhoneNo.value;
    let inputCityValue = inputCity.value;
    let inputUsernameValue = inputUsername.value;

    let formData = new FormData();
    formData.append('inputName', inputNameValue);
    formData.append('inputLastName', inputLastNameValue);
    formData.append('inputEmail', inputEmailValue);
    formData.append('inputAddress', inputAddressValue);
    formData.append('inputPhone', inputPhoneNoValue);
    formData.append('cityInput', inputCityValue);
    formData.append('inputLoginName', inputUsernameValue);
    // formData.append('inputPassword', inputPassword);

    let endpoint = "api/api-update-profile.php";

    fetch(endpoint, {
    method: "POST",
    body: formData
    })
    .then(res => res.text())
    .then(response => {
        console.log(response);
    if (response == 1) {
        let text = "Your profile has been updated";
        let responseClass = "success";

        editButton.classList.remove('hide-button');
        saveButton.classList.add('hide-button');

        showNotification(text, responseClass);
    }
    if (response == 0) {

        let text = "Something went wrong, please try again";
        let responseClass = "fail";
        
        showNotification(text, responseClass);
    }
    });
}

// NOTIFICATIONS



/////// DELETE FUNCTIONS

// BUTTONS

const deleteSubscriptionBtn = document.querySelectorAll(".current-subscriptions .button-delete");

deleteSubscriptionBtn.forEach(deleteBtn=>{
   
    deleteBtn.addEventListener("click", function(){
        let text = "Are you sure you want to unsubscribe?";
        let deleteType = "subscription";
        let userSubscriptionID = deleteBtn.parentElement.parentElement.id;
        showModal(text, deleteType, userSubscriptionID);       
    });   
});

const deleteCardBtn = document.querySelector(".button-delete-card");

deleteCardBtn.addEventListener("click", function(){
    let text = "Are you sure you want to delete your credit card?";
    let deleteType = "creditcard";
    let creditCardID = document.querySelector('[name=userCreditCards]').value;
    showModal(text, deleteType, creditCardID);
    console.log(creditCardID);
});


const deleteProfileBtn = document.querySelector(".button-delete-profile");

deleteProfileBtn.addEventListener("click", function(){
    let text = "Are you sure you want to delete your profile?";
    let deleteType = "profile";
    let userID = "noID";
    showModal(text, deleteType, userID);
});


// MODAL 

function showModal(text, deleteType, itemID){

    let modal = document.createElement("div");
    modal.className = "modal";

    let modalContainer = document.createElement("div");
    modalContainer.className = "modalContainer grid grid-two p-medium";

    let h3 = document.createElement("h3");
    h3.textContent = text;

    let buttonAbort = document.createElement("button");
    buttonAbort.className = "button modal-button button-abort-delete";
    buttonAbort.textContent = "Cancel";

    let buttonDelete = document.createElement("button");
    buttonDelete.className = "button modal-button button-confirm-delete";
    buttonDelete.textContent = "Delete";

    modalContainer.append(h3, buttonDelete, buttonAbort);
    modal.append(modalContainer);
    document.querySelector('body').append(modal);

    document.querySelector(".button-abort-delete").addEventListener("click", function(){
        modal.classList.add('hide');
        setTimeout(function(){
            document.querySelector(".modal").remove();
        }, 1000);
    });

    document.querySelector(".button-confirm-delete").addEventListener("click", function(){
        if(deleteType == "subscription"){
            console.log("deleted subscription");
            console.log(itemID)
            deleteSubscription(itemID);
            modal.classList.add('hide');
            setTimeout(function(){
            document.querySelector(".modal").remove();
            }, 1000);
        }

        if(deleteType == "creditcard"){
            console.log("deleted creditcard");
            deleteCreditCard(itemID);

            modal.classList.add('hide');
            setTimeout(function(){
                document.querySelector(".modal").remove();
            }, 1000)
           
        }

        if(deleteType == "profile"){
            console.log("deleted user");

            deleteUser();

            modal.classList.add('hide');
            setTimeout(function(){
                document.querySelector(".modal").remove();
            }, 1000)
        }
    });
}

function deleteSubscription(id){
    let endpoint = "api/api-delete-subscription.php"
    let formData = new FormData();
    formData.append('userSubscriptionID',id)
    fetch(endpoint, {
            method: "POST",
            body: formData
    })
    .then(res => res.text())
    .then(response => {
        console.log(response);
        if (response == 1) {
            let responseClass = "success";
            let text = "Your subscription has been cancelled";
            showNotification(text, responseClass);
            console.log(id);
            document.getElementById(id).remove();
        }
        if (response == 0) {
            let responseClass = "fail";
            let text = "Something went wrong, please try again";
            showNotification(text, responseClass);
        }
    });
}

function deleteCreditCard(id){
    let formData = new FormData();
    formData.append('nCreditCardID', id);
    let endpoint = "api/api-delete-creditcard.php";
        fetch(endpoint, {
            body: formData,
            method: "POST"
        })
        .then(res => res.text())
        .then(response => {
            console.log(response);
            if (response == 1) {
            let responseClass = "success";
            let text = "Your creditcard has been removed";
            showNotification(text, responseClass);

            document.getElementById(id).remove();
            }
            if (response == 0) {
            let responseClass = "fail";
            let text = "Something went wrong, please try again";
            showNotification(text, responseClass);
            }
        });
}

function deleteUser(){
    let endpoint = "api/api-delete-user.php";
    console.log("user deleted");
    fetch(endpoint, {
            method: "POST"
    })
    .then(res => res.text())
    .then(response => {
        console.log(response);
        if(response == 1){
            let responseClass = "success";
            let text = "Your profile is deleted";
            showNotification(text, responseClass);

            setTimeout(function(){
                window.location.href = "index";
            }, 1000);
            
        }
        if (response == 0) {   
            let responseClass = "fail";
            let text = "Something went wrong, please try again";
            showNotification(text, responseClass);
        }
        
    });
}


// ADD CREDITCARD

const addCreditCardButton = document.querySelector(".button-add");
addCreditCardButton.addEventListener("click", addCreditCard);

function addCreditCard(){
    event.preventDefault();
    const addCreditCardForm = document.querySelector("#form-creditcard");
    const saveCreditCardButton = addCreditCardForm.querySelector(".button-save");

    saveCreditCardButton.classList.remove('hide-button');
    addCreditCardButton.classList.add('hide-button');
    addCreditCardForm.style.maxHeight = "100vh";

    saveCreditCardButton.addEventListener('click', function(){
        event.preventDefault();
        
        let IBAN = document.querySelector("[name=inputIBAN]").value;
        let CCV = document.querySelector("[name=inputCCV]").value;
        let expiration = document.querySelector("[name=inputExpiration]").value;

        let formData = new FormData();
        formData.append('inputIBAN', IBAN);
        formData.append('inputCCV', CCV);
        formData.append('inputExpiration', expiration);

        let endpoint = "api/api-create-creditcard.php";

        fetch(endpoint, {
            method: "POST",
            body: formData
          })
            .then(res => res.text())
            .then(response => {

            if(response == 0){
                    let text = "Something went wrong, please try again";
                    let responseClass = "fail";
                    
                    showNotification(text, responseClass);
            }

              if (response) {

            let text = "Your creditcard has been added";
            let responseClass = "success";

            addCreditCardButton.classList.remove('hide-button');
            saveCreditCardButton.classList.add('hide-button');
            addCreditCardForm.style.maxHeight = "0";

            showNotification(text, responseClass);
            
            console.log('new creditcard added');

                let creditCardContainer = document.createElement("option");
                creditCardContainer.setAttribute("id", response);
                creditCardContainer.value = response;
                creditCardContainer.innerText = IBAN;

                document.querySelector("[name=userCreditCards]").appendChild(creditCardContainer);
            }
        });
    });

}
