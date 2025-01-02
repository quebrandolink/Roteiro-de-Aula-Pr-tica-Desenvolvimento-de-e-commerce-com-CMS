<?php
session_start();
include('server/connection.php');

// Verifica se a simulação foi feita corretamente
if (!isset($_SESSION['cart']) || empty($_SESSION['cart']) || !isset($_POST['simulate_payment'])) {
    header('Location: index.php');
    exit();
}

// Coleta os dados de envio e pagamento
$user_id = $_SESSION['user_id'];
$payment_method = $_POST['payment_method'];
$shipping_city = $_SESSION['shipping_city'] ?? 'Desconhecido';
$shipping_address = $_SESSION['shipping_address'] ?? 'Desconhecido';
$shipping_uf = $_SESSION['shipping_uf'] ?? 'XX';
$order_date = date('Y-m-d H:i:s');

// Calcula o total
$total_price = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_price += $item['product_price'] * $item['quantity'];
}

// Simula a gravação do pedido no banco
$query = "INSERT INTO orders (user_id, order_cost, order_status, shipping_city, shipping_address, shipping_uf, order_date) 
          VALUES ('$user_id', '$total_price', 'completed', '$shipping_city', '$shipping_address', '$shipping_uf', '$order_date')";
if ($conn->query($query)) {
    $order_id = $conn->insert_id;

    foreach ($_SESSION['cart'] as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $query = "INSERT INTO order_items (order_id, product_id, user_id, qnt, order_date) 
                  VALUES ('$order_id', '$product_id', '$user_id', '$quantity', '$order_date')";
        $conn->query($query);
    }

    unset($_SESSION['cart']); // Limpa o carrinho
    header('Location: order_confirmation.php?order_id=' . $order_id);
    exit();
} else {
    $error = "Erro ao processar o pedido. Por favor, tente novamente.";
}

include('layouts/header.php');
?>
<section id="confirm_order">
    <div class="container mt-5 text-center">
        <h2>Erro</h2>
        <p class="text-danger"><?= $error; ?></p>
        <a href="cart.php" class="btn btn-primary">Voltar ao Carrinho</a>
    </div>

    <?php include('layouts/footer.php'); ?>