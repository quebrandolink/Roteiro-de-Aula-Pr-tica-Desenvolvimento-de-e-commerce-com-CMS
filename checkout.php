<?php
session_start();
include('layouts/header.php');
include('server/connection.php');

// Verifica se há itens no carrinho
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

// Inicializa variáveis
$total_price = 0;

// Calcula o total do carrinho
foreach ($_SESSION['cart'] as $item) {
    $total_price += $item['product_price'] * $item['quantity'];
}

// Lógica para processar o pedido
if (isset($_POST['checkout_btn'])) {
    $user_id = $_SESSION['user_id'];
    $shipping_city = $_POST['shipping_city'];
    $shipping_address = $_POST['shipping_address'];
    $shipping_uf = $_POST['shipping_uf'];
    $order_date = date('Y-m-d H:i:s');

    // Insere o pedido no banco
    $query = "INSERT INTO orders (user_id, order_cost, order_status, shipping_city, shipping_address, shipping_uf, order_date) 
              VALUES ('$user_id', '$total_price', 'processing', '$shipping_city', '$shipping_address', '$shipping_uf', '$order_date')";
    if ($conn->query($query)) {
        $order_id = $conn->insert_id;

        // Insere os itens do pedido no banco
        foreach ($_SESSION['cart'] as $item) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];
            $query = "INSERT INTO order_items (order_id, product_id, user_id, qnt, order_date) 
                      VALUES ('$order_id', '$product_id', '$user_id', '$quantity', '$order_date')";
            $conn->query($query);
        }

        // Limpa o carrinho
        unset($_SESSION['cart']);
        header('Location: order_confirmation.php?order_id=' . $order_id);
        exit();
    } else {
        $error = "Erro ao processar o pedido. Por favor, tente novamente.";
    }
}
?>
<section id="checkout">
    <div class="container mt-5">
        <h2>Finalizar Compra</h2>

        <!-- Itens do Carrinho -->
        <h4>Itens no Carrinho</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Preço Unitário</th>
                    <th>Quantidade</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                <tr>
                    <td><?= $item['product_name']; ?></td>
                    <td>R$ <?= number_format($item['product_price'], 2, ',', '.'); ?></td>
                    <td><?= $item['quantity']; ?></td>
                    <td>R$ <?= number_format($item['product_price'] * $item['quantity'], 2, ',', '.'); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h4>Total: R$ <?= number_format($total_price, 2, ',', '.'); ?></h4>

        <!-- Formulário de Dados de Envio -->
        <h4 class="mt-5">Dados de Envio</h4>
        <?php if (isset($error))
            echo "<p class='text-danger'>$error</p>"; ?>
        <form method="POST" action="checkout.php">
            <div class="form-group mt-3">
                <label>Cidade</label>
                <input type="text" name="shipping_city" class="form-control" required>
            </div>
            <div class="form-group mt-3">
                <label>Endereço</label>
                <input type="text" name="shipping_address" class="form-control" required>
            </div>
            <div class="form-group mt-3">
                <label>UF</label>
                <input type="text" name="shipping_uf" class="form-control" maxlength="2" required>
            </div>
            <a href="simulate_payment.php" class="btn btn-success mt-3">Finalizar Compra</a>
        </form>
    </div>
</section>
<?php include('layouts/footer.php'); ?>