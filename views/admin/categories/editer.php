<?php

use App\Flash;
use App\Message;
use App\Form;

$title = "Editer la categorie #{$category[0]->getId()}" ;

// dd($errors);
$form = new Form($category[0], $errors);

?>

<div class="row">
    <h2 class="text-dark mb-5"><?= $title ?></h2>
    <?= Message::generate(Flash::instance()->get()) ?>
    <div class="col-md-5">
        <form action="" method="post">
            <div class="form-group mb-2"><?= $form->field('category', 'categorie', ['holder' => 'Entrer une categorie']) ?></div>
            <div class="form-group mb-2"><?= $form->field('slug', 'slug', ['holder' => 'Entrer un url']) ?></div>
            <div class="form-group mb-2"><?= $form->field('createAt', 'createAt', ['holder' => 'date de création']) ?></div>
            <?= $form->submit('Editer') ?>
        </form>
    </div>

</div>