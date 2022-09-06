<?php

use App\Flash;
use App\Form;
use App\Message;

$form = new Form($user, $errors);

?>

<div class="row justify-content-center gy-3  ">
    <div class="col-md-4">
        <?= Message::generate(Flash::instance()->get()) ?>
        <form action="" method="post" class="shadow p-5 bg-white">
            <h2 class="text-muted">Se connecter</h2>
            <div class="form-group mb-2"><?= $form->field('username', 'Nom d\'utilisateur', ['holder' => 'Entrer votre nom d\'utilisateur']) ?></div>
            <div class="form-group mb-2"><?= $form->field('password', 'Mot de passe', ['holder' => 'Entrer votre mot de passes']) ?></div>
            <?= $form->submit('Se connecter') ?>
        </form>
    </div>
</div>