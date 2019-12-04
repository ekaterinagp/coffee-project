"use strict"

const frmAddProduct = document.querySelector("#frmAddProduct");
const btnAddProduct = document.querySelector(".btnAddProduct")
const btnUpdatePrice = document.querySelectorAll(".btnUpdatePrice")
const btnUpdateStock = document.querySelectorAll(".btnUpdateStock")
const btnDeleteProduct = document.querySelectorAll(".btnDeleteProduct")
let updatePriceUrl = 'api/api-update-price.php'
let updateStockUrl = 'api/api-update-stock.php'
let deleteUrl = 'api/api-delete-product.php'

btnAddProduct.addEventListener('click', saveNewProduct);
btnDeleteProduct.forEach(btnDelete=>{
    btnDelete.addEventListener("click", function(){
        
        let id = btnDelete.parentElement.id;
        console.log(id)
        deleteProduct(id);
    })
})
btnUpdatePrice.forEach(btnUpdate=>{
    btnUpdate.addEventListener('click', function(){
        event.preventDefault();
        let id = btnUpdate.parentElement.parentElement.id;
        let form = btnUpdate.parentElement;
            updateProduct(id, form);
        });
})
btnUpdateStock.forEach(btnUpdate=>{
    btnUpdate.addEventListener('click', function(){
        event.preventDefault();
        let id = btnUpdate.parentElement.parentElement.id;
        let form = btnUpdate.parentElement;
        updateProduct(id, form);
        });
})

function deleteProduct(id){
    let idString = id.substr(id.search("-")+1,id.length)
    let formData = new FormData();
    formData.append('id', idString);
    fetch(deleteUrl, {
        method: "POST",
        body: formData
        })
            .then(res => res.text())
            .then(response => {
            console.log(response);
            document.getElementById(id).remove();
            });
}

function updateProduct(id, form){
    let url;
    id = id.substr(id.search("-")+1,id.length)
    let formData = new FormData();

    if (form.id == "frmUpdatePrice"){
        console.log("price");
        url = updatePriceUrl;
        let price= form.querySelector('[name=updatePrice]').value;
        formData.append('updatePrice', price);
    }else{
        url = updateStockUrl;
        let stock = form.querySelector('[name=updateStock]').value;
        formData.append('updateStock', stock);
    }
    
        formData.append('id', id);
        fetch(url, {
            method: "POST",
            body: formData
            })
                .then(res => res.text())
                .then(response => {
                console.log(response);
                });
        }


function saveNewProduct(){
        event.preventDefault();
        let createUrl = 'api/api-create-product.php'
        // let id = document.querySelector()
        let name = document.querySelector('[name=newName]').value;
        let price= document.querySelector('[name=newPrice]').value;
        let stock= document.querySelector('[name=newStock]').value;
        let coffeetype= document.querySelector('[name=newCoffeetype]').value;
        console.log(name, price, stock, coffeetype );
        let formData = new FormData();
        formData.append('newName', name);
        formData.append('newPrice', price);
        formData.append('newStock', stock);
        formData.append('newCoffeetype', coffeetype);
        console.log(formData)
    
        fetch(createUrl, {
            method: "POST",
            body: formData
            })
                .then(res => res.text())
                .then(response => {
                console.log(response);
                });
        }
    

      
//     const frmAddProperty = document.querySelector('#frmNewProperty')
//     const btnCloseFrm = document.querySelector('.btnCloseFrm');
//     document.querySelector('#btnShowFrm').addEventListener('click', function(){
//         // console.log('bla');
//         frmAddProperty.classList.add('showForm');
//         document.querySelector('#btnShowFrm').style.display="none";
//         btnCloseFrm.addEventListener('click', function(){
//             frmAddProperty.classList.remove('showForm');
//             document.querySelector('#btnShowFrm').style.display="block";
//         })
    
//     })
// }