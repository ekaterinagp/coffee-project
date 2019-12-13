// UPDATE USER

const editButton = document.querySelector('.button-edit');
const saveButton = document.querySelector('.button-save');

editButton.addEventListener('click', function(){
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
        
    let inputName = document.querySelector("[name=inputName]").value;
    let inputLastName = document.querySelector("[name=inputLastName]").value;
    let inputEmail = document.querySelector("[name=inputEmail]").value;
    let inputAddress = document.querySelector("[name=inputAddress]").value;
    let inputPhoneNo = document.querySelector("[name=inputPhone]").value;
    let inputCity = document.querySelector("[name=cityInput]").value;
    let inputUsername = document.querySelector("[name=inputLoginName]").value;
    // let inputPassword = document.querySelector("[name=inputPassword]").value;

    let formData = new FormData();
    formData.append('inputName', inputName);
    formData.append('inputLastName', inputLastName);
    formData.append('inputEmail', inputEmail);
    formData.append('inputAddress', inputAddress);
    formData.append('inputPhone', inputPhoneNo);
    formData.append('cityInput', inputCity);
    formData.append('inputLoginName', inputUsername);
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

console.log(deleteSubscriptionBtn);

deleteSubscriptionBtn.forEach(deleteBtn=>{

    console.log('click');
   
    deleteBtn.addEventListener("click", function(){
        let text = "Are you sure you want to unsubscribe?";
        let deleteType = "subscription";
        let userSubscriptionID = deleteBtn.parentElement.parentElement.id;
        console.log(deleteBtn.parentElement.id);
        showModal(text, deleteType, userSubscriptionID);       
    });   
});

const deleteCardBtns = document.querySelectorAll(".button-delete-card");

deleteCardBtns.forEach(deleteBtn=>{
    deleteBtn.addEventListener("click", function(){
        let text = "Are you sure you want to delete your credit card?";
        let deleteType = "creditcard";
        let creditCardID = deleteBtn.parentElement.id.substr(deleteBtn.parentElement.id.search("-")+1,deleteBtn.parentElement.id.length);
        showModal(text, deleteType, creditCardID);
    });
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
            document.getElementById("subscription-" + id).remove();

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

            document.getElementById("creditcard-" + id).remove();
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

                let creditCardContainer = document.createElement("div");
                creditCardContainer.setAttribute("id", "creditcard-" + response)
                creditCardContainer.classList.add("mb-medium", "mt-small"); 

                let creditCardDescriptionContainer = document.createElement("div");
                creditCardDescriptionContainer.classList.add("description");

                let creditCardDetailsContainer = document.createElement("div");
                creditCardDetailsContainer.classList.add("creditcard-details");

                let h3IBAN = document.createElement("h3");
                h3IBAN.classList.add("color-white");
                h3IBAN.textContent = "IBAN";

                let pIBAN = document.createElement("p");
                pIBAN.classList.add("mv-small", "text-left", "color-white");
                pIBAN.textContent = IBAN;

                let h3Expiration = document.createElement("h3");
                h3Expiration.classList.add("color-white");
                h3Expiration.textContent = "Expiration";

                let pExpiration = document.createElement("p");
                pExpiration.classList.add("mv-small", "text-left", "color-white");
                pExpiration.textContent = expiration;

                let button = document.createElement("button");
                button.classList.add("button-delete-card", "button");
                button.textContent = "Delete creditcard";

                creditCardDetailsContainer.append(h3IBAN, pIBAN, h3Expiration, pExpiration);
                creditCardDescriptionContainer.append(creditCardDetailsContainer);
                creditCardContainer.append(creditCardDescriptionContainer, button);

                document.querySelector(".creditcard-info").appendChild(creditCardContainer);
            }
        });
    });

}
