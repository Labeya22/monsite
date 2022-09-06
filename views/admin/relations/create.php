<?php

use App\Flash;
use App\Message;
use App\Form;

$title = "Création d'une relation" ;

$form = new Form($relation, $errors);

// dump($errors);

?>

<div class="row">
    <h2 class="text-dark mb-5"><?= $title ?></h2>
    <?= Message::generate(Flash::instance()->get()) ?>
    <div class="col-md-10">
        <form action="" method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-2"><?= $form->field('post_id', 'article', ['holder' => 'Choississez un article', 'type' => 'select', 'database' => [
                        'content' => 'name',
                        'value' => 'id',
                        'data' => $posts
                    ]]) ?></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-2"><?= $form->field('category_id', 'Categorie', ['holder' => 'Choississez une categorie', 'type' => 'select', 'database' => [
                        'content' => 'category',
                        'value' => 'id',
                        'data' => $categories
                    ]]) ?></div>
                </div>
            </div>
            <?= $form->submit('Créer une relation') ?>
        </form>
    </div>

</div>


