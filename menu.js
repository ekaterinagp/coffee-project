
let allMenuItems = document.querySelectorAll(".deskmenu a");

    allMenuItems.forEach(function(menuItem) {
        menuItem.addEventListener("click", function(e) {
            e.preventDefault();
            console.log("menu item is clicked");
            // removeActive();
            menuItem.classList.add("active"); 
        });
    });

    function removeActive(){
        document.querySelectorAll(".active").forEach(function(menuItem){

        menuItem.classList.remove("active");

        });
    }
