<?php



$title = e("categorie {$find[0]->getCategory()} ");

?>
<h1  class="mb-3"><?= e($title) ?></h1>
<div class="row gy-3 mb-5">
    <?php foreach($posts as $post): ?>
    <div class="col-md-3 blog-ajax">
        <div class="card pagine_">
            <div class="card-body">
                <h5 class="card-title"><?= e($post->getName())  ?></h5>
                <p class="text-muted" style="font-size: 14px;padding-left: 5px;"><?= 'publié ' .  e($post->getCreateAt()->format('d-m-Y à H:m:s')) ?></p>
                <?= category_assoc_generate($post->getCategory(), $router) ?>
                <p><?= e($post->getContent()) ?></p>
                <p><a href="<?= $router->generateUri('blog.show', ['id' => $post->getId()]) ?>" class="btn btn-primary btn-sm showAjax" style="border-radius: 3px; padding: 2px;">voir plus</a></p>
            </div>
        </div>
    </div>
    <?php endforeach ?>
    <nav class="pagination pagines">
        <ul class="pagination pagination-sm"><?= $paginate ?></ul>
    </nav>
</div>