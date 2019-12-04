var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}


console.log(document.querySelector('.product').innerHTML);

const allProducts = document.querySelectorAll('.product');
const allPrices = document.querySelectorAll('.productPrice');

function inRange(price, minArray, maxArray){

    let priceRange;

    for(let i = 0; i < minArray.length; i++){

        priceRange = (price-minArray[i])*(price-maxArray[i]) <= 0;
        
    }   
    
    console.log(priceRange);
    
    return priceRange;
}

const checkboxPrices = document.querySelectorAll('.filter-price input');
const checkboxOrigins = document.querySelectorAll('.filter-origin input');

let arrayMinPrices = [];
let arrayMaxPrices = [];

checkboxPrices.forEach(checkboxPrice => {

    checkboxPrice.addEventListener('click', function(){
        if(checkboxPrice.checked == true){

            allProducts.forEach(product => {
            
                product.parentElement.style.display = 'none';
                
            });

            let minPrice = checkboxPrice.value.substr(0, checkboxPrice.value.search('-'));
            let maxPrice = checkboxPrice.value.substr(checkboxPrice.value.search('-')+1, checkboxPrice.value.length);

            arrayMinPrices.push(minPrice);
            arrayMaxPrices.push(maxPrice);

            console.log(arrayMinPrices, arrayMaxPrices);
            allPrices.forEach(price => {

                let productParent = price.parentElement.parentElement.parentElement;
            
                price = price.innerHTML.substr(0, price.innerHTML.search('D'));

                if(inRange(price, arrayMinPrices, arrayMaxPrices)){
                    console.log(price);
                    productParent.style.display = 'block';
                }
                
            });
            
        }
    })

    
});
