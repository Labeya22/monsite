<h1  class="mb-3">Mon blog</h1>
<div class="row gy-3 mb-5">
    <?php foreach($pagine->pagine() as $post): ?>
    <div class="col-md-3 blog-ajax">
        <div class="card pagine_">
            <div class="card-body">
                <h5 class="card-title"><?= $post->getName()  ?></h5>
                <p class="text-muted" style="font-size: 14px;padding-left: 5px;"><?= 'publié ' .  $post->getCreateAt()->format('d-m-Y à H:m:s') ?></p>
                <p><?= $post->getContent() ?></p>
                <p><a href="<?= $router->generateUri('blog.show', ['id' => $post->getId()]) ?>" class="btn btn-primary btn-sm showAjax" style="border-radius: 3px; padding: 2px;">voir plus</a></p>
            </div>
        </div>
    </div>
    <?php endforeach ?>
    <nav class="pagination pagines">
        <ul class="pagination pagination-sm"><?= $pagine->i(3) ?></ul>
    </nav>
</div>