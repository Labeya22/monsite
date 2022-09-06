<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=  S . "css/bootstrap.min.css" ?>">
    <title> <?= $title ?? 'se connecter' ?></title>
</head>

<style>
    html,
    body {
        height: 100%;
    }

    body {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
<body class="bg-light">
    <div class="container">
        <?= $content ?>
    </div>

    <script src="<?=  S . "js/bootstrap.bundle.js" ?>"></script>
    <script src="<?=  S . "js/bootstrap.min.js" ?>"></script>
    <script src="<?=  S . "js/app.js" ?>"></script>
</body>
</html>     