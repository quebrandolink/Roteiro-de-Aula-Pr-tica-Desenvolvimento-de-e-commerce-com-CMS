<?php
include('layouts/header.php');

if (!isset($_GET['order_id'])) {
    header('Location: index.php');
    exit();
}

$order_id = $_GET['order_id'];
?>
<section id="order-confirmation">
    <div class="container mt-5 text-center">
        <h2>Pedido Confirmado!</h2>
        <p>Seu pedido #<?= $order_id; ?> foi processado com sucesso.</p>
        <a href="products.php" class="btn btn-primary mt-3">Continuar Comprando</a>
    </div>
</section>
<?php include('layouts/footer.php'); ?>