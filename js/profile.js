// UPDATE USER

const editButton = document.querySelector('.button-edit');
const saveButton = document.querySelector('.button-save');

// console.log(editButtons);

const inputName = document.querySelector("[name=inputName]");
const inputLastName = document.querySelector("[name=inputLastName]");
const inputEmail = document.querySelector("[name=inputEmail]");
const inputAddress = document.querySelector("[name=inputAddress]");
const inputPhoneNo = document.querySelector("[name=inputPhone]");
const inputCity = document.querySelector("[name=cityInput]");
const inputUsername = document.querySelector("[name=inputLoginName]");

    editButton.addEventListener('click', function(){
        event.preventDefault();
        
        inputName.classList.remove('not-input');
        inputLastName.classList.remove('not-input');
        inputEmail.classList.remove('not-input');
        inputAddress.classList.remove('not-input');
        inputPhoneNo.classList.remove('not-input');
        inputCity.classList.remove('not-input');
        inputUsername.classList.remove('not-input');
    
       
        showSaveButton();
    });


function showSaveButton(){
        document.querySelector('input').focus();

        saveButton.classList.remove('hide-button');
        
        saveButton.addEventListener('click', updateUser);   

    
        editButton.classList.add('hide-button');

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
     

        inputName.classList.add('not-input');
        inputLastName.classList.add('not-input');
        inputEmail.classList.add('not-input');
        inputAddress.classList.add('not-input');
        inputPhoneNo.classList.add('not-input');
        inputCity.classList.add('not-input');
        inputUsername.classList.add('not-input');

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
        let text = "Are you sure you want to delete subscription?";
        let deleteType = "subscription";
        let userSubscriptionID = deleteBtn.parentElement.parentElement.id;
        showModal(text, deleteType, userSubscriptionID);       
    });   
});

const deleteCardBtn = document.querySelector(".button-delete-card");

deleteCardBtn.addEventListener("click", function(){
    event.preventDefault();
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

            subscriptionItemsStatus = document.querySelector('.current-subscriptions').children.length;
            console.log(subscriptionItemsStatus);
            if(subscriptionItemsStatus == false){
                console.log('no subs');
                noSubscriptions();
            }
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
                window.location.href = "delete";
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

// const addCreditCardButton = document.querySelector(".button-add");
// addCreditCardButton.addEventListener("click", addCreditCard);

const addCreditCardForm = document.querySelector("#form-creditcard");
const saveCreditCardButton = addCreditCardForm.querySelector(".button-save");


// function addCreditCard(){
//     event.preventDefault();
//     const profileDetailsTwo = document.querySelector(".profile-details.details-two");

//     // saveCreditCardButton.classList.remove('hide-button');
//     addCreditCardButton.classList.add('hide-button');
//     addCreditCardForm.style.maxHeight = "100vh";
//     // profileDetailsTwo.style.maxHeight = "100vh";
    

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

            // addCreditCardButton.classList.remove('hide-button');
            // saveCreditCardButton.classList.add('hide-button');
            // addCreditCardForm.style.maxHeight = "0";
            document.querySelectorAll("#form-creditcart input").forEach(input=>{
                input.value = " ";

            })

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
// }

// IMG URL

function changeFormatForImg(product) {
    let str = product.cProductName;
    product.cProductName = str.replace(/\s+/g, "-").toLowerCase();
}

// CHECK IF USER HAS SUBSCRIPTIONS

const currentSubscriptions = document.querySelector('.current-subscriptions');
let subscriptionItemsStatus = currentSubscriptions.children.length; 

const currentSubscriptionsParent = currentSubscriptions.parentElement;

if(subscriptionItemsStatus == 0){
    console.log('no subs');
    noSubscriptions();
}

function noSubscriptions(){

        let h2Header = currentSubscriptionsParent.querySelector('h2');
        h2Header.className = 'text-center mb-small';
        h2Header.innerText = 'Get quality coffee right to your doorstep';
        let h3SubHeader = document.createElement('h3');
        h3SubHeader.innerText = 'Discover our delicious and convenient coffee subscriptions';
        h2Header.after(h3SubHeader);

        getAllSubscriptionsAsJson();
        
        // SUBSCRIPTIONS FUNCTION
        function getAllSubscriptionsAsJson() {
            let endpoint = "api/api-get-subscriptions.php";
            return new Promise((resolve, reject) => {
              fetch(endpoint)
                .then(res => res.json())
                .then(function(subscriptions) {
                  resolve(subscriptions);
        
                  showAllSubscriptions(subscriptions);
                });
            });
          }
        
        function showAllSubscriptions(subscriptions){
            subscriptions.forEach(function(subscription) {
        
            let subscriptionItem = document.createElement('div');
            subscriptionItem.className = 'subscriptionItem';
            subscriptionItem.setAttribute('id', subscription.nProductID);
        
            let subscriptionItemBg = document.createElement('div');
            subscriptionItemBg.className = 'subscriptionItemBg';
        
            let img = document.createElement('img');
            changeFormatForImg(subscription);
            img.src = "img/products/" + subscription.cProductName + ".png";
        
            let h3Name = document.createElement('h3');
            h3Name.className = 'subscriptionName';
            h3Name.innerText = subscription.cSubscriptionName;
        
            let h4Price = document.createElement('h4');
            h4Price.className = 'priceSubscription';
            h4Price.innerText = subscription.nPrice + ' DKK / Month';
        
            let whiteBg = document.createElement('div');
            whiteBg.className = 'white-text-bg';
        
            let pOrigin = document.createElement('p');
            pOrigin.className = 'productCoffeeType pb-small';
            pOrigin.innerText = subscription.cName;
        
            let pDesc = document.createElement('p');
            pDesc.className = 'descSubscription ph-small';
            pDesc.innerText = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate praesentium, inventore deleniti optio nobis quasi provident nulla minus odit architecto.';
        
            let addSubToCartBtn = document.createElement('button');
            addSubToCartBtn.className = 'addSubToCartBtn button';
            addSubToCartBtn.innerText = 'Add to Cart';
        
            subscriptionItemBg.append(img, h3Name, h4Price);
            whiteBg.append(pOrigin, pDesc);
        
            subscriptionItem.append(subscriptionItemBg, whiteBg, addSubToCartBtn);
        
            currentSubscriptions.append(subscriptionItem);
            });
        }
}

