<?php

use App\Flash;
use App\Message;

$title = 'administration accueil';
?>
<h2 class="mb-5">Administration</h2>
<div class="row">
    <div class="col-md-6">
    <?= Message::generate(Flash::instance()->get()) ?>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5>Gestion des categorie</h5>
                <p class="text-muted">Les categories va faciliter à l'utilisateur de tier les articles par categorie.</p>
                <a href="<?= $router->generateUri('admin.categories.index') ?>">voir plus</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5>Gestion des articles </h5>
                <p class="text-muted">Les articles que les utilisateurs pourront voir.</p>
                <a href="<?= $router->generateUri('admin.posts.index') ?>">voir plus</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5>Gestion des relations </h5>
                <p class="text-muted">Relation des articles qui sont associées à des categories.</p>
                <a href="<?= $router->generateUri('admin.relations.index') ?>">voir plus</a>
            </div>
        </div>
    </div>
</div>