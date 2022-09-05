<?php

$title = 'show - ' . $category[0]->getCategory();
?>
<h3><?= $category[0]->getCategory() ?></h3>
<p class="text-muted p-3"><?= $category[0]->getCreateAt()->format('d-m-Y à H:m:s') ?></p>
