//alert("js connected");

let data_ph_start = [
        [
            "первая подборка",
            [
                ["первая подборка","первая подборка",["test.png","первая подборка инфа"]],
                ["первая подборка 1","первая подборка 1",["test.png","первая подборка инфа 1"]],
                ["первая подборка 2","первая подборка 2",["test.png","первая подборка инфа 2"]]
            ],
            [
                ['первая подборка задача', 'первая подборка ответ', ["test.png","первая подборка инфа"]],
                ['первая подборка задача 1', 'первая подборка ответ 1', ["test.png","первая подборка инфа 1"]],
                ['первая подборка задача 2', 'первая подборка ответ 2', ["test.png","первая подборка инфа 2"]]
            ]
        ],
        [
            "вторая подборка",
            [
                ["вторая подборка","вторая подборка",["test.png","вторая подборка инфа"]],
                ["вторая подборка 1","вторая подборка 1",["test.png","вторая подборка инфа 1"]],
                ["вторая подборка 2","вторая подборка 2",["test.png","вторая подборка инфа 2"]]
            ],
            [
                ['вторая подборка задача', 'вторая подборка ответ', ["test.png","вторая подборка инфа"]],
                ['вторая подборка задача 1', 'вторая подборка ответ 1', ["test.png","вторая подборка инфа 1"]],
                ['вторая подборка задача 2', 'вторая подборка ответ 2', ["test.png","вторая подборка инфа 2"]]
            ]
        ],
        [
            "третья подборка",
            [
                ["третья подборка","третья подборка",["test.png","третья подборка инфа"]],
                ["третья подборка 1","третья подборка 1",["test.png","третья подборка инфа 1"]],
                ["третья подборка 2","третья подборка 2",["test.png","третья подборка инфа 2"]]
            ],
            [
                ['третья подборка задача', 'третья подборка ответ', ["test.png","третья подборка инфа"]],
                ['третья подборка задача 1', 'третья подборка ответ 1', ["test.png","третья подборка инфа 1"]],
                ['третья подборка задача 2', 'третья подборка ответ 2', ["test.png","третья подборка инфа 2"]]
            ]
        ],
        [
            "четвертая подборка",
            [
                ["четвертая подборка","вторая подборка",["test.png","вторая подборка инфа"]],
                ["четвертая подборка 1","вторая подборка 1",["test.png","вторая подборка инфа 1"]],
                ["четвертая подборка 2","вторая подборка 2",["test.png","вторая подборка инфа 2"]]
            ],
            [
                ['четвертая подборка задача', 'четвертая подборка ответ', ["test.png","четвертая подборка инфа"]],
                ['четвертая подборка задача 1', 'четвертая подборка ответ 1', ["test.png","четвертая подборка инфа 1"]],
                ['четвертая подборка задача 2', 'четвертая подборка ответ 2', ["test.png","четвертая подборка инфа 2"]]
            ]
        ],
    ];

