<?php
include('header.php');
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Obter ID do Produto
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $query = "SELECT * FROM products WHERE product_id = $product_id";
    $result = $conn->query($query);
    $product = $result->fetch_assoc();
}

// Adicionar Imagem
if (isset($_POST['add_image'])) {
    $image_field = $_POST['image_field'];
    $image = $_FILES['image']['name'];
    $target_dir = "../assets/imgs/";
    $target_file = $target_dir . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $query = "UPDATE products SET $image_field = '$image' WHERE product_id = $product_id";
        if ($conn->query($query)) {
            header("Location: add_image.php?product_id=$product_id");
        } else {
            $error = "Erro ao atualizar a imagem.";
        }
    } else {
        $error = "Erro ao fazer upload da imagem.";
    }
}

// Remover Imagem
if (isset($_POST['remove_image'])) {
    $image_field = $_POST['image_field'];
    $query = "UPDATE products SET $image_field = NULL WHERE product_id = $product_id";
    if ($conn->query($query)) {
        header("Location: add_image.php?product_id=$product_id");
    } else {
        $error = "Erro ao remover a imagem.";
    }
}
?>



</head>

<body>
    <div class="container-fluid  align-items-center">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <p class="h2">Editar Imagem</p><a href="products.php" class="btn btn-primary">Voltar</a>
                    </div>
                    <div class="card-body justify-content-center">
                        <?php if (isset($error))
                            echo "<p class='text-danger mt-2'>$error</p>"; ?>

                        <?php if ($result->num_rows != 1): ?>
                            <p class="text-center">Dados não localizados corretamente!.</p>
                        <?php else: ?>
                            <div class="row  d-flex align-items-end justify-content-center">
                                <?php for ($i = 1; $i <= 4; $i++):
                                    $image_field = ($i == 1) ? "product_image" : "product_image$i";
                                    ?>
                                    <div class="col-md-3 mt-5">
                                        <h5 class="text-center">Imagem <?= $i; ?></h5>
                                        <?php if ($product[$image_field]): ?>
                                            <img src="../assets/imgs/<?= $product[$image_field]; ?>" alt="Imagem <?= $i; ?>"
                                                class="img-fluid img-thumbnail mx-auto d-block mb-2">
                                            <form method="POST" action="add_image.php?product_id=<?= $product_id; ?>">
                                                <input type="hidden" name="image_field" value="<?= $image_field; ?>">
                                                <div class="text-center">
                                                    <button type="submit" name="remove_image"
                                                        class="btn btn-danger btn-sm mb-3 mx-auto">Remover</button>
                                                </div>
                                            </form>
                                        <?php else: ?>
                                            <p class="bg-info p-2 rounded text-light">Sem imagem</p>
                                        <?php endif; ?>
                                        <form method="POST" action="add_image.php?product_id=<?= $product_id; ?>"
                                            enctype="multipart/form-data" class="mt-2">

                                            <div class="row g-1 d-flex justify-content-center">
                                                <div class="col-9">
                                                    <input type="hidden" name="image_field" value="<?= $image_field; ?>">
                                                    <input type="file" name="image" class="form-control form-control-sm"
                                                        required>
                                                </div>
                                                <div class="col">
                                                    <button type="submit" name="add_image"
                                                        class="btn btn-primary btn-sm">Adicionar</button>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                <?php endfor; ?>
                            </div>

                        <?php endif; ?>

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