<?php include_once("header.php");

if (isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"] == true) {
    header("Location: index.php");

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE admin_email='$email' AND admin_password='$password'";
    $result = mysqli_query($conn, query: $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $row['admin_id'];
        $_SESSION['admin_name'] = $row['admin_name'];
        $_SESSION['admin_email'] = $row['admin_email'];
        header("Location: index.php");

    } else {

        $error_message = "Usuário ou senha inválidos, tente novamente.";
        header("Location: login.php?error=" . urlencode($error_message));
    }
}

?>
</head>

<body style="height: 100vh;">
    <div class="container-fluid  align-items-center">
        <div class="row justify-content-center">
            <div class="col-sm-10 col-md-6 col-lg-4">
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <img src="../assets/imgs/logo.png" height="40px" />
                        <p class="h2">Login</p>
                    </div>
                    <div class="card-body">
                        <form method="post" action="login.php">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Entrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Erro</h5> <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"> Ocorreu um erro. Por favor, tente novamente mais tarde. </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Verifica se há um erro para mostrar o modal 
        <?php if (isset($_GET['error'])): ?>
            var modal = document.getElementById('errorModal');
            var errorModal = new bootstrap.Modal(modal);
            document.querySelector('#errorModal .modal-body').textContent = "<?php echo htmlspecialchars($_GET['error']); ?>";
            errorModal.show();
            modal.addEventListener('hidden.bs.modal', function () {
                window.location.href = 'login.php';
            })
        <?php endif; ?>
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
        </script>
</body>

</html>