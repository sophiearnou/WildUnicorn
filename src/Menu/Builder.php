<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\Security;

class Builder
{
    private $factory;
    private $security;

    public function __construct(FactoryInterface $factory, Security $security)
    {
        $this->factory = $factory;
        $this->security = $security;
    }

    /**
     * Méthode appelée pour gérer le menu mainMenu
     */
    public function mainMenu(array $options)
    {
        $menu = $this->factory->createItem("root");

        // Ajout d'élèments dans le menu
        $menu->addChild("menu.accueil", [
            "route" => "home",
        ]);
        $menu->addChild("menu.concert", [
            "route" => "event_index",
        ]);
        
        // Si ROLE_ADMIN affiche menu Administration sinon il ne s'affichera pas pour ROLE_USER
        if ($this->security->isGranted("ROLE_ADMIN")) {
            $menu->addChild("menu.administration", [
                "route" => "admin",
            ]);
        }

        // Ajout de menu "Se connecter" ou "Se déconnecter" en fonction si utilisateur connecté ou non

        if (!$this->security->isGranted("IS_AUTHENTICATED_REMEMBERED")) {

            $menu->addChild("menu.login", [
                "route" => "app_login",
            ]);

        }

        if ($this->security->isGranted("IS_AUTHENTICATED_REMEMBERED")) {
            $menu->addChild("menu.logout", [
                "route" => "app_logout",
            ]);
        }



        return $menu;
    }


    /**
     * Méthode appelée pour gérer le menu mainMenu
     */
    public function adminMenu(array $options)
    {
        $menu = $this->factory->createItem("root");

        // Ajout d'élèments dans le menu
        $menu->addChild("adminMenu.event", [
            "route" => "admin",
        ]);
        $menu->addChild("adminMenu.category", [
            "route" => "admin_category",
        ]);
        $menu->addChild("adminMenu.image", [
            "route" => "admin_image",
        ]);
        $menu->addChild("adminMenu.user", [
            "route" => "admin_user",
        ]);
        $menu->addChild("adminMenu.logout", [
            "route" => "app_logout",
        ]);


        return $menu;
    }
}
