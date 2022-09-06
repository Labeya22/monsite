<?php

use App\Flash;
use App\Message;

$title = 'administration des relations';

?>

<div class="row mb-3 justify-content-center gy-3">
    <div class="col-md-10">
        
        <h1 class="text-muted mb-3">Relations</h1>
        <?= Message::generate(Flash::instance()->get()) ?>
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th>Article</th>
                    <th>Categorie</th>
                    <td><a href="<?= $router->generateUri('admin.relation.create')?>" class="btn btn-primary btn-sm">Nouveau</a></td>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($relations as $relation): ?>
                <tr>
                    <td><?= $relation->getName() ?></td>
                    <td><?= $relation->getCategory() ?></td>
                    <td>
                        <div class="btn-group btn-sm">
                            <a href="<?= $router->generateUri('admin.relation.editer', [
                                'id' => $relation->getId()
                            ]) ?>" class="btn btn-sm btn-primary" style="font-size: 14px;"> Editer</a>
                            <form action="<?= $router->generateUri('admin.relation.delete', [
                                'id' => $relation->getId()
                            ]) ?>" method="post" style="display: inline-block;">
                                <button type="submit" class="btn btn-sm btn-danger" style="font-size: 14px;" onclick="return confirm('Vous voulez vraiment supprimer cet article ? ')">Supprimer</button>
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

