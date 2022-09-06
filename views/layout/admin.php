<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=  S . "css/bootstrap.min.css" ?>">

    <title><?=  isset($title) ? e($title) : 'admin' ?></title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Tenth navbar example">
        <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-md-center" id="navbar">
            <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="#">Adminer</a>
            </li>
           
            <?= li($router->generateUri('admin.posts.index'), 'Articles') ?>
            <?= li($router->generateUri('admin.categories.index'), 'Categories') ?>
            <?= li($router->generateUri('admin.relations.index'), 'Relations') ?>
            </ul>
        </div>
        </div>
    </nav>
    <div class="container mt-5"><?= $content ?></div>

    <script src="<?=  S . "js/bootstrap.bundle.js" ?>"></script>
    <script src="<?=  S . "js/bootstrap.min.js" ?>"></script>
    <script src="<?=  S . "js/app.js" ?>"></script>
</body>
</html>