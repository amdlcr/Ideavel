/*document.querySelectorAll(".btn_like").forEach(btn => { //selecciona todos los botones de like de la pagina y para cada uno de ellos,al hacer click se ejecuta su funcionamiento
    btn.onclick = async function () { //usamos async para que podamos usar wait, y asi poder esperar a que el servidor conteste para poder continuar
        const idIdea = this.dataset.id; //Seleccionamos cada idea gracias a su data-id
        const divIdea = this.closest("div"); //Selecionamos el div concreto de cada idea, para que no afecte a las demas ideas

       
        try{

            //Recogemos la informacion JSON del controlador y la gestionamos para poder usarla como un objeto de JS
            const respuestaControlador = await fetch("/ideas/" + idIdea + "/like", { //Uso de AJAX, usamos la ruta sin recargar la pagina, y con PUT actualizamos los datos
            method: "PUT",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content, // Obligatorio por seguridad para que Laravel permita la accion, identificando que es un usuario autenticado
                "Accept": "application/json" // El dato que va aceptar es de tipo JSON
            }
            });
    
                const ObjetoJson = await respuestaControlador.json();//Aqui el objeto JS ,donde estan los datos de la cantidad de like o dislikes y los boolean 
    
                if (ObjetoJson.error === true){
                    throw new Error(ObjetoJson.respuesta);//Crea un objeto error que sera el que recoja el catch, luego en el paramentro podemso llamarlo como queramos Ej:miError
                }
                    //Con la informacion del numero de like y dislike actualizamos los contadores
                    divIdea.querySelector(".likes_count").innerText = ObjetoJson.respuesta.likes; 
                    divIdea.querySelector(".dislikes_count").innerText = ObjetoJson.respuesta.dislikes; //errores

                     //Controlamos los colores de los botones de like y dislike
                    this.classList.toggle('liked_color', ObjetoJson.respuesta.liked); // Si el valor del JSON de 'liked' es true el boton de 'btn_like' se pone verde y si es false se quita el color verde
                    divIdea.querySelector(".btn_dislike").classList.toggle('disliked_color', ObjetoJson.respuesta.disliked); //Si el valor del JSON de 'disliked' es true el 'btn_dislike' se pone rojo y si es false se quita el color rojo
                

        } catch (miError){

            alert(miError.message);// muestra un cuadro de dialogo con el mensaje personalizado del json, ya que 'message' recoge lo que  haya en 'throw new Error(ObjetoJson.respuesta)'
            console.error("Error al procesar el like: ",miError); //muestra un error en la consola

        } 
          
    };
    
});

document.querySelectorAll(".btn_dislike").forEach(btn => {
    btn.onclick = function () {
        const idIdea = this.dataset.id; 
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
*/


//---------------


document.querySelectorAll('.btn_like').forEach(boton => { 
    boton.onclick = async function () { 
        const idIdea = this.dataset.id; 
        const divIdea = this.closest("div"); 
        
       try{

        const valores = {
            id : this.dataset.id,
            reaccion : this.value
        };

        const respuestaControlador = await fetch("/ideas/" + idIdea + "/gestion", { 
            method: "PUT",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content, 
                "Accept": "application/json",     //Aqui hay que enviar otro json para el controlador qu ellegue con request
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(valores)
            }
        );

        const ObjetoJson = await respuestaControlador.json();

        if (ObjetoJson.error === true){
                    throw new Error(ObjetoJson.respuesta);
                }
            

            divIdea.querySelector(".likes_count").innerText = ObjetoJson.respuesta.likes;
            divIdea.querySelector(".dislikes_count").innerText = ObjetoJson.respuesta.dislikes;

            const botonLike = divIdea.querySelector('button[value="like"]');
            const botonDislike = divIdea.querySelector('button[value="dislike"]');

            console.log(ObjetoJson);
            if (ObjetoJson.respuesta.liked == true) {
                botonLike.classList.add('liked_color');
            } else {
                botonLike.classList.remove('liked_color');
            }

            if (ObjetoJson.respuesta.disliked == true) {
                botonDislike.classList.add('disliked_color');
            } else {
                botonDislike.classList.remove('disliked_color');
            }




            }catch (miError){

            alert(miError.message);
            console.error("Error al procesar el like: ",miError); 

        } 
          
    };
    
});