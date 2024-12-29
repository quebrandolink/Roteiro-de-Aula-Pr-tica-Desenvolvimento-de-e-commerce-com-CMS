<?php
//lógica para redirecionar o usuário para a página de login se ele não estiver logado
//como o arquivo sidemenu.php é incluído em todas as páginas do painel de administração, é importante garantir que o usuário esteja logado antes de exibir o menu lateral
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}
?>

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3" style="height: 100vh;">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="index.php">
                    <i data-feather="home"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i data-feather="file"></i>
                    Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="products.php">
                    <i data-feather="shopping-cart"></i>
                    Products
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="users.php">
                    <i data-feather="users"></i>
                    Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="add_product.php">
                    <i data-feather="bar-chart-2"></i>
                    Add New Product
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-danger" href="logout.php">
                    <i data-feather="log-out" class="text-danger"></i>
                    Sair
                </a>
            </li>
        </ul>




    </div>
</nav>