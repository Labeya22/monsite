<?php

$title = 'show';
?>
<h1><?= $find[0]->getName() ?></h1>
<p class="text-muted p-3"><?= $find[0]->getCreateAt()->format('d-m-Y à H:m:s') ?></p>
<?= category_assoc_generate($categories, $router) ?>
<p><?= $find[0]->getContent() ?></p>
