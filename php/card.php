<?php

class Card //создание новой карты, или их характеристики
{
    private $id;
    private $name;
    private $hp;
    private $damage;
    private $description;
    private $image;
    private $ability;

    public function __construct($id, $name, $hp, $damage, $description, $image, $ability = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->hp = $hp;
        $this->damage = $damage;
        $this->description = $description;
        $this->image = $image;
        $this->ability = $ability;
    }

    public function set() //безопасный метод получения данных, при котором пользователь не сможет изменить данные
    {
        return [$this->id => [
            'id' => $this->id,
            'name' => $this->name,
            'hp' => $this->hp,
            'damage' => $this->damage,
            'description' => $this->description,
            'image' => $this->image,
            'ability' => $this->ability
        ]];
    }
}
//пример



function findAllCard($idAllCard, $idCardDeck)
{
    if ($idAllCard) {
        $cardAll = array();
        $cardDeck = array();

        $card[0] = new Card(0, 'ZeroTwo', 5, 5, 'Ебусь в очко карасем', 'image/124u79y12', 3);
        $card[1] = new Card(1, 'Eren Yeager', 10, 10, 'Когда набухается, становиться титаном', 'image/gjadsfkl');

        foreach ($idAllCard as $value) {
            if (isset($card[$value])) {
                $cardAll[$value] = $card[$value]->set();
            }
        }
        foreach ($idCardDeck as $value) {
            if (isset($cardAll[$value])) {
                $cardDeck[$value] = $card[$value]->set();
            }
        }

        $returnCard = ['allCard' => $cardAll, 'cardDeck' => $cardDeck];

        return $returnCard;
    } else {
        return null;
    }
}
echo '<pre>';
var_dump(findAllCard([0, 1, 4], [1, 3]));
echo '</pre>';
//findAllCard([0, 1], [0]);