let data_mt_start = [
        [
            "первая подборка мат",
            [
                ["первая подборка мат","первая подборка мат",["test.png","первая подборка инфа мат"]],
                ["первая подборка 1 мат","первая подборка 1 мат",["test.png","первая подборка инфа 1 мат"]],
                ["первая подборка 2 мат","первая подборка 2 мат",["test.png","первая подборка инфа 2 мат"]]
            ],
            [
                ['первая подборка задача мат', 'первая подборка ответ мат', ["test.png","первая подборка инфа мат"]],
                ['первая подборка задача 1 мат', 'первая подборка ответ 1 мат', ["test.png","первая подборка инфа 1 мат"]],
                ['первая подборка задача 2 мат', 'первая подборка ответ 2 мат', ["test.png","первая подборка инфа 2 мат"]]
            ]
        ],
        [
            "вторая подборка мат",
            [
                ["вторая подборка мат","вторая подборка мат",["test.png","вторая подборка инфа мат"]],
                ["вторая подборка 1 мат","вторая подборка 1 мат",["test.png","вторая подборка инфа 1 мат"]],
                ["вторая подборка 2 мат","вторая подборка 2 мат",["test.png","вторая подборка инфа 2 мат"]]
            ],
            [
                ['вторая подборка задача мат', 'вторая подборка ответ мат', ["test.png","вторая подборка инфа мат"]],
                ['вторая подборка задача 1 мат', 'вторая подборка ответ 1 мат', ["test.png","вторая подборка инфа 1 мат"]],
                ['вторая подборка задача 2 мат', 'вторая подборка ответ 2 мат', ["test.png","вторая подборка инфа 2 мат"]]
            ]
        ],
        [
            "третья подборка мат",
            [
                ["третья подборка мат","третья подборка мат",["test.png","третья подборка инфа мат"]],
                ["третья подборка 1 мат","третья подборка 1 мат",["test.png","третья подборка инфа 1 мат"]],
                ["третья подборка 2 мат","третья подборка 2 мат",["test.png","третья подборка инфа 2 мат"]]
            ],
            [
                ['третья подборка задача мат', 'третья подборка ответ мат', ["test.png","третья подборка инфа мат"]],
                ['третья подборка задача 1 мат', 'третья подборка ответ 1 мат', ["test.png","третья подборка инфа 1 мат"]],
                ['третья подборка задача 2 мат', 'третья подборка ответ 2 мат', ["test.png","третья подборка инфа 2 мат"]]
            ]
        ],
        [
            "четвертая подборка мат",
            [
                ["четвертая подборка мат","вторая подборка мат",["test.png","вторая подборка инфа мат"]],
                ["четвертая подборка 1 мат","вторая подборка 1 мат",["test.png","вторая подборка инфа 1 мат"]],
                ["четвертая подборка 2 мат","вторая подборка 2 мат",["test.png","вторая подборка инфа 2 мат"]]
            ],
            [
                ['четвертая подборка задача мат', 'четвертая подборка ответ мат', ["test.png","четвертая подборка инфа мат"]],
                ['четвертая подборка задача 1 мат', 'четвертая подборка ответ 1 мат', ["test.png","четвертая подборка инфа 1 мат"]],
                ['четвертая подборка задача 2 мат', 'четвертая подборка ответ 2 мат', ["test.png","четвертая подборка инфа 2 мат"]]
            ]
        ],
    ];

let data_ph = [
        [
            "динамика",
            [
                ["t_h = (U0 * sin(a)) / g","время падения",["test.png","В верхней точке траекторий скорость движения тела горизонтальна (параллельна оси OX).Именно поэтому проекция скорости тела на ось OY равна 0 (v_y=0)Скорость на ось oy определяем уравнением:v_y=v_0  sin⁡α-gt(-gt, так как ускорение свободного падения противоположно направлен вектору (v_y ) ⃗ – вниз)"]],
                ["x=1/1","коэфициент 1",["test.png","используется для нахождения 1, исходит из формулы 1=2^1"]],
                ["x=2/2","коэфициент 2",["test.png","используется для нахождения 2, исходит из формулы 2=2^2"]]
            ],
            [
                ['Напишите формулу расчета время падения', 't_h = (U0 * sin(a)) / g', ["test.png","В верхней точке траекторий скорость движения тела горизонтальна (параллельна оси OX).Именно поэтому проекция скорости тела на ось OY равна 0 (v_y=0)Скорость на ось oy определяем уравнением:v_y=v_0  sin⁡α-gt(-gt, так как ускорение свободного падения противоположно направлен вектору (v_y ) ⃗ – вниз)"]],
                ['Напишите коэфициент 1', 'x=1/1', ["test.png","используется для нахождения 1, исходит из формулы 1=2^1"]],
                ['Напишите коэфициент 2', 'x=2/2', ["test.png","используется для нахождения 2, исходит из формулы 2=2^2"]]
            ]
        ],


    ];

let data_mt = [
    [
            "производная",
            [
                ["t_h = (U0 * sin(a)) / g мат","время падения мат",["test.png","В верхней точке траекторий скорость движения тела горизонтальна (параллельна оси OX).Именно поэтому проекция скорости тела на ось OY равна 0 (v_y=0)Скорость на ось oy определяем уравнением:v_y=v_0  sin⁡α-gt(-gt, так как ускорение свободного падения противоположно направлен вектору (v_y ) ⃗ – вниз) мат"]],
                ["x=1/1 мат","коэфициент 1 мат",["test.png","используется для нахождения 1, исходит из формулы 1=2^1 мат"]],
                ["x=2/2 мат","коэфициент 2 мат",["test.png","используется для нахождения 2, исходит из формулы 2=2^2 мат"]]
            ],
            [
                ['Напишите формулу расчета время падения мат', 't_h = (U0 * sin(a)) / g мат', ["test.png","В верхней точке траекторий скорость движения тела горизонтальна (параллельна оси OX).Именно поэтому проекция скорости тела на ось OY равна 0 (v_y=0)Скорость на ось oy определяем уравнением:v_y=v_0  sin⁡α-gt(-gt, так как ускорение свободного падения противоположно направлен вектору (v_y ) ⃗ – вниз) мат"]],
                ['Напишите коэфициент 1 мат', 'x=1/1 мат', ["test.png","используется для нахождения 1, исходит из формулы 1=2^1 мат"]],
                ['Напишите коэфициент 2 мат', 'x=2/2 мат', ["test.png","используется для нахождения 2, исходит из формулы 2=2^2 мат"]]
            ]
        ],
    ];






