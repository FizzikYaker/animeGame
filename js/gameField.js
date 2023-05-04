// // получение ширины и высоты экрана
// let WindowHeight = document.documentElement.clientHeight;
// let WindowWidth = document.documentElement.clientWidth;
// // высота экрана
// document.getElementById('main').style.height = WindowHeight - 60 + "px";
// // разграничивание всего экрана на правую и левую части
// document.getElementById('field_right').style.width = WindowWidth * 0.625 + "px";
// document.getElementById('field_left').style.width = WindowWidth * 0.375 + "px";
// // высота и ширина игрового поля справа
// document.getElementById('field_right_div').style.height = (WindowHeight - 60) * 0.5 + "px";
// document.getElementById('field_right_div').style.width = WindowWidth * 0.625 + "px";
// // высота и ширина карточек на поле
// let card = document.getElementsByClassName('cards');
// for (let i = 0; i <= 21; i++) {
//     card[i].style.width = WindowWidth * 0.06 + "px";
//     card[i].style.height = (WindowHeight - 60) * 0.2 + "px";
// }
// // кнопка справа
// document.getElementById('button_stop').style.width = WindowWidth * 0.05 + "px";
// document.getElementById('button_stop').style.height = WindowWidth * 0.05 + "px";
// console.log("gljhgeghekgueiulghewklrugh");



// Тестовый класс карт
// class Card {
//     constructor(id, name, hp, mana, damege, img, description, ability) {
//         this.id = id;
//         this.name = name;
//         this.hp = hp;
//         this.mana = mana;
//         this.damege = damege;
//         this.img = img;
//         this.description = description;
//         this.ability = ability;
//     }

//     static Damage(card_1, card_2) {
//         card_1.hp = card_1.hp - card_2.damege;
//         card_2.hp = card_2.hp - card_1.damege;

//         return ([card_1.hp, card_2.hp]);
//     }
// }



const allCards = [[1, "sfsfsfsf", 10, 3, 3, "img/protorype1.jpg", "esghhglkehg", "leijeij"],
[1, "sfsfsfsf", 10, 3, 5, "img/protorype1.jpg", "esghhglkehg", "leijeij"]] //масив со всеми картами



// let card1 = new Card(1, "sfsfsfsf", 10, 3, 3, "src/fff/fgh.png", "esghhglkehg", "leijeij");
// let card2 = new Card(1, "sfsfsfsf", 10, 3, 5, "src/fff/fgh.png", "esghhglkehg", "leijeij");
// console.dir(Card.Damage(card1, card2));

let elem = document.getElementById('pop');
function DrawCard(id, card) { //куда рисовать будет поле с пронумироваными дивами по номеру дива и ресуем
    //let elem = document.getElementById(id);
    elem.insertAdjacentHTML('afterend', `<div class="m-1" id="jjj"> <div class="cards"> <img style="width:100%; height: 55%; object-fit: cover;" src="${card[5]}"><ul><li>Имя: ${card[1]}</li><li> мана: ${card[4]}</li><li>Здоровье: ${card[3]}</li><li>дамаг: ${card[6]}</li></ul></div></div>`);
}
DrawCard(1, allCards[1]);

function RedrawMana(my, enemy) {
    // у элементов с этими ид текст меняеться на ману каждый раз когда вызываем функцию
    document.getElementById('text_Mana_My').textContent = my;
    document.getElementById('text_Mana_Enemy').textContent = enemy;
}
RedrawMana(3, 5);

function RedrawHp(my, enemy) {
    // у элементов с этими ид текст меняеться на ману каждый раз когда вызываем функцию
    document.getElementById('text_Hp_My').textContent = my;
    document.getElementById('text_Hp_Enemy').textContent = enemy;
}
RedrawHp(50, 10);

function PrintLogin(my, enemy) {
    // у элементов с этими ид текст меняеться на ману каждый раз когда вызываем функцию
    document.getElementById('text_nik_My').textContent = my;
    document.getElementById('text_nik_Enemy').textContent = enemy;
}
PrintLogin("My", "Enemy");



//перемещение
var div = document.getElementById('circle');
var listener = function (e) {

    div.style.left = e.pageX - 50 + "px";
    div.style.top = e.pageY - 50 + "px";
};

addEventListener('mousedown', e => {
    console.log(e.target.id);
    if (e.target.id == "circle") { // здесь вставить проверки для всех дивов на руке
        div = document.getElementById('circle')
        document.addEventListener('mousemove', listener);
    } else if (e.target.id == "circle2") {
        div = document.getElementById('circle2')
        document.addEventListener('mousemove', listener);
    } else {
        e.preventDefault();
    }
});

addEventListener('mouseup', e => {
    div.style.display = "none";
    var elementUnderMouse = document.elementFromPoint(e.clientX, e.clientY);
    if (elementUnderMouse.id == "pop") {
        let a = div.cloneNode(true);
        elem.insertAdjacentHTML('afterend', a);
        console.dir(a);
        //запуск функции перемещения карты
    } else {
        let a = div.cloneNode(true);
        //запуск функции возвращения обекта
    }
    div.style.display = "block";
    document.removeEventListener('mousemove', listener);
});

function MoveCard(div, id) {
    // копирует хтмл дива и вставляет туда куда положили
}

function RetyrnCard(div, id) {
    // копирует хтмл дива и возвращяет туда от куда взяли
}