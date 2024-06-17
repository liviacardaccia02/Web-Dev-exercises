function rgb2hex(orig) {
    let rgb = orig.replace(/\s/g, '').match(/^rgba?\((\d+),(\d+),(\d+)/i);
    return (rgb && rgb.length === 4) ? "#" +
        ("0" + parseInt(rgb[1], 10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[2], 10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[3], 10).toString(16)).slice(-2) : orig;
}

window.onload = function () {
    let caricaDati = document.getElementsByTagName("button")[0];
    let text = document.getElementsByTagName("p")[0];
    let table = document.getElementsByTagName("table")[0];


    caricaDati.addEventListener("click", function () {
        text.innerHTML = "Caricamento dati in corso...";

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let data = JSON.parse(this.response);

                createTable(data);
            }
        }
        xhr.open("GET", "sw_a.json", true);
        xhr.send();
    });

    function createTable(data) {
        table.innerHTML = "";
        text.textContent = "";

        const thead = document.createElement("thead");
        const headerRow = document.createElement("tr");

        const attributes = Object.keys(data[0]);

        attributes.forEach(attribute => {
            const th = document.createElement("th");
            th.textContent = attribute;
            headerRow.appendChild(th);
        });

        const action = document.createElement("th");
        action.textContent = "Azione";

        headerRow.appendChild(action);
        thead.appendChild(headerRow);
        table.appendChild(thead);

        const tbody = document.createElement("tbody");

        data.forEach(item => {
            const row = document.createElement("tr");
            const actionCell = document.createElement("td");
            const modificaRiga = document.createElement("button");
            modificaRiga.textContent = "Modifica Riga";

            attributes.forEach(attribute => {
                const cell = document.createElement("td");
                if (attribute == "colore_preferito") {
                    cell.style.backgroundColor = item.colore_preferito;
                } else {
                    cell.textContent = item[attribute];
                }
                row.appendChild(cell);

                modificaRiga.addEventListener("click", function () {
                    makeRowEditable(row, attribute);
                });
            });

            actionCell.appendChild(modificaRiga);
            row.appendChild(actionCell);
            tbody.appendChild(row);
        });

        table.appendChild(tbody);
        text.textContent = "Caricamento dei dati avvenuto con successo";
    }

    function makeRowEditable(row, attributes) {
        row.querySelectorAll("td").forEach((cell, index) => {
            if (index < attributes.length && index != attributes.length - 1) {
                const input = document.createElement("input");
                input.value = cell.textContent;

                if (attributes[index] === "email") {
                    input.type = "email";
                } else if (attributes[index] === "colore_preferito") {
                    input.type = "color";
                } else {
                    input.type = "text";
                }

                cell.textContent = "";
                cell.appendChild(input);
            }
        });
    }
}