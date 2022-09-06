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
                <?= li($router->generateUri('admin.index'), 'Accueil') ?>
                <?= li($router->generateUri('admin.posts.index'), 'Articles') ?>
                <?= li($router->generateUri('admin.categories.index'), 'Categories') ?>
                <?= li($router->generateUri('admin.relations.index'), 'Relations') ?>
                <li class="nav-item">
                    <form action="<?= $router->generateUri('auth.logout') ?>" method="post" style="display: inline-block;" class="nav-link">
                        <button type="submit" onclick="return confirm('Voulez-vous vraiment vous deconnecter ?')" style="border: none;background-color: inherit; color: inherit;">Se déconnecter</button>
                    </form>
                </li>
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