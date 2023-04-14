//alert("js connected");

document.querySelector(".name_of_collections").innerHTML = sessionStorage.getItem("title");
document.querySelector(".theme_name").innerHTML = sessionStorage.getItem("theme");
let tr_data = JSON.parse(sessionStorage.getItem("tr_data"));
console.log(tr_data);
document.querySelector("#front_data").innerHTML = tr_data[0][0];
var answer = tr_data[0][1]

let ex_inf = tr_data[0][2]
var i_gl = 0;
var answ_save = [];
for (let i = 0; i < tr_data.length; i++){
    answ_save.push("");
}
//console.log(answ_save);
var url_star = "sleep";
var playing = false;

document.getElementById("add_in_mark").addEventListener('click', function (event){
//            alert(url_star);
            if (url_star == "sleep"){
                document.getElementById("add_in_mark").style.backgroundImage = "url(style/img/star_active.png)";
                url_star = "active";
            }
            else{
                if (url_star == "active"){
                document.getElementById("add_in_mark").style.backgroundImage = "url(style/img/star.png)";
                url_star = "sleep";
                }
            }

        });

var extra_info_flag = false;
document.getElementById("get_info").addEventListener('click', function (event){
            var cont = document.getElementById("main_card_cont");
            if (!extra_info_flag){
                var div = document.createElement("div");
                div.innerHTML = "";
                tr_data[i_gl][2].forEach(function(elem){
                    if (elem.includes(".png")){
                        var img = document.createElement("img");
//                        img.src = "test.png";
                        img.src = elem;
                        img.style.height = "50px";
                        img.style.width = "50px";
                        div.append(img);
                    }
                    else{
                        var p = document.createElement("p");
                        p.innerHTML = elem;
                        div.appendChild(p);
                    }
                });

                div.id = "extra_info"
                cont.appendChild(div);
                extra_info_flag = true;
            }
            else{
                 cont.removeChild(document.getElementById("extra_info"));
                extra_info_flag = false;
            }
//          alert(extra_info_flag);
        });

document.getElementById("to_next").addEventListener('click', function (event){

    if (i_gl < (tr_data.length - 1)){
        i_gl++;
        document.querySelector("#training_input").value = answ_save[i_gl];
        document.querySelector("#front_data").innerHTML = tr_data[i_gl][0];
        document.querySelector("#training_input").style.borderColor = "rgb(12, 80, 124, 0.5)";
        answer = tr_data[i_gl][1]
        console.log(answer);
        var cont = document.getElementById("main_card_cont");


        if(playing){
            return;
          }
          var card = document.querySelector("#card_training_cont");
          var cont = document.querySelector("#main_card_cont");

          playing = true;
          anime({
            targets: card,
            translateX: -2050,
            duration: 300,
            easing: 'easeInOutExpo',
            complete: function(anim){
               playing = false;
        //       card.style.visibility = "hidden";
               anime({
                    targets: card,
                    translateX: +2050,
                    duration: 0,
                    complete: function(anim){
                        anime({
                            targets: card,
                            translateX: 0,
                            easing: 'easeInOutExpo',
                            duration: 300,
                        });
                    }
               });
            }
          });
        console.log(i_gl, tr_data.length);
    }
    if (i_gl == tr_data.length - 1){
        document.querySelector("#end").style.visibility = "visible";
    }
});


document.getElementById("to_prev").addEventListener('click', function (event){

    if (i_gl > 0){
        i_gl--;
        document.querySelector("#training_input").style.borderColor = "rgb(12, 80, 124, 0.5)";
        document.querySelector("#training_input").value = answ_save[i_gl];
        document.querySelector("#front_data").innerHTML = tr_data[i_gl][0];
        answer = tr_data[i_gl][1];
        console.log(answer);
        var cont = document.getElementById("main_card_cont");

        if(playing){
            return;
          }
          var card = document.querySelector("#card_training_cont");
          var cont = document.querySelector("#main_card_cont");

          playing = true;
          anime({
            targets: card,
            translateX: +2050,
            duration: 300,
            easing: 'easeInOutExpo',
            complete: function(anim){
               playing = false;
        //       card.style.visibility = "hidden";
               anime({
                    targets: card,
                    translateX: -2050,
                    duration: 0,
                    complete: function(anim){
                        anime({
                            targets: card,
                            translateX: 0,
                            easing: 'easeInOutExpo',
                            duration: 300,
                        });
                    }
               });
            }
          });
    }
});


document.getElementById("back").addEventListener('click', function(event){
    window.location.href = "cards.html";
});


document.querySelector("#button_skip").addEventListener('click', function(event){
    var answer_inp = document.querySelector("#training_input");
    if (answer == answer_inp.value){
        answer_inp.style.borderColor = "#ADD304";
    }
    else{
        answer_inp.style.borderColor = "#EB4C42";
    }
    answ_save[i_gl] = answer_inp.value;
});

document.querySelector("#end").addEventListener("click", function(event){
    let k = 0;
    for (var i = 0; i < tr_data.length; i++){
        if (answ_save[i] == tr_data[i][1]){
            k++;
        }
    }
    alert(k);
});
