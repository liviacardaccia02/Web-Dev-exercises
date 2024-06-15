window.onload = function () {
    var form = document.querySelector('form');
    form.style.display = 'none';

    var spans = document.querySelectorAll('span');
    spans.forEach(span => {
        span.style.display = 'none';
    });

    var buttons = document.querySelectorAll('button');
    buttons.forEach(button => {
        if (button.textContent == "Valuta Soluzione") {
            button.style.display = 'none';
        }
    });

    var newGameButton = buttons[0];

    newGameButton.addEventListener('click', function () {
        fetch("../php/index.php").then(response => {
            if (response.ok) {
                return response.json();
            }
        }).then(statoinziale => {
            console.log(statoinziale);
        }).catch(error => {
            console.log(error);
        });
        form.style.display = 'block';
    });

    // newGameButton.addEventListener('click', function () {
    //     var xhr = new XMLHttpRequest();
    //     xhr.open('GET', '../php/index.php', true);
    //     xhr.onreadystatechange = function () {
    //         if (xhr.readyState == 4 && xhr.status == 200) {
    //             var data = JSON.parse(xhr.responseText);
    //             var table = document.querySelector('table');
    //             table.innerHTML = "";
    //             for (i = 0; i < 9; i++) {
    //                 var row = table.insertRow();
    //                 for (j = 0; j < 9; j++) {
    //                     var cell = row.insertCell();
    //                     cell.innerHTML = data[i][j];
    //                 }
    //             }
    //         }
    //     };
    //     xhr.send();

    // });
}