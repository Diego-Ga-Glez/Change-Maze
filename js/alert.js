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
                         'Cómo moverse',
                         'Niveles',
                         'Monedas',
                         'Comprar tiempo',
                         'Portales',
                         'Aviso importante']

        const videos = ["",
                        "<video width='320' height='240' autoplay loop><source src='./js/assets/video/1moverse.mp4' type='video/mp4'></video>",
                        "<video width='320' height='240' autoplay loop><source src='./js/assets/video/2niveles.mp4' type='video/mp4'></video>",
                        "<video width='320' height='240' autoplay loop><source src='./js/assets/video/3monedas.mp4' type='video/mp4'></video>",
                        "<video width='320' height='240' autoplay loop><source src='./js/assets/video/4comprar.mp4' type='video/mp4'></video>",
                        "<video width='320' height='240' autoplay loop><source src='./js/assets/video/5portales.mp4' type='video/mp4'></video>",
                        ""]
        
        const descripcion = ["<p align='justify'>Hola, bienvenido/a a nuestro juego. A continuación se mostrará un pequeño tutorial que te enseñará todos los mecanismos que hay dentro del juego para que así puedas tener una mejor experiencia.</p>",
                             "<p align='justify'>Para mover a tu personaje deberás hacer uso de las teclas de dirección.</p>",
                             "<p align='justify'>En cada nivel tendrás que encontrar unas escaleras, las cuales te llevarán al siguiente nivel. El objetivo del juego es finalizar el nivel 10. Se tiene un máximo de 2 minutos para completar cada nivel, si se acaba el tiempo se te regresará al nivel anterior. </p>",
                             "<p align='justify'>A lo largo de toda tu aventura podrás encontrar monedas en el mapa. Estas monedas te servirán para comprar tiempo.  </p>",
                             "<p align='justify'>Para comprar tiempo podrás hacerlo presionando la tecla 'A' o el botón rojo que se encuentra debajo del temporizador. Al comprar tiempo se agregarán 30 segundos al temporizador y esto te costará solo una moneda.</p>",
                             "<p align='justify'>En algunos niveles podrás encontrar portales, estos podrán llevarte a un nivel aleatorio. </p>",
                             "<p align='justify'>Es fundamental que en el transcurso de todo el juego no recargues la página. Además, podrás volver a consultar cada que quieras este tutorial presionando la tecla 'G'.</p>"]
                             
        const swalQueueStep = Swal.mixin({
            confirmButtonText: 'Siguiente',
            cancelButtonText: 'Anterior',
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
            title: '¡Has ganado!',
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
