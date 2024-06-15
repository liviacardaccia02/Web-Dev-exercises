window.onload = function () {
    let button = document.querySelector("button");

    button.addEventListener("click", function () {
        fetch("data.json").then(function (response) {
            if (response.ok) {
                return response.json();
            }
        }).then(function (response) {
            console.log(response.data);
            let pokemons = response.data;

            pokemons.forEach(pokemon => {
                let div = document.createElement("div");
                div.innerHTML = pokemon["id"] + " " + pokemon["name"] + " " + pokemon["type"];
                document.getElementsByTagName("main")[0].appendChild(div);

                let buttonUp = document.createElement("button");
                let buttonDown = document.createElement("button");
                buttonUp.innerHTML = "Up";
                buttonDown.innerHTML = "Down";
                div.appendChild(buttonUp);
                div.appendChild(buttonDown);

                buttonUp.addEventListener("click", function () {
                    let prev = div.previousElementSibling;
                    if (prev) {
                        div.parentNode.insertBefore(div, prev);
                    }
                });

                buttonDown.addEventListener("click", function () {
                    let next = div.nextElementSibling;
                    if (next) {
                        div.parentNode.insertBefore(next, div);
                    }
                });
            });
        });
    })
}