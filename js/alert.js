/*
    https://sweetalert2.github.io/recipe-gallery/queue-with-back-button.html
    https://www.w3schools.com/html/html5_video.asp

*/
export default class Alert {
    constructor() {
    }
    
    async gameplay(scene){
        const steps = ['1', '2', '3','4','5','6','7']

        const titulos = ['ERC GAME',
                         'Como moverse',
                         'Monedas',
                         'Comprar tiempo',
                         'Escaleras',
                         'Portales',
                         'Advertencias']

        const videos = ["",
                        "<video width='320' height='240' autoplay loop><source src='./js/assets/video/movie.mp4' type='video/mp4'></video>",
                        "<video width='320' height='240' autoplay loop><source src='./js/assets/video/movie.mp4' type='video/mp4'></video>",
                        "<video width='320' height='240' autoplay loop><source src='./js/assets/video/movie.mp4' type='video/mp4'></video>",
                        "<video width='320' height='240' autoplay loop><source src='./js/assets/video/movie.mp4' type='video/mp4'></video>",
                        "<video width='320' height='240' autoplay loop><source src='./js/assets/video/movie.mp4' type='video/mp4'></video>",
                        ""]
        
        const descripcion = ["<p align='justify'>Hola, bienvenido a nuestro juego. A continuación se te mostraran un pequeño tutorial que te ayudara a tener una mejor experiencia con el juego. Este tutorial te enseñara todos los mecanismos que hay dentro del juego.</p>",
                             "<p align='justify'>Para mover a tu personaje deberás hacer uso de las flechas de dirección. </p>",
                             "<p align='justify'>A lo largo de toda tu aventura podrás encontrar monedas en el mapa. Estas monedas te servirán para comprar tiempo.  </p>",
                             "<p align='justify'>Para comprar tiempo podrás hacerlo presionando la tecla 'A' o también presionando el botón rojo que se encuentra debajo del cronometro. Al comprar tiempo se agregaran 30 segundo al cronometro y esto te costara solo 1 moneda.</p>",
                             "<p align='justify'>En cada nivel tendrás que encontrar unas escaleras, las cuales te llevaran al siguiente nivel. El objetivo del juego es llegar al nivel 10. También, para cada nivel se tiene un máximo de 2 minutos para completarlo, si se acaba el tiempo se te regresara al nivel anterior. </p>",
                             "<p align='justify'>En algunos niveles podrás encontrar portales, estos portales podrán llevarte a un nivel aleatorio. </p>",
                             "<p align='justify'>Es importante que durante todo el juego no recargues la pagina. Además, podrás volver a consultar cada que quieras este tutorial presionando la tecla 'T'.</p>"]
                             
        const swalQueueStep = Swal.mixin({
            confirmButtonText: 'Forward',
            cancelButtonText: 'Back',
            progressSteps: steps,
            reverseButtons: true
        });
 
        let currentStep;
        let result;
        for (currentStep = 0; currentStep < steps.length;) {
            result = await swalQueueStep.fire({
                title: titulos[currentStep],
                showCancelButton: currentStep > 0,
                currentProgressStep: currentStep,
                html: videos[currentStep] + descripcion[currentStep]
            })

            if (result.value) {
                currentStep++
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                currentStep--
            } else {
                break
            }
        }
        scene.resume()
    }

    score_section() {
        return new Promise((resolve) => {
            const { value: opcion } = Swal.fire({
                title: 'Califica tu juego actual',
                input: 'select',
                allowEscapeKey : false,
                allowOutsideClick: false,
                inputOptions: {
                    excelente: 'Excelente',
                    bueno: 'Bueno',
                    regular: 'Regular',
                    malo: 'Malo',
                    pesimo: 'Pésimo'
                },
                inputPlaceholder: 'Selecciona una opción',
                inputValidator: (value) => {
                        if (!value) 
                            return "Selecciona una opción"
                }
            }).then((result)=>{
                if (result.isConfirmed)
                    resolve(result.value)
            })
        })

    }

    change_section(scene){
        return new Promise((resolve) => {
            const { value: opcion } = Swal.fire({
                title: '¿Quieres que cambie el juego?',
                input: 'select',
                allowEscapeKey : false,
                allowOutsideClick: false,
                inputOptions: {
                    si: 'Sí',
                    no: 'No'
                },
                inputPlaceholder: 'Selecciona una opción',
                inputValidator: (value) => {
                        if (!value) 
                            return "Selecciona una opción"
                }
            }).then((result)=>{
                if (result.isConfirmed){
                    scene.resume()
                    resolve(result.value)
                }
            })
        })
    }

    you_win() {
        var datos = new FormData();
        datos.append("encuesta", true);

        $.ajax({
            url:"./ajax/usuarios.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function(ans){
            }
        });
        
        Swal.fire({
            title: 'Has ganado!',
            text: "Por último, serás redireccionado a una encuesta",
            icon: 'success',
            allowEscapeKey: false,
            allowOutsideClick: false,
            confirmButtonText: 'OK'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = "encuesta";
            }
        })
    }

}
