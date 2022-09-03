<h1  class="mb-3">Categorie</h1>
<div class="row gy-3 mb-5">
    <?php foreach($find as $category): ?>
    <div class="col-md-3 blog-ajax">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= $category->getCategory()  ?></h5>
                <p class="text-muted" style="font-size: 14px;padding-left: 5px;"><?= 'publié ' .  $category->getCreateAt()->format('d-m-Y à H:m:s') ?></p>
            </div>
        </div>
    </div>
    <?php endforeach ?>
    <nav class="pagination pagines">
    </nav>
</div>