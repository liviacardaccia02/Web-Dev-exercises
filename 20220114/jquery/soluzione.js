function createMatrix(rows, cols) {
    let matrix = [];
    for (i = 0; i < rows; i++) {
        let row = [];
        for (j = 0; j < cols; j++) {
            row.push(Math.floor(Math.random() * 2) + 1);
        }
        matrix.push(row);
    }
    return matrix;
}

function createTable(table, matrix) {
    console.log(matrix);
    for (let i = 0; i < matrix.length; i++) {
        let tr = document.createElement('tr');
        for (let j = 0; j < matrix[i].length; j++) {
            let td = document.createElement('td');
            td.textContent = matrix[i][j];
            if (matrix[i][j] == 1) {
                td.style.backgroundColor = 'red';
            } else {
                td.style.backgroundColor = 'blue';
            }
            tr.appendChild(td);

            td.addEventListener('click', function () {
                td.style.backgroundColor = table.style.backgroundColor;
                matrix[i][j] = 0;
            });
        }
        table.appendChild(tr);
    }
    return table;
}

function updateTable(table, matrix) {
    table.innerHTML = "";
    for (let i = 0; i < matrix.length; i++) {
        let tr = document.createElement('tr');
        for (let j = 0; j < matrix[i].length; j++) {
            let td = document.createElement('td');
            td.textContent = matrix[i][j];
            if (matrix[i][j] == 0) {
                td.style.backgroundColor = 'red';
            }
            tr.appendChild(td);
        }
        table.appendChild(tr);

    }
}

window.onload = function () {
    let rows = 6, cols = 7;
    let table1 = document.getElementsByTagName("table")[0];
    let button = document.querySelector('button');
    let matrix = createMatrix(rows, cols);

    createTable(table1, matrix);

    button.addEventListener('click', function () {
        let copia = document.getElementsByClassName("copia")[0].children[0];
        copia.innerHTML = "";

        for (let i = 0; i < matrix.length; i++) {
            let row = document.createElement("tr");
            for (let j = 0; j < matrix[i].length; j++) {
                let cell = document.createElement("td");

                if (matrix[i][j] == 0) {
                    cell.style.backgroundColor = 'red';
                }

                row.appendChild(cell);
            }
            copia.appendChild(row);
        }
    });

}