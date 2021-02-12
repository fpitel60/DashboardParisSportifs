<?php

namespace App\Menu;

use App\Entity\Sport;
use Knp\Menu\ItemInterface;
use Knp\Menu\FactoryInterface;
use Psr\Container\ContainerInterface;

class MenuBuilder
{
    private $factory;
    private $container; 

    /**
     * Add any other dependency you need...
     */
    public function __construct(FactoryInterface $factory, ContainerInterface $container)
    {
        $this->factory = $factory;
        $this->container = $container; 
    }

    public function createMainMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'navbar-nav');

        // access services from the container!
        $em = $this->container->get('doctrine')->getManager();
        //$em = $this->getDoctrine()->getManager();
        $sports = $em->getRepository(Sport::class)->findAll();

        foreach ($sports as $sport) {
            $menu->addChild($sport->getName(), [
                'route' => 'listegame',
                'routeParameters' => ['sportid' => $sport->getId()]
            ]);
            $leagues = $sport->getLeagues();
            foreach ($leagues as $league) {
                $menu->addChild($league->getName(), [
                    'route' => 'listegame',
                    'routeParameters' => ['sportid' => $sport->getId(), 'leagueid' => $league->getId()]
                ]);
            }
        }

        return $menu;
    }
}