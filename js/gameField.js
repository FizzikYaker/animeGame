




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
[2, "sfsfsfsf", 10, 3, 5, "img/protorype1.jpg", "esghhglkehg", "leijeij"],
[3, "sfsfsfsf", 2, 5, 6, "img/protorype1.jpg", "esghhglkehg", "leijeij"],
[4, "sfsfsfsf", 8, 3, 7, "img/protorype1.jpg", "esghhglkehg", "leijeij"],
[5, "sfsfsfsf", 10, 3, 3, "img/protorype1.jpg", "esghhglkehg", "leijeij"],
[6, "sfsfsfsf", 10, 3, 5, "img/protorype1.jpg", "esghhglkehg", "leijeij"],
[7, "sfsfsfsf", 2, 5, 6, "img/protorype1.jpg", "esghhglkehg", "leijeij"],
[8, "sfsfsfsf", 8, 3, 7, "img/protorype1.jpg", "esghhglkehg", "leijeij"],
[9, "sfsfsfsf", 10, 3, 3, "img/protorype1.jpg", "esghhglkehg", "leijeij"],
[10, "sfsfsfsf", 10, 3, 5, "img/protorype1.jpg", "esghhglkehg", "leijeij"],
[11, "sfsfsfsf", 2, 5, 6, "img/protorype1.jpg", "esghhglkehg", "leijeij"],
[12, "sfsfsfsf", 8, 3, 7, "img/protorype1.jpg", "esghhglkehg", "leijeij"],
[13, "sfsfsfsf", 10, 3, 3, "img/protorype1.jpg", "esghhglkehg", "leijeij"]] //масив со всеми картами



// let card1 = new Card(1, "sfsfsfsf", 10, 3, 3, "src/fff/fgh.png", "esghhglkehg", "leijeij");
// let card2 = new Card(1, "sfsfsfsf", 10, 3, 5, "src/fff/fgh.png", "esghhglkehg", "leijeij");
// console.dir(Card.Damage(card1, card2));


// const statusElement = document.getElementById('status'); // получения статуса игры
// const restartButton = document.getElementById('restart');
// const button_stop = document.getElementById('button_stop');// получение кнопки хода
// let user_id = document.getElementById('id');
// user_id = user_id.textContent;
// let user_login = document.getElementById('login');
// user_login = user_login.textContent;
// const socket = new WebSocket('ws://localhost:7070?user_id=' + encodeURIComponent(user_id) + '&login=' + encodeURIComponent(user_login));

// socket.onmessage = function (event) {
//     const data = JSON.parse(event.data);

//     if (data.type === 'start') {
//         console.dir(data);
//         for (let i = 0; i <= 3; ++i) {
//             DrawCard(i, allCards[data.hand[i]]);
//             // второму юзеру дать пустышки на руку
//         }
//         // раздать логин опонента
//     } else if (data.type === 'end') {
//         // передать награды и закончить

//     } else if (data.type === 'restart') {
//         // хз что это

//     } else if (data.type === 'enemy_atak') {
//         //  выставить карты врага и дать выставить свои карты

//     } else if (data.type === 'enemy_deff') {
//         // выставить карты врага и начать анимацию атаки 

//     } else if (data.type === 'my_atakk') {
//         // дать выстовить свои карты и начать атаку

//     }
// }



let field = [0, 0, 0, 0, 0, 0];//первое число количество карт отправка данных карт на поле при нажатии на кнопку хода !!!!!!!!!!!! заблокировать ход
// button_stop.addEventListener('mousedown', e => {
//     socket.send(JSON.stringify(field));
// });



DrawCard(1, allCards[1]);
DrawCard(2, allCards[2]);

function DrawCard(id, card) { //куда рисовать будет поле с пронумироваными дивами по номеру дива и ресуем
    console.log(id);
    let elem = document.getElementById(id);
    elem.insertAdjacentHTML('afterbegin', `<div class="m-1" id="C${id}" onmousedown="Drag(this)" data-id="${card[0]}" data-oldPoz="-1"> <div class="cards" " id="M${id}"> <img style="width:100%; height: 55%; object-fit: cover;" src="${card[5]}"><ul><li>Имя: ${card[1]}</li><li> мана: ${card[4]}</li><li>Здоровье: ${card[3]}</li><li>дамаг: ${card[6]}</li></ul></div></div>`);
}

function RedrawMana(my, enemy) {
    // у элементов с этими ид текст меняеться на ману каждый раз когда вызываем функцию
    document.getElementById('text_Mana_My').textContent = my;
    document.getElementById('text_Mana_Enemy').textContent = enemy;
}
RedrawMana(3, 5);

function RedrawHp(my, enemy) {
    // у элементов с этими ид текст меняеться на хп каждый раз когда вызываем функцию
    document.getElementById('text_Hp_My').textContent = my;
    document.getElementById('text_Hp_Enemy').textContent = enemy;
}
RedrawHp(50, 10);

function PrintLogin(my, enemy) {
    // у элементов с этими ид текст меняеться на логин каждый раз когда вызываем функцию
    document.getElementById('text_nik_My').textContent = my;
    document.getElementById('text_nik_Enemy').textContent = enemy;
}
PrintLogin("My", "Enemy");



//перемещение
var div;
var checkDraw = false;
var elemUnderMouse = 0;
var x = 0;// координаты мыши
var y = 0;
var listener = function (e) {
    x = e.clientX;
    y = e.clientY;
    div.style.left = e.pageX - 50 + "px";
    div.style.top = e.pageY - 50 + "px";
};

function Drag(elem) {
    if (checkDraw == false) {
        div = document.getElementById(elem.id)
        div.style.position = "absolute";
        document.addEventListener('mousemove', listener);
        checkDraw = true;
    } else {
        div.style.display = "none";
        div.style.position = "";

        if (document.elementFromPoint(x, y).id == "myField") {// либо проверять ид боксов
            div.style.display = "block";
            MoveCard(div, x);
            //запуск функции перемещения карты
        } else {
            div.style.display = "block";
            // возвращения обекта
        }
        document.removeEventListener('mousemove', listener);
        checkDraw = false;
    }
}

var myField = document.getElementById("myField");
var myFieldDiv = document.getElementById("myFieldDiv");
function MoveCard(div, x) {


    div.remove();
    if (field[0] != 0) {
        field[0] += 1;
        myFieldDiv.style.width = `${field[0] * 18}%`;
        var coord = myFieldDiv.getBoundingClientRect();
        console.log(coord.left);
        console.log(x);
        if (coord.left > x) {
            console.log("вставляем в начало");
            myFieldDiv.prepend(div.cloneNode(true));
        } else {
            console.log("вставляем в конец");
            myFieldDiv.appendChild(div.cloneNode(true));
        }
    } else {
        field[0] += 1;
        myFieldDiv.style.width = `${field[0] * 18}%`;
        myFieldDiv.appendChild(div.cloneNode(true));
    }

    //let a = div.cloneNode(true);
    // if (div.dataset.oldPoz != "-1") {
    //     field[div.dataset.oldPoz] = 0;
    // }

    // if (elementUnderMouse.id == "10") {
    //     field[0] = div.dataset.id;
    //     div.dataset.oldPoz = 0;
    // } else if (elementUnderMouse.id == "20") {
    //     field[1] = div.dataset.id;
    //     div.dataset.oldPoz = 1;
    // } else if (elementUnderMouse.id == "30") {
    //     field[2] = div.dataset.id;
    //     div.dataset.oldPoz = 2;
    // } else if (elementUnderMouse.id == "40") {
    //     field[3] = div.dataset.id;
    //     div.dataset.oldPoz = 3;
    // } else {
    //     field[4] = div.dataset.id;
    //     div.dataset.oldPoz = 4;
    // }
    // console.dir(field);
    // div.remove();
    // elementUnderMouse.appendChild(div.cloneNode(true));// здесь сообщять о премещении
    // // копирует хтмл дива и вставляет туда куда положили
}
