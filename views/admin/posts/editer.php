<?php

use App\Flash;
use App\Message;
use App\Form;

$title = "Editer l'article #{$post[0]->getId()}" ;

// dd($errors);
$form = new Form($post[0], $errors);

?>

<div class="row">
    <h2 class="text-dark mb-5"><?= $title ?></h2>
    <?= Message::generate(Flash::instance()->get()) ?>
    <div class="col-md-5">
        <form action="" method="post">
            <div class="form-group mb-2"><?= $form->field('name', 'article', ['holder' => 'Entrer un article']) ?></div>
            <div class="form-group mb-2"><?= $form->field('createAt', 'createAt', ['holder' => 'date de création']) ?></div>
            <div class="form-group mb-2"><?= $form->field('content', 'contenu', ['type' => 'textarea']) ?></div>
            <?= $form->submit('Editer') ?>
        </form>
    </div>

</div>