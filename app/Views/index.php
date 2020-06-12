<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Sebastián Huérfano">
    <title>Sistema de Inventario</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/bootstrap/dist/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/style.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/fontawesomefree/css/all.css'); ?>">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <!-- Custom styles for this template -->
</head>

<body>
    <div>
        <?= $this->include('partials/header') ?>
        <div class="container-fluid">
            <div class="row">
                <?= $this->include('partials/sidebar') ?>
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                    <?= $this->renderSection('content') ?>
                </main>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url('css/bootstrap/dist/js/jquery.slim.min.js'); ?>"></script>
    <script>
        window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')
    </script>
    <script src="<?php echo base_url('css/bootstrap/dist/js/bootstrap.bundle.js'); ?>"></script>
    <script src="<?php echo base_url('css/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('js/modules/chartjs/chart.js'); ?>"></script>

</body>

</html>