let list_of_ph_btns = document.querySelectorAll(".ph");
let list_of_mt_btns = document.querySelectorAll(".mt");
let list_of_ph_btns_start = document.querySelectorAll(".start_ph");
let list_of_mt_btns_start = document.querySelectorAll(".start_mt");
let list_of_ph_p = document.querySelectorAll(".p_ph");
let list_of_mt_p = document.querySelectorAll(".p_mt");
var i = 0;
//console.log(list_of_ph_btns);
//console.log(list_of_ph_btns_start);

var name_of_coll = "";
var name_of_theme = "";


list_of_ph_p.forEach(function(elem){
    elem.innerHTML = data_ph_start[i][0];
    i++;
});


i = 0;
list_of_mt_p.forEach(function(elem){
    elem.innerHTML = data_mt_start[i][0];
    i++;
});


list_of_ph_btns.forEach(function(elem) {
    elem.addEventListener('click', function (event){

        name_of_coll = "Физика";
        name_of_theme = elem.querySelector("#coll_block_text").innerHTML;
//        alert(name_of_coll + name_of_theme);
        sessionStorage.clear();
        sessionStorage.setItem("title", name_of_coll);
        sessionStorage.setItem("theme", name_of_theme);
        data_ph.forEach(function(elem){
           if (name_of_theme == elem[0]){
//               sessionStorage.setItem("all_data", JSON.stringify(data_ph[i]));
               sessionStorage.setItem("card_data", JSON.stringify(elem[1]));
               sessionStorage.setItem("tr_data", JSON.stringify(elem[2]));
           }
        });
        window.location.href = "cards.html";
    });
});


list_of_ph_btns_start.forEach(function(elem) {
    elem.addEventListener('click', function (event){

        name_of_coll = "Физика";
        name_of_theme = elem.querySelector("#coll_block_text").innerHTML;
//        alert(name_of_coll + name_of_theme);
        sessionStorage.clear();
        sessionStorage.setItem("title", name_of_coll);
        sessionStorage.setItem("theme", name_of_theme);
        data_ph_start.forEach(function(elem){
           if (name_of_theme == elem[0]){
//               sessionStorage.setItem("all_data", JSON.stringify(data_ph[i]));
               sessionStorage.setItem("card_data", JSON.stringify(elem[1]));
               sessionStorage.setItem("tr_data", JSON.stringify(elem[2]));
           }
        });
        window.location.href = "cards.html";
    });
});


list_of_mt_btns.forEach(function(elem) {
    elem.addEventListener('click', function (event){

        name_of_coll = "Математика";
        name_of_theme = elem.querySelector("#coll_block_text").innerHTML;
//        alert(name_of_coll + name_of_theme);
        sessionStorage.clear();
        sessionStorage.setItem("title", name_of_coll);
        sessionStorage.setItem("theme", name_of_theme);

        data_mt.forEach(function(elem){
           if (name_of_theme == elem[0]){
//               sessionStorage.setItem("all_data", JSON.stringify(data_ph[i]));
               sessionStorage.setItem("card_data", JSON.stringify(elem[1]));
               sessionStorage.setItem("tr_data", JSON.stringify(elem[2]));
           }
        });
        window.location.href = "cards.html";
    });
});


