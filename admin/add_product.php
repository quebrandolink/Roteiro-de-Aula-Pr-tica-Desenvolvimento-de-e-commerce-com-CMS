<?php
include('header.php');
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $query = "SELECT * FROM products WHERE product_id = $product_id";
    $result = $conn->query($query);
    $product = $result->fetch_assoc();
}

if (isset($_POST['update_product'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $color = $_POST['color'];

    $query = "UPDATE products SET 
                product_name = '$name', 
                product_category = '$category', 
                product_description = '$description', 
                product_price = $price, 
                product_color = '$color'
              WHERE product_id = $product_id";
    if ($conn->query($query)) {
        header('Location: products.php');
    } else {
        $error = "Erro ao atualizar produto.";
    }
}

if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $color = $_POST['color'];

    $query = "INSERT INTO products (product_name, product_category, product_description, product_price, product_color)
              VALUES ('$name', '$category', '$description', $price, '$color')";
    if ($conn->query($query)) {
        header('Location: products.php');
    } else {
        $error = "Erro ao adicionar produto.";
    }
}
?>



</head>

<body>
    <div class="container-fluid  align-items-center">
        <div class="row justify-content-center">
            <div class="col-sm-10 col-md-6 col-lg-4">
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <p class="h2">Adicionar Produto</p>
                    </div>
                    <div class="card-body justify-content-center">
                        <?php if (isset($error))
                            echo "<p class='text-danger mt-2'>$error</p>"; ?>
                        <form method="POST"
                            action="<?php echo isset($product) ? "add_product.php?product_id=" . $product['product_id'] : "add_product.php"; ?>">
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" name="name" class="form-control"
                                    value="<?php echo isset($product) ? $product['product_name'] : ''; ?>" required>
                            </div>
                            <div class="form-group mt-3">
                                <label>Categoria</label>
                                <input type="text" name="category" class="form-control"
                                    value="<?php echo isset($product) ? $product['product_category'] : ''; ?>" required>
                            </div>
                            <div class="form-group mt-3">
                                <label>Descrição</label>
                                <textarea name="description" class="form-control"
                                    required><?php echo isset($product) ? $product['product_description'] : ''; ?></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label>Preço</label>
                                <input type="number" name="price" class="form-control"
                                    value="<?php echo isset($product) ? $product['product_price'] : ''; ?>" step="0.01"
                                    required>
                            </div>
                            <div class="form-group mt-3">
                                <label>Cor</label>
                                <input type="text" name="color" class="form-control"
                                    value="<?php echo isset($product) ? $product['product_color'] : ''; ?>">
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-between mt-3">
                                <?php if (isset($product)): ?>
                                    <button type="submit" name="update_product" class="btn btn-primary">Atualizar</button>
                                <?php else: ?>
                                    <button type="submit" name="add_product" class="btn btn-primary">Adicionar</button>
                                <?php endif; ?>
                                <a href="products.php" class="btn btn-danger">Cancelar</a>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
        </script>
</body>

</html>