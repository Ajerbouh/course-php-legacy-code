<?php
/**
 * Created by PhpStorm.
 * User: aminejerbouh
 * Date: 30/04/2019
 * Time: 10:15
 */

use Controller\PagesController;
use Controller\UsersController;
use Core\DbConnection;
use Core\DbConnectionInterface;
use Repository\UserRepository;

return [
    DbConnectionInterface::class => function ($container) {
        $host = $container['config']['database']['host'];
        $driver = $container['config']['database']['driver'];
        $name = $container['config']['database']['name'];
        $user = $container['config']['database']['user'];
        $password = $container['config']['database']['password'];

        return new DbConnection($driver, $host, $name, $user, $password);
    },
    UsersController::class => function ($container) {
        $userModel = $container[UserRepository::class]($container);
        return new UsersController($userModel);
    },
    PagesController::class => function ($container) {
        return new PagesController();
    },
    UserRepository::class => function ($container) {
        $dbConnection = $container[DbConnectionInterface::class]($container);
        return new UserRepository($dbConnection);
    }
];