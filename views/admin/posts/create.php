<?php

use App\Flash;
use App\Message;
use App\Form;

$title = "Création d'un article" ;

// dd($errors);
$form = new Form($post, $errors);

?>

<div class="row">
    <h2 class="text-dark mb-5"><?= $title ?></h2>
    <?= Message::generate(Flash::instance()->get()) ?>
    <div class="col-md-5">
        <form action="" method="post">
            <div class="form-group mb-2"><?= $form->field('name', 'article', ['holder' => 'Entrer un article']) ?></div>
            <div class="form-group mb-2"><?= $form->field('content', 'contenu', ['type' => 'textarea']) ?></div>
            <?= $form->submit('Créer') ?>
        </form>
    </div>

</div>