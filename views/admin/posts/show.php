<?php

$title = 'show - ' . $post[0]->getName();
?>
<h3><?= $post[0]->getName() ?></h3>
<p class="text-muted p-3"><?= $post[0]->getCreateAt()->format('d-m-Y à H:m:s') ?></p>
<p><?= $post[0]->getContent() ?></p>
