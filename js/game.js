const statusElement = document.getElementById('status'); // получения статуса игры
const cells = document.querySelectorAll('[data-cell]'); //Все клетки
const restartButton = document.getElementById('restart');

const socket = new WebSocket('ws://localhost:7070');
let myTurn = false;
let mySymbol = '';

socket.onmessage = function (event) {
    const data = JSON.parse(event.data);

    if (data.type === 'start') {
        mySymbol = data.symbol;
        console.log(data.symbol + " " + data.index + " start");
        statusElement.textContent = mySymbol === 'X' ? 'Ваш ход' : 'Ход противника';
        myTurn = mySymbol === 'X';
    } else if (data.type === 'move') {
        console.log(data.symbol + " " + data.index + " move");
        const cell = cells[data.index];
        cell.textContent = data.symbol;
        myTurn = !myTurn;

        if (checkWin(data.symbol)) {
            statusElement.textContent = 'Противник выиграл';
            restartButton.style.display = 'block';
            return;
        }

        if (checkDraw()) {
            statusElement.textContent = 'Ничья';
            restartButton.style.display = 'block';
            return;
        }

        statusElement.textContent = myTurn ? 'Ваш ход' : 'Ход противника';
    } else if (data.type === 'end') {
        if (data.status === 'win') {
            statusElement.textContent = 'Противник выиграл';
        } else if (data.status === 'draw') {
            statusElement.textContent = 'Ничья';
        }
        restartButton.style.display = 'block';
    } else if (data.type === 'restart') {
        resetBoard();
        mySymbol = mySymbol === 'X' ? 'O' : 'X';
        myTurn = mySymbol === 'X';
        statusElement.textContent = myTurn ? 'Ваш ход' : 'Ход противника';
    }
};


function checkWin(symbol) {
    const board = Array.from(cells).map(cell => cell.textContent);
    const winConditions = [
        [0, 1, 2],
        [3, 4, 5],
        [6, 7, 8],
        [0, 3, 6],
        [1, 4, 7],
        [2, 5, 8],
        [0, 4, 8],
        [2, 4, 6]
    ];

    return winConditions.some(condition => condition.every(index => board[index] === symbol));
}

function checkDraw() {
    return Array.from(cells).every(cell => cell.textContent);
}

cells.forEach((cell, index) => {
    cell.addEventListener('click', () => {
        if (!myTurn || cell.textContent) return;

        cell.textContent = mySymbol;
        console.log(cell.textContent);
        myTurn = false;

        if (checkWin(mySymbol)) { //Проверка на выйгрышь или ничью
            statusElement.textContent = 'Вы выиграли!';
            socket.send(JSON.stringify({ type: 'end', status: 'win' }));
            return;
        }

        if (checkDraw()) {
            statusElement.textContent = 'Ничья';
            socket.send(JSON.stringify({ type: 'end', status: 'draw' }));
            return;
        }

        statusElement.textContent = 'Ход противника';
        socket.send(JSON.stringify({ type: 'move', symbol: mySymbol, index }));
    });
});

function resetBoard() {
    cells.forEach(cell => {
        cell.textContent = '';
    });
}


restartButton.addEventListener('click', () => {
    resetBoard();
    restartButton.style.display = 'none';
    statusElement.textContent = 'Ожидание игрока...';
    socket.send(JSON.stringify({ type: 'restart' }));
});