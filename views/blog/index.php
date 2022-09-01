<h1  class="mb-3">Mon blog</h1>
<div class="row gy-3 mb-5">
    <?php foreach($posts as $post): ?>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= $post->getName()  ?></h5>
                <p class="text-muted" style="font-size: 14px;padding-left: 5px;"><?= 'publié ' .  $post->getCreateAt()->format('d-m-Y à H:m:s') ?></p>
                <p><?= $post->getContent() ?></p>
                <p><a href="" class="btn btn-primary btn-sm" style="padding: 2px 3px;">voir plus</a></p>
            </div>
        </div>
    </div>
    <?php endforeach ?>
</div>