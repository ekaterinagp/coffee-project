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
            
            let inputName = querySelector('#cName').value;
            let inputLastName = querySelector('#cSurname').value;
            let inputEmail = querySelector('#cEmail').value;
            let inputAddress = querySelector('#cAddress').value;
            let inputPhoneNo = querySelector('#cPhoneNo').value;
            let inputCity = querySelector('#nCityID').value;

            let formData = new formData();
            formData.append('inputName', inputName);
            formData.append('inputLastName', inputLastName);
            formData.append('inputEmail', inputEmail);
            formData.append('inputAddress', inputAddress);
            formData.append('inputPhone', inputPhoneNo);
            formData.append('cityInput', inputCity);

            // let endpoint = "api/api-update-profile.php";

    // fetch(endpoint, {
    //     method: "POST",
    //     body: formData
    // })
    // .then(res => res.text())
    // .then(response => {
    //   console.log(response);
    //   if (response == 1) {
    //     // location.href = "profile.php";
    //   }
    //   if (response == 0) {
    //     document.querySelector("#emailDiv").textContent =
    //       "User with this email or user name is not found";
    //     document.querySelector("#emailDiv").style.maxHeight = "500px";
    //   }
    // });


    
    


        });
        
    });
});

const deleteSubscriptionBtn = document.querySelectorAll(".product-info-container .button-delete");
deleteSubscriptionBtn.forEach(deleteBtn=>{
    deleteBtn.addEventListener("click", function(){

        
        let userSubscriptionID = deleteBtn.parentElement.id.substr(deleteBtn.parentElement.id.search("-")+1,deleteBtn.parentElement.id.length)
        let endpoint = "api/api-delete-subscription.php"
        let formData = new FormData();
        formData.append('userSubscriptionID',userSubscriptionID)
        fetch(endpoint, {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(response => {
            console.log(response);
        });
    })
})