<h1>Manage Products</h1>
<? if (isset($_GET['allproducts'])) {?>
<a href="/product/manageproduct">
            <p>Filter to see most recent products</p></a>
<p class="success"><?=$msg ?? ''?><p>
			<hr />
<br>
<h2>All Products:</h2>
<? } else {?>
    <a href="/product/manageproduct?allproducts=true">
            <p>Filter to see all Products</p></a>
<p class="success"><?=$msg ?? ''?><p>
			<hr />
<br>
<h2>Most Recent Products Added:</h2>
    <? } ?>
<form action="" method="post">
<ul class="products">
<?  foreach ($recent_products as $recent_product) {?>
				<li>

                    <input type="radio" name="productselection" value="<?=$recent_product['product_id']?>" checked="checked">
					<a href="/product/product?id=<?=$recent_product['product_id']?>"><h3><?=$recent_product['name']?></h3></a>
                    <? if ($recent_product['category_id'] == null) { ?>
                        <br>
                        <a class="error">Product is not in a Category!</a>
                        <br>
                   <? }?>
                    <br>
                    <a class="error" href="/product/delete?id=<?=$recent_product['product_id']?>">Delete</a>
				</li>
                <? }?>
                </form>

<br>
<h2>Assign Product to a Category</h2>

<select name="category" id="category">
    <? foreach ($categories as $category) {?>
                        <option selected="selected" value="<?=$category['category_id']?>"><?=$category['name']?></option>
                <? }?>
                </select>
<input type="submit" name="submit" value="Add Product to Category" />
</form>
<br>
			<hr />
            <br>
            

            <h2>Add a Product</h2>
			<form action="" method="post" enctype="multipart/form-data">
				<label>Product Name</label> <input type="text" name="name" />
				<label>Product Manufacturer</label> <input type="text" name="manufacturer" />
                <label>Product Price (Must Contain a Decimal)</label> <input type="text" name="price" />
                <label for="image">Product Image</label><input type="file" id="image" name="image">
                <label>Product Description</label> <textarea name="description" ></textarea>
				<input type="submit" name="add" value="Add Product" />
                <p class="error"><?=$error ?? ''?><p>
			</form>