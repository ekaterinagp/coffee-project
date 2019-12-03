"use strict"

const frmAddProduct = document.querySelector("#frmAddProduct");
const btnAddProduct = document.querySelector(".btnAddProduct")
const btnUpdatePrice = document.querySelectorAll(".btnUpdatePrice")
const btnUpdateStock = document.querySelectorAll(".btnUpdateStock")
// const createUrl = 'api/api-update-product.php';
let updatePriceUrl = 'api/api-update-price.php'
let updateStockUrl = 'api/api-update-stock.php'

btnAddProduct.addEventListener('click', saveNewProduct);

btnUpdatePrice.forEach(btnUpdate=>{
    btnUpdate.addEventListener('click', function(){
            event.preventDefault();
            updateProduct(btnUpdate.parentElement.parentElement.id, btnUpdate.parentElement);
        });
})
// btnUpdateStock.forEach(btnUpdate=>{
//     btnUpdate.addEventListener('click', function(){
//             event.preventDefault();
//             updateProduct(btnUpdate.parentElement.parentElement.id);
//         });
// })



function updateProduct(id, form){
    id = id.substr(id.search("-")+1,id.length)
    let price= form.querySelector('[name=updatePrice]').value;
    let formData = new FormData();
        formData.append('updatePrice', price);
        formData.append('id', id);
        fetch(updatePriceUrl, {
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