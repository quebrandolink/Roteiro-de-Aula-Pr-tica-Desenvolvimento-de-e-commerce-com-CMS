<?php
include('header.php');
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Obter Dados do Usuário
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE user_id = $user_id";
$result = $conn->query($query);
$user = $result->fetch_assoc();

// Alterar Senha
if (isset($_POST['update_password'])) {
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    if ($new_password == $confirm_password) {
        if ($current_password == $user['user_password']) {
            $query = "UPDATE users SET user_password = '$new_password' WHERE user_id = $user_id";
            if ($conn->query($query)) {
                $success = "Senha atualizada com sucesso.";
            } else {
                $error = "Erro ao atualizar a senha.";
            }
        } else {
            $error = "A senha atual está incorreta.";
        }
    } else {
        $error = "As novas senhas não coincidem.";
    }
}

// Obter Pedidos do Usuário
$order_query = "SELECT * FROM orders WHERE user_id = $user_id";
$order_result = $conn->query($order_query);
?>

<div class="container mt-5">
    <h2>Minha Conta</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $error ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $success ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-6">
            <h4>Dados Pessoais</h4>
            <p><strong>Nome:</strong> <?= $user['user_name']; ?></p>
            <p><strong>Email:</strong> <?= $user['user_email']; ?></p>
        </div>
        <div class="col-md-6">
            <h4>Alterar Senha</h4>
            <form method="POST" action="account.php">
                <div class="form-group">
                    <label>Senha Atual</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>
                <div class="form-group mt-3">
                    <label>Nova Senha</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>
                <div class="form-group mt-3">
                    <label>Confirmar Nova Senha</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
                <button type="submit" name="update_password" class="btn btn-primary mt-3">Atualizar</button>
            </form>
        </div>
    </div>

    <h4 class="mt-5">Meus Pedidos</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Data</th>
                <th>Total</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($order = mysqli_fetch_assoc($order_result)): ?>
                <tr>
                    <td><?= $order['order_id']; ?></td>
                    <td><?= $order['order_status']; ?></td>
                    <td><?= $order['order_date']; ?></td>
                    <td>R$ <?= $order['order_cost']; ?></td>
                    <td>
                        <a href="order_details.php?order_id=<?= $order['order_id']; ?>"
                            class="btn btn-info btn-sm">Detalhes</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>