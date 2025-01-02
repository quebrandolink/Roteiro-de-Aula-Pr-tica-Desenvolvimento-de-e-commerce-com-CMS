<?php
include('header.php');
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

//deleta o produto!.
if (isset($_GET["delete_product"]) && $_GET["delete_product"] == 1 && isset($_GET["product_id"]) && $_GET["product_id"] > 0) {
    $product_id = $_GET["product_id"];
    $query = "DELETE FROM products WHERE product_id = $product_id";
    if ($conn->query($query)) {
        header('Location: products.php');
    } else {
        $error = "Erro ao excluir produto.";
    }
}

// Consulta para buscar os produtos
$sql = "SELECT * FROM products";

// Lógica de paginação (ajuste o número de itens por página conforme necessário)
$itens_por_pagina = 5;
$pagina_atual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$inicio = ($pagina_atual - 1) * $itens_por_pagina;

$sql .= " ORDER BY product_id DESC";
// Limitar a consulta para a página atual
$sql .= " LIMIT $inicio, $itens_por_pagina";


$result = $conn->query($sql);

// Calcular o número total de páginas
$sql_count = "SELECT COUNT(*) AS total FROM products";
$total_result = $conn->query($sql_count);
$total = $total_result->fetch_assoc();

$total_registros = $total['total'];
$total_paginas = ceil($total_registros / $itens_por_pagina);

?>




<link href="../assets/css/dashboard.css" rel="stylesheet">



</head>

<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#"><img src="../assets/imgs/logo.png"
                height="40px" /></a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </header>
    <div class="container-fluid">
        <div class="row">
            <?php include_once("sidemenu.php"); ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>

                <h2>Products</h2>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><?= $error ?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <div class="table-responsive">
                    <a href="add_product.php" class="btn btn-primary mb-3">Adicionar Produto</a>
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Preço</th>
                                <th>Cor</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) == 0): ?>
                                <tr>
                                    <td colspan="6" class="text-center">Não foram encontrados registros</td>
                                </tr>

                            <?php endif;
                            while ($product = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $product['product_id']; ?></td>
                                    <td>
                                        <?php if ($product['product_image'] != null): ?>
                                            <img src="../assets/imgs/<?= $product['product_image']; ?>"
                                                alt="Imagem <?= $product['product_image']; ?>" class="img-thumbnail"
                                                style="height=30;" width="50" height="50">
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $product['product_name']; ?></td>
                                    <td><?= $product['product_category']; ?></td>
                                    <td>R$ <?= $product['product_price']; ?></td>
                                    <td><?= $product['product_color']; ?></td>
                                    <td>
                                        <a href="add_product.php?product_id=<?= $product['product_id']; ?>"
                                            class="btn btn-warning btn-sm">Editar</a>
                                        <a href="add_image.php?product_id=<?= $product['product_id']; ?>"
                                            class="btn btn-primary btn-sm">Editar Imagens</a>
                                        <a href="products.php?delete_product=1&product_id=<?= $product['product_id']; ?>"
                                            class="btn btn-danger btn-sm">Excluir</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination  justify-content-center mt-4">
                        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                            <li class="page-item <?php if ($i == $pagina_atual)
                                echo 'active'; ?>">
                                <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </main>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
        </script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <script>
        feather.replace();
    </script>
    <script src="dashboard.js"></script>

</body>

</html>