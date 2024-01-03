<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)

use App\Controller\BlogController;

return [
    '' => ['HomeController', 'index',],
    'privacypolicy' => ['HomeController', 'privacypolicy'],
    'explorer' =>  ['BlogController', 'explorer'],
    'profil' => ['BlogController', 'index'],
    'profil/blog/create' => ['BlogController', 'add', ['idUser']],
    'blog/show' => ['BlogController', 'show', ['idBlog']],
    'blog/delete' => ['BlogController', 'delete', ['idBlog']],
    'items' => ['ItemController', 'index',],
    'items/edit' => ['ItemController', 'edit', ['id']],
    'items/show' => ['ItemController', 'show', ['id']],
    'items/add' => ['ItemController', 'add',],
    'items/delete' => ['ItemController', 'delete',],
    'signup' => ['UserController', 'signup'],
    'login' => ['UserController','login'],
    'logout' => ['UserController', 'logout'],
    'article/create' => ['ArticleController', 'create', ['id']]
];
