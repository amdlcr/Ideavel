document.querySelectorAll(".btn_like").forEach(btn => { //selecciona todos los botones de like de la pagina y para cada uno de ellos,al hacer click se ejecuta su funcionamiento
    btn.onclick = function () { 
        const idIdea = this.dataset.id; //Seleccionamos cada idea gracias a su data-id
        const divIdea = this.closest("div"); //Selecionamos el div concreto de cada idea, para que no afecte a las demas ideas

        fetch("/ideas/" + idIdea + "/like", { //Uso de AJAX, usamos la ruta sin recargar la pagina, y con PUT actualizamos los datos
            method: "PUT",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content, // Obligatorio por seguridad para que Laravel permita la accion, identificando que es un usuario autenticado
                "Accept": "application/json" // El dato que va aceptar es de tipo JSON
            }
        })
        .then(respuestaControlador => respuestaControlador.json()) //Recogemos la informacion JSON del controlador y la gestionamos para poder usarla como un objeto de JS
        .then(datosRespuestaIdea => { //Aqui el objeto JS ,donde estan los datos de la cantidad de like o dislikes y los boolean 

            //Con la informacion del numero de like y dlike actualizamos los contadores
            divIdea.querySelector(".likes_count").innerText = datosRespuestaIdea.likes; 
            divIdea.querySelector(".dislikes_count").innerText = datosRespuestaIdea.dislikes; 

            //Controlamos los colores de los botones de like y dislike
            this.classList.toggle('liked_color', datosRespuestaIdea.liked); // Si el valor del JSON de 'liked' es true el boton de 'btn_like' se pone verde y si es false se quita el color verde
            divIdea.querySelector(".btn_dislike").classList.toggle('disliked_color', datosRespuestaIdea.disliked); //Si el valor del JSON de 'disliked' es true el 'btn_dislike' se pone rojo y si es false se quita el color rojo
        });
    };
});

document.querySelectorAll(".btn_dislike").forEach(btn => {
    btn.onclick = function () {
        const idIdea = this.dataset.id; //Seleccionamos cada idea gracias a su data-id
        const divIdea = this.closest("div");

        fetch("/ideas/" + idIdea + "/dislikes", {
            method: "PUT",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Accept": "application/json"
            }
        })
        .then(respuestaControlador => respuestaControlador.json())
        .then(datosRespuestaIdea => {
            divIdea.querySelector(".likes_count").innerText = datosRespuestaIdea.likes;
            divIdea.querySelector(".dislikes_count").innerText = datosRespuestaIdea.dislikes;

            this.classList.toggle('disliked_color', datosRespuestaIdea.disliked);
            divIdea.querySelector(".btn_like").classList.toggle('liked_color', datosRespuestaIdea.liked);
        });
    };
});  