list_of_mt_btns_start.forEach(function(elem) {
    elem.addEventListener('click', function (event){

        name_of_coll = "Математика";
        name_of_theme = elem.querySelector("#coll_block_text").innerHTML;
//        alert(name_of_coll + name_of_theme);
        window.location.href = "cards.html";
        sessionStorage.clear();
        sessionStorage.setItem("title", name_of_coll);
        sessionStorage.setItem("theme", name_of_theme);

        data_mt_start.forEach(function(elem){
           if (name_of_theme == elem[0]){
//               sessionStorage.setItem("all_data", JSON.stringify(data_ph[i]));
               sessionStorage.setItem("card_data", JSON.stringify(elem[1]));
               sessionStorage.setItem("tr_data", JSON.stringify(elem[2]));
           }
        });
    });
});


function get_new_block(btn){

    var block = document.createElement("a");

    if (btn.id == "button_ph"){


        var cont = document.getElementById("conteiner_ph");
        var test = '';

        for (var i = 0; i < data_ph.length; i++){
            block = document.createElement("a");
            test = '<div class="coll_block ph" id="ph"><p id="coll_block_text">' + data_ph[i][0] + '</p></div>';
            block.innerHTML = test;
            block.className = "added_a_ph";
            cont.append(block);
            list_of_ph_btns = document.querySelectorAll(".ph");
        }

        document.getElementById("button_ph").style.visibility = "hidden";
        document.getElementById("button_ph_hide").style.visibility = "visible";


        list_of_ph_btns.forEach(function(elem) {
            elem.addEventListener('click', function (event){

                name_of_coll = "Физика";
                name_of_theme = elem.querySelector("#coll_block_text").innerHTML;
//                alert(name_of_coll + name_of_theme);
                sessionStorage.clear();
                sessionStorage.setItem("title", name_of_coll);
                sessionStorage.setItem("theme", name_of_theme);
                data_ph.forEach(function(elem){
                    if (name_of_theme == elem[0]){
    //                  sessionStorage.setItem("all_data", JSON.stringify(data_ph[i]));
                        sessionStorage.setItem("card_data", JSON.stringify(elem[1]));
                        sessionStorage.setItem("tr_data", JSON.stringify(elem[2]));
                    }
                });
                window.location.href = "cards.html";
            });
        });
    }
    else{

        block.id = "added_a_mt";
        if (btn.id == "button_mt"){
            var cont = document.getElementById("conteiner_mt");
            var test = '';
            for (var i = 0; i < data_mt.length; i++){
                block = document.createElement("a");
                test = '<div class="coll_block mt" id="mt"><p id="coll_block_text">' + data_mt[i][0] + '</p></div>';
                block.innerHTML = test;
                block.className = "added_a_mt";
                cont.append(block);
                list_of_mt_btns = document.querySelectorAll(".mt");
            }

            document.getElementById("button_mt").style.visibility = "hidden";
            document.getElementById("button_mt_hide").style.visibility = "visible";

        }
        list_of_mt_btns.forEach(function(elem) {
            elem.addEventListener('click', function (event){

                name_of_coll = "Математика";
                name_of_theme = elem.querySelector("#coll_block_text").innerHTML;
//                alert(name_of_coll + name_of_theme);

                sessionStorage.clear();
                sessionStorage.setItem("title", name_of_coll);
                sessionStorage.setItem("theme", name_of_theme);
                data_mt.forEach(function(elem){
                   if (name_of_theme == elem[0]){
        //               sessionStorage.setItem("all_data", JSON.stringify(data_ph[i]));
                       sessionStorage.setItem("card_data", JSON.stringify(elem[1]));
                       sessionStorage.setItem("tr_data", JSON.stringify(elem[2]));
                   }
                });
                window.location.href = "cards.html";
            });
        });
    }

//console.log(list_of_ph_btns);
//console.log(list_of_ph_btns_start);
}



function hide_new_block(btn){
    let delited_list;

    if (btn.id == "button_ph_hide"){
        var parent = document.getElementById("conteiner_ph");
        delited_list = document.querySelectorAll(".added_a_ph");

        delited_list.forEach(function(elem) {
            parent.removeChild(elem);
        });
        document.getElementById("button_ph_hide").style.visibility = "hidden";
        document.getElementById("button_ph").style.visibility = "visible";
    }
    else{
        if (btn.id == "button_mt_hide"){
            var parent = document.getElementById("conteiner_mt");
            delited_list = document.querySelectorAll(".added_a_mt");

            delited_list.forEach(function(elem) {
                parent.removeChild(elem);
            });
            document.getElementById("button_mt_hide").style.visibility = "hidden";
            document.getElementById("button_mt").style.visibility = "visible";
        }
    }
}















