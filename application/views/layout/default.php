<!DOCTYPE html>
<html>

<head>
    <title><?php echo htmlspecialchars($title) ?></title>
    <script src="/public/js/jquery-v4.3.1.min.js"></script>
    <script src="/public/js/form.js"></script>
    <script src="/public/js/all.js"></script>
    <link href="/public/styles/style.css" rel="stylesheet">
    <link href="/public/styles/bootstrap-4.3.1/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="col-27-md">
            <div class="login-container">
                <a href="/">Главная</a>
            </div>
            <?php echo $content ?>
        </div>
    </div>
</body>

</html>