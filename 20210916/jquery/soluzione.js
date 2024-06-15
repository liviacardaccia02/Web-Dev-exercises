window.onload = function () {
    let main = document.querySelector("main");
    let table = document.createElement("table");
    let tr = document.createElement("tr");
    let log = document.querySelector(".log");

    table.appendChild(tr);
    table.id = "numeri";

    for (let i = 1; i <= 9; i++) {
        let td = document.createElement("td");
        td.textContent = i;
        tr.appendChild(td);
    }

    main.append(table);

    let cells = document.querySelectorAll(".tabellone tr td");

    cells.forEach(function (cell) {
        cell.addEventListener("click", function () {
            if (this.classList.contains('selected')) {
                this.classList.remove('selected');
                this.style.backgroundColor = '#ffffff';
            } else {
                let selectedCells = document.querySelectorAll('.selected');
                selectedCells.forEach(function (selectedCell) {
                    selectedCell.classList.remove('selected');
                    selectedCell.style.backgroundColor = '#ffffff';
                });
                this.classList.add('selected');
                this.style.backgroundColor = '#cacaca';
            }
        });
    });

    let numberedCells = document.querySelectorAll("#numeri tr td");

    numberedCells.forEach(function (cell) {
        cell.addEventListener("click", function () {
            let selectedCells = document.querySelectorAll('.selected');
            if (selectedCells.length == 0) {
                log.textContent = "Cella non selezionata";
            } else {
                selectedCells.forEach(function (selectedCell) {
                    selectedCell.textContent = cell.textContent;
                    log.textContent = "Numero inserito correttamente";
                    selectedCell.style.backgroundColor = '#ffffff';
                    selectedCell.classList.remove('selected');
                });
            }
        });
    });
}
