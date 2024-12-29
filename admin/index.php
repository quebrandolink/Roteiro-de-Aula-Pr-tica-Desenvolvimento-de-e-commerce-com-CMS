<?php
include_once("header.php");


// Consulta para buscar os pedidos
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);

// Lógica de paginação (ajuste o número de itens por página conforme necessário)
$itens_por_pagina = 5;
$pagina_atual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$inicio = ($pagina_atual - 1) * $itens_por_pagina;

// Limitar a consulta para a página atual
$sql .= " LIMIT $inicio, $itens_por_pagina";
$result = $conn->query($sql);

// Calcular o número total de páginas
$total_registros = mysqli_num_rows($conn->query($sql));
$total_paginas = ceil($total_registros / $itens_por_pagina);

if (isset($_GET["delete_order"]) && $_GET["delete_order"] == "1" && isset($_GET["id"]) && $_GET["id"] > 0) {

}
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
        <!-- <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search"> -->
        <div class="navbar-nav">
            <!-- <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="#">Sign out</a>
            </div> -->
        </div>
    </header>
    <div class="container-fluid">
        <div class="row">
            <?php include_once("sidemenu.php"); ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>

                <h2>Orders</h2>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Order Id</th>
                                <th scope="col">Order Status</th>
                                <th scope="col">User Id</th>
                                <th scope="col">Order Date</th>
                                <th scope="col">Editar</th>
                                <th scope="col">Deletar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) == 0): ?>
                                <tr>
                                    <td colspan="6" class="text-center">Não foram encontrados registros</td>
                                </tr>

                            <?php endif;

                            while ($row = $result->fetch_assoc()): ?>

                                <tr>
                                    <td><?php echo $row['order_id']; ?></td>
                                    <td><?php echo $row['order_status']; ?></td>
                                    <td><?php echo $row['user_id']; ?></td>
                                    <td><?php echo $row['order_date']; ?></td>
                                    <td><a href="edit_order.php?id=<?php echo $row['order_id']; ?>"
                                            class="btn btn-primary btn-sm">Editar</a></td>
                                    <td><a href="index.php?delete_order=1&id=<?php echo $row['order_id']; ?>"
                                            class="btn btn-danger btn-sm">Deletar</a></td>
                                </tr>
                            <?php endwhile; ?>

                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination  justify-content-center mt-4">

                        <?php
                        for ($i = 1; $i <= $total_paginas; $i++): ?>
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