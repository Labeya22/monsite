<?php

use App\Flash;
use App\Message;

$title = 'administration des articles';

?>

<div class="row mb-3 justify-content-center gy-3">
    <div class="col-md-10">
        
        <h1 class="text-muted mb-3">Articles</h1>
        <?= Message::generate(Flash::instance()->get()) ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Actions</th>
                    <td><a href="<?= $router->generateUri('admin.post.create')?>" class="btn btn-primary btn-sm">Nouveau</a></td>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                <tr>
                    <td><a href="<?= $router->generateUri('admin.posts.show', [
                        'id' => $post->getId()
                    ]) ?>" style="text-decoration: none; opacity: .80;" title="Voir l'article <?= e($post->getName())  ?>"><?= e($post->getName()) ?></a>
                    <td>
                        <div class="btn-group">
                            <a href="<?= $router->generateUri('admin.post.editer', [
                                'id' => $post->getId()
                            ]) ?>" class="btn btn-sm btn-secondary" style="font-size: 14px;"> Editer</a>
                            <form action="<?= $router->generateUri('admin.post.delete', [
                                'id' => $post->getId()
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

