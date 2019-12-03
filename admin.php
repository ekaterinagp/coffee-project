<?php 
$sTitle = ' | Admin'; // Should get the username maybe? :-)
require_once(__DIR__.'/components/header.php');
require_once(__DIR__.'/connection.php');
?>

<main>

<h1>Update Products</h1>
<div class="adminProducts">
<?php
    $sql = "SELECT * FROM tProduct";
    foreach($connection->query($sql) as $row){
            echo '
            <div class="product" id="product-'.$row['nProductID'].' ">
            <h3 class="productName">'.$row['cName'].' </h3>
            <p class="propertyPrice">'.$row['nPrice'].'kr.</p>
            <form method="post" id="frmUpdatePrice"> 
    <label for="">Update Price<input type="text" name="updatePrice"></label> 
    <button type="submit" class="btnUpdatePrice">UPDATE PRICE</button>
</form>
            <p class="propertyStock">'.$row['nStock'].'</p>
            <form method="post" id="frmUpdateStock"> 
    <label for="">Update Stock<input type="text" name="updateStock"></label>
    <button type="submit" class="btnUpdateStock">UPDATE STOCK</button>
</form>
<button class="btnDeleteProduct">Delete Product</button>
            </div>
            ';
        }   

    
?>
</div>





<div>
<h2>Add Coffee products</h2>
<form method="POST" id="frmAddProduct">
    <label for="">Name<input type="text" name="newName"></label>
    <label for="">Price<input type="text" name="newPrice"></label>
    <label for="">Coffee Type
        <select name="newCoffeetype" id="">
            <option value="1">Columbia</option>
            <option value="2">Ethiopia</option>
            <option value="3">Sumatra</option>
            <option value="4">Brazil</option>
            <option value="5">Nicaragua</option>
            <option value="6">Blend</option>
        </select>
    </label>
    <label for="">Stock<input type="text" name="newStock"></label>
        <button class="btnAddProduct">Add Product</button>
        </form>
</div>


</main>
<script src="admin.js"></script>
<?php
$sScriptPath = 'script.js';
require_once(__DIR__.'/components/footer.php');