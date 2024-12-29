<?php
include_once("header.php");
$id = 0;

if (isset($_GET["id"])) {
    $id = $_GET['id'];
}

$sql = "SELECT * FROM orders WHERE order_id = $id";
$result = $conn->query(query: $sql);
$row = $result->fetch_assoc();

// Receber os dados do formulário
if (isset($_POST['id']) && isset($_POST['status'])) {
    $edit_id = $_POST['id'];
    $status = $_POST['status'];
    echo $edit_id . $status;
    $sql = "UPDATE orders SET order_status = '$status' WHERE order_id = $edit_id";
    if ($conn->query($sql)) {
        header("Location: index.php");
        exit();

    } else {
        $error = "Erro ao atualizar o pedido.";
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
                        <p class="h2">Editar Order</p>
                        <p class="h5">Alterar Status da Order</p>
                    </div>
                    <div class="card-body justify-content-center">
                        <?php if (isset($error))
                            echo "<p class='text-danger mt-2'>$error</p>"; ?>
                        <?php if (mysqli_num_rows($result) == 1): ?>
                            <form method="post" action="edit_order.php">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <div class="row">
                                    <div class="col">
                                        <select class="form-select" name="status" id="status">
                                            <option value="on_hold" <?php if ($row['order_status'] == 'on_hold')
                                                echo 'selected'; ?>>
                                                Em análise</option>
                                            <option value="paid" <?php if ($row['order_status'] == 'paid')
                                                echo 'selected'; ?>>Pago
                                            </option>
                                            <option value="shipped" <?php if ($row['order_status'] == 'shipped')
                                                echo 'selected'; ?>>
                                                Enviado</option>
                                            <option value="delivered" <?php if ($row['order_status'] == 'delivered')
                                                echo 'selected'; ?>>Entregue</option>
                                        </select>
                                    </div>
                                    <div class="col-3 d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                    </div>

                                </div>
                            </form>

                        <?php endif; ?>


                        <?php if (mysqli_num_rows($result) != 1): ?>
                            <p class="text-center">Dados não localizados corretamente!.</p>

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