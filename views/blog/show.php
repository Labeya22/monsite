<?php

$title = 'show';
?>
<h1><?= $find[0]->getName() ?></h1>
<p class="text-muted p-3"><?= $find[0]->getCreateAt()->format('d-m-Y à H:m:s') ?></p>
<?php foreach ($categories as $key => $categorie): ?>
    <?php $key > 0 ? ', ' : '' ?>
    <a href="<?= $router->generateUri('category.show', [
        'category' => $categorie->getId()
    ]) ?>"><?= $categorie->getCategory() ?></a>
<?php endforeach; ?>
<p><?= $find[0]->getContent() ?></p>
