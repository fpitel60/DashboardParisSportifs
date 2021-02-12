<?php

namespace App\Service\ChoiceBet;

use App\Repository\GameRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ChoiceBetService {

    protected $session;
    protected $gameRepository;

    public function __construct(SessionInterface $session, GameRepository $gameRepository)
    {
        $this->session = $session;
        $this->gameRepository = $gameRepository;
    }

    public function add(int $id) {
        $cart = $this->session->get('cart', []);

        $cart[$id] = 1;

        $this->session->set('cart', $cart);
    }

    public function remove(int $id) {
        $cart = $this->session->get('cart', []);

        if(!empty($cart[$id])){
            unset($cart[$id]);
        }

        $this->session->set('cart', $cart);
    }

    public function getFullCart(): array {
        $cart = $this->session->get('cart', []);

        $cartWithData = [];

        foreach($cart as $id => $quantity)
        {
            $cartWithData[] = [
                'game' => $this->gameRepository->find($id),
                'quantity' => $quantity
            ];
        }

        return $cartWithData;
    }
}