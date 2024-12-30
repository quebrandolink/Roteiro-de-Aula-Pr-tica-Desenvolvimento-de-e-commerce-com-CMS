<?php
include('layouts/header.php');
include('server/connection.php');

// Paginação
$limit = 8; // Número de produtos por página
$page = isset($_GET['page']) && $_GET['page'] > 1 ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$query = "SELECT * FROM products LIMIT $limit OFFSET $offset";
$result = $conn->query($query);

// Total de produtos para a paginação
$total_query = "SELECT COUNT(*) AS total FROM products";
$total_result = $conn->query($total_query);
$total_products = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_products / $limit);
?>
<section id="producs">
    <div class="fluid-container mt-5 px-5">
        <h2 class="my-3">Produtos</h2>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php while ($product = mysqli_fetch_assoc($result)): ?>
                <div class="col">
                    <div class="card h-100">
                        <img src="<?= $product['product_image'] != null ? 'assets/imgs/' . $product['product_image'] : 'https://via.placeholder.com/500x200'; ?>"
                            class="card-img-top" alt="Product <?= $product['product_name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $product['product_name']; ?></h5>
                            <p class="card-text"><?= $product['product_description']; ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h3 mb-0">R$ <?= $product['product_price']; ?></span>
                                <a href="detail_product.php?product_id=<?= $product['product_id']; ?>"
                                    class="btn btn-primary"><i class="bi bi-cart-plus"></i> Ver Detalhes</a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>
        </div>
    </div>

    <!-- Paginação -->
    <nav>
        <ul class="pagination justify-content-center my-5">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : ''; ?>">
                    <a class="page-link" href="products.php?page=<?= $i; ?>"><?= $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</section>
<?php include('layouts/footer.php'); ?>