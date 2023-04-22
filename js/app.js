// document.getElementById('findGame').addEventListener('click', function () {
//     // Отправка запроса на поиск игры
//     socket.send(JSON.stringify({ action: 'find_game' }));
// });

// document.getElementById('playCard').addEventListener('click', function () {
//     // Получить выбранную карту и отправить её на сервер
//     const selectedCard = '...';
//     socket.send(JSON.stringify({ action: 'play_card', card: selectedCard }));
// });

// document.getElementById('endGame').addEventListener('click', function () {
//     // Отправить запрос на завершение игры
//     socket.send(JSON.stringify({ action: 'end_game' }));
// });

// function addToHand(handElement, card) {
//     // Добавить карту в указанную руку (элемент на странице)
//     // Здесь можно добавить код для создания элемента карты и добавления его в handElement
// }

// function removeFromHand(handElement, card) {
//     // Удалить карту из указанной руки (элемент на странице)
//     // Здесь можно добавить код для поиска элемента карты в handElement и удаления его
// }

// function startGame() {
//     // Показать игровой контейнер и скрыть кнопку "Найти игру"
//     document.getElementById('gameContainer').style.display = 'block';
//     document.getElementById('findGame').style.display = 'none';

//     // Инициализация карт и элементов игры
// }

// function playOpponentCard(card) {
//     // Добавить карту противника в руку противника и удалить карту из вашей руки
//     addToHand(document.getElementById('opponentHand'), card);
//     removeFromHand(document.getElementById('playerHand'), card);
// }