<?php
session_start();
include('layouts/header.php');

// Verifica se há itens no carrinho
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

// Calcula o total
$total_price = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_price += $item['product_price'] * $item['quantity'];
}
?>
<section id="simulate_payment">
    <div class="container mt-5">
        <h2>Simulação de Pagamento</h2>
        <p>Você está simulando o processo de pagamento para a sua compra.</p>
        <h4>Total: R$ <?= number_format($total_price, 2, ',', '.'); ?></h4>

        <form method="POST" action="confirm_order.php">
            <div class="form-group mt-3">
                <label for="payment_method">Escolha o método de pagamento</label>
                <select name="payment_method" id="payment_method" class="form-control" required>
                    <option value="credit_card">Cartão de Crédito</option>
                    <option value="paypal">PayPal (Simulação)</option>
                    <option value="pix">Pix</option>
                </select>
            </div>
            <button type="submit" name="simulate_payment" class="btn btn-primary mt-3">Simular Pagamento</button>
        </form>
    </div>
</section>
<?php include('layouts/footer.php'); ?>