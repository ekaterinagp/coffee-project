const editButtons = document.querySelectorAll('.button-edit');
const saveButtons = document.querySelectorAll('.button-save');

editButtons.forEach(editButton => {
    editButton.addEventListener('click', function(){
        event.preventDefault();
        const buttonLabel = editButton.parentElement;

        buttonLabel.querySelector('input').focus();

        buttonLabel.querySelector('.button-save').classList.remove('hide-button');
        buttonLabel.querySelector('.button-edit').classList.add('hide-button');

        buttonLabel.querySelector('.button-save').addEventListener('click', function(){
            event.preventDefault();
            
            let inputName = document.querySelector("[name=inputName]").value;
            let inputLastName = document.querySelector("[name=inputLastName]").value;
            let inputEmail = document.querySelector("[name=inputEmail]").value;
            let inputAddress = document.querySelector("[name=inputAddress]").value;
            let inputPhoneNo = document.querySelector("[name=inputPhone]").value;
            let inputCity = document.querySelector("[name=cityInput]").value;
            let inputUsername = document.querySelector("[name=inputLoginName]").value;
            let inputPassword = document.querySelector("[name=inputPassword]").value;

            let formData = new formData();
            formData.append('inputName', inputName);
            formData.append('inputLastName', inputLastName);
            formData.append('inputEmail', inputEmail);
            formData.append('inputAddress', inputAddress);
            formData.append('inputPhone', inputPhoneNo);
            formData.append('cityInput', inputCity);
            formData.append('inputLoginName', inputUsername);
            formData.append('inputPassword', inputPassword);

            let endpoint = "api/api-update-profile.php";

            fetch(endpoint, {
                method: "POST",
                body: formData
            })
            .then(res => res.text())
            .then(response => {
            console.log(response);
            if (response == 1) {

                
            }
            if (response == 0) {
                
            }
            });
        });    
    });
});

const deleteSubscriptionBtn = document.querySelectorAll(".product-info-container .button-delete");

deleteSubscriptionBtn.forEach(deleteBtn=>{
    deleteBtn.addEventListener("click", function(){
        let userSubscriptionID = deleteBtn.parentElement.id.substr(deleteBtn.parentElement.id.search("-")+1,deleteBtn.parentElement.id.length)
        deleteSubscription(userSubscriptionID)
    })
    
})

function deleteSubscription(id){
     // console.log('delte')
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
        });
}

document.querySelector(".delete-profile-button").addEventListener("click", deleteUser);
document.querySelector(".log-out").addEventListener("click", logout);

function deleteUser(){
    let endpoint = "api/api-delete-user.php";
    // console.log("delte user");
        fetch(endpoint, {
            method: "POST"
        })
        .then(res => res.text())
        .then(response => {
            console.log(response);
            if(response==1);
            window.location.href = "index.php";
        });
}

let deleteCardBtns = document.querySelectorAll(".button-delete-card")
deleteCardBtns.forEach(deleteBtn=>{
    deleteBtn.addEventListener("click", function(){
        let id = deleteBtn.parentElement.id.substr(deleteBtn.parentElement.id.search("-")+1,deleteBtn.parentElement.id.length)
        deleteCreditCard(id);
    })
})

function deleteCreditCard(id){
    let formData = new FormData();
    formData.append('nCreditCardID', id);
    let endpoint = "api/api-delete-card.php";
    // console.log("delte user");
        fetch(endpoint, {
            body: formData,
            method: "POST"
        })
        .then(res => res.text())
        .then(response => {
            document.getElementById("creditcard-"+id).remove();
        });
}

function logout(){
    let endpoint = "api/api-logout.php";
    // console.log("delte user");
        fetch(endpoint, {
            method: "POST"
        })
        .then(res => res.text())
        .then(response => {
            window.location.href = "index.php";
        });
}

const addCreditCardButton = document.querySelector(".button-add");
addCreditCardButton.addEventListener("click", addCreditCard);

function addCreditCard(){
    event.preventDefault();
    const addCreditCardForm = addCreditCardButton.parentElement;
    const saveCreditCardButton = addCreditCardForm.querySelector(".button-save");

    saveCreditCardButton.classList.remove('hide-button');
    addCreditCardButton.classList.add('hide-button');

    saveCreditCardButton.addEventListener('click', function(){
        event.preventDefault();

        console.log('credit card saved');
        
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
              console.log(response);
              if (response) {
                console.log('new creditcard added');

                // let creditCardContainer = document.createElement("div");
                // creditCardContainer.setAttribute("id", "creditcard-") // can I add the ID here?
                // creditCardContainer.classList.add("mb-medium", "mt-small"); 

                // let creditCardDescriptionContainer = document.createElement("div");
                // creditCardDescriptionContainer.classList.add("description");

                // let creditCardDetailsContainer = document.createElement("div");
                // creditCardDetailsContainer.classList.add("creditcard-details");

                // let h3IBAN = document.createElement("h3");
                // h3IBAN.classList.add("color-white");

                // let pIBAN = document.createElement("p");
                // pIBAN.classList.add("mv-small", "text-left", "color-white");

                // let h3Expiration = document.createElement("h3");
                // h3Expiration.classList.add("color-white");

                // let pExpiration = document.createElement("p");
                // pExpiration.classList.add("mv-small", "text-left", "color-white");

                // let button = document.createElement("button");
                // button.classList.add("button-delete-card", "button");

                // creditCardDetailsContainer.append(h3IBAN, pIBAN, h3Expiration, pExpiration);
                // creditCardDescriptionContainer.append(creditCardDetailsContainer);
                // creditCardContainer.append(creditCardDescriptionContainer, button);
                
                // document.querySelector('.creditcard-info').append('
                //<div id="creditcard-<?=$nCreditCardID;?>" class="mb-medium mt-small">
                //<div class="description">
                //<div class="creditcard-details">
                //<h3 class="color-white">IBAN</h3>
                //<p class="mv-small text-left color-white"><?=$jUserCreditCard["cIBAN"];?></p>
                //<h3 class="color-white">Expiration</h3>
                //<p class="mv-small text-left color-white"><?=$jUserCreditCard["cExpiration"];?></p>
                //</div></div>
                //<button class="button-delete-card button">Delete</button></div>');

                // document.querySelector(".creditcard-info").appendChild(creditCardContainer);
              }
            });
    });

}