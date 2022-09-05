<?php

use App\Flash;
use App\Message;

$title = 'administration des categories';
?>

<div class="row mb-3 justify-content-center gy-3">
    <div class="col-md-10">
        
        <h1 class="text-muted mb-3">Categories</h1>
        <?= Message::generate(Flash::instance()->get()) ?>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Actions</th>
                    <td><a href="<?= $router->generateUri('admin.category.create')?>" class="btn btn-primary btn-sm">Nouveau</a></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                <tr>
                    <td><a href="<?= $router->generateUri('admin.categories.show', [
                        'id' =>$category->getId()
                    ]) ?>" style="text-decoration: none; opacity: .80;" title="Voir la categorie <?= e($category->getCategory())  ?>"><?= e($category->getCategory()) ?></a>
                    <td>
                        <div class="btn-group">
                            <a href="<?= $router->generateUri('admin.category.editer', [
                                'id' =>$category->getId()
                            ]) ?>" class="btn btn-sm btn-secondary" style="font-size: 14px;"> Editer</a>
                            <form action="<?= $router->generateUri('admin.category.delete', [
                                'id' =>$category->getId()
                            ]) ?>" method="post" style="display: inline-block;">
                                <button type="submit" class="btn btn-sm btn-danger" style="font-size: 14px;" onclick="return confirm('Vous voulez vraiment supprimer cette categorie ? ')">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach  ?>
            </tbody>
        </table>
        <nav class="pagination pagines">
            <ul class="pagination pagination-sm"><?= $paginate ?></ul>
        </nav>
    </div>
</div>

