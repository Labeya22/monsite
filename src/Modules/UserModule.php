<?php

namespace Modules;

use App\Auth;
use App\Cookie;
use App\Flash;
use App\Routes\Router;
use App\Renderer\Renderer;
use Config\Config;
use Mapping\User;
use Tables\UserTable;
use Validations\UserValidator;

class UserModule {

    /**
     * @var Renderer
     */
    private $renderer;

    /**
     * @var Router
     */
    private $router;

    private $user;


    /**
     * @param Renderer $render
     * @param Router $router
     */
    public function __construct(Renderer $render, Router $router)
    {
        $this->renderer = $render;
        $this->router = $router;
        


        $this->router->both('/login', [$this, 'login'], 'auth.index');
        $this->router->both('/logout', [$this, 'logout'], 'auth.logout');


        $this->user = new UserTable(Config::getPDO());


        Auth::route($this->router);


        // Auth::check();
    }


    public function login()
    {
        Auth::ok();

        $user = new User();
        $errors = [];

        if (!empty($_POST)) {
            hydrate($user, $_POST, ['username', 'password']);
            $validator = new UserValidator($_POST);

            if (!$validator->validate()) {
                $errors = $validator->getErrors();
            } else {
                $username = $this->user->find('username', $user->getUsername());
                if (!empty($username)) {
                    if (password_verify($user->getPassword(), $username[0]->getPassword())) {
                        Auth::instance()->write('auth', $username[0]);
                        Flash::instance()->write('success', 'vous êtes connecter ' . $user->getUsername());
                        r($this->router->generateUri('admin.index'));
                    } else {
                        $errors['password'][] = 'Mot de passe incorrect';
                    }
                } else {
                    $errors['username'][] = 'nom d\'utilisateur incorrect';
                }
            }
        }

        return $this->renderer->render('user/index', compact('user', 'errors'), 'user');
    }

    public function logout()
    {
        Auth::check();
        Auth::remove('auth');
        Flash::instance()->write('success', 'Vous êtes déconnecter');
        r($this->router->generateUri('auth.index'));
    }
}