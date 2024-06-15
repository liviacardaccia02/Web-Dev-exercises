window.onload = function () {
    let button = document.querySelectorAll('button')[0];

    button.addEventListener('click', function () {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let data = JSON.parse(this.response);
                console.log(data.data);
                data.data.forEach(element => {
                    let div = document.createElement("div");
                    div.innerHTML = element.id + " " + element.name + " " + element.type;
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
                    })
                });
            }
        };
        xhr.open("GET", "data.json", true);
        xhr.send();
    });
}