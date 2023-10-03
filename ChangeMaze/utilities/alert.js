/*
    https://sweetalert2.github.io/recipe-gallery/queue-with-back-button.html
    https://www.w3schools.com/html/html5_video.asp

*/
export default class Alert {
    constructor() {
    }
    
    async gameplay(scene){
        const steps = ['1','2','3','4','5','6','7']

        const titulos = ['ChangeMaze:\nEnfrentando el Laberinto del Cambio',
                         'Cómo moverse',
                         'Niveles',
                         'Monedas',
                         'Sección de cambio pt. 1',
                         'Sección de cambio pt. 2',
                         'Aviso importante']

        const videos = ["",
                        "<video width='320' height='240' autoplay loop><source src='./ChangeMaze/assets/video/1-moverse.mp4' type='video/mp4'></video>",
                        "<video width='320' height='240' autoplay loop><source src='./ChangeMaze/assets/video/2-niveles.mp4' type='video/mp4'></video>",
                        "<video width='320' height='240' autoplay loop><source src='./ChangeMaze/assets/video/3-monedas.mp4' type='video/mp4'></video>",
                        "<video width='320' height='240' autoplay loop><source src='./ChangeMaze/assets/video/4-secciones1.mp4' type='video/mp4'></video>",
                        "<video width='320' height='240' autoplay loop><source src='./ChangeMaze/assets/video/5-secciones2.mp4' type='video/mp4'></video>",
                        ""]
        
        const descripcion = ["<p align='justify'>Hola, bienvenido/a a nuestro juego. A continuación se mostrará un pequeño tutorial que te enseñará todos los mecanismos que hay dentro del juego para que así puedas tener una mejor experiencia.</p>",
                             "<p align='justify'>Para mover a tu personaje deberás hacer uso de las teclas de dirección o del joystick en caso de estar jugando en un dispositivo móvil.</p>",
                             "<p align='justify'>En cada nivel tendrás que encontrar unas escaleras, las cuales te llevarán al siguiente nivel. El juego consta de 10 niveles, y en la esquina superior derecha podrás ver un cronómetro del tiempo que ha transcurrido en tu juego, uno de los objetivos del juego es terminar en el menor tiempo posible.<br>Nota: En cada nivel cambiará el color del mapa y tu personaje.</p>",
                             "<p align='justify'>A lo largo de tu aventura podrás encontrar monedas en el mapa. El segundo objetivo del juego es terminar con la mayor cantidad posible de monedas.</p>",
                             "<p align='justify'>También encontrarás portales, al entrar en ellos se te preguntará sobre el estado actual de tu juego, y si deseas cambiarlo. En caso de querer hacerlo, el portal te llevará a 1 nivel superior o inferior al que te encuentras, además de aumentar o disminuir tus monedas y el tiempo transcurrido de manera aleatoria. En caso contrario, podrás continuar sin cambios en tu juego.</p>",
                             "<p align='justify'>Además de los portales, cada cierto tiempo se te harán las mismas preguntas sobre el estado de tu juego. En caso de elegir cambiarlo, tendrás el mismo efecto aleatorio que en los portales, en caso contrario podrás continuar sin cambios.</p>",
                             "<p align='justify'>Es fundamental que en el transcurso de todo el juego no recargues la página. Además, podrás volver a consultar cada que quieras este tutorial presionando la tecla 'G' o el botón azul.</p>"]
                             
        const swalQueueStep = Swal.mixin({
            confirmButtonText: 'Siguiente',
            cancelButtonText: 'Anterior',
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
                    1: 'Bueno',
                    0: 'Malo'
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
                    1: 'Sí',
                    0: 'No'
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
        Swal.fire({
            title: '¡Has ganado!',
            text: "A continuación se mostrará el top 10 de jugadores.",
            icon: 'success',
            allowEscapeKey: false,
            allowOutsideClick: false,
            confirmButtonText: 'OK'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = "puntajes";
            }
        })
    }

    level_changes(changes, scene) {  //[level_change,coins_change,time_change]
        if (changes[0] == 1)
            var resp_nivel = 'Has subido 1 nivel\n';
        else if (changes[0] == 0)
            var resp_nivel = 'Has bajado 1 nivel\n';
        else if (changes[0] == 2)
            var resp_nivel = '';

        if (changes[1] > 0)
            var resp_monedas = 'Has obtenido '+Math.abs(changes[1])+' monedas\n';
        else if (changes[1] < 0)
            var resp_monedas = 'Has perdido '+Math.abs(changes[1])+' monedas\n';
        else if (changes[1] == 0)
            var resp_monedas = '';

        if (changes[2] > 0)
            var resp_tiempo = 'El tiempo ha aumentado '+Math.abs(changes[2])+' segundos\n';
        else if (changes[2] < 0)
            var resp_tiempo = 'El tiempo ha disminuido '+Math.abs(changes[2])+' segundos\n';
        else if (changes[2] == 0)
            var resp_tiempo = '';

        Swal.fire({
            title: resp_nivel + resp_monedas + resp_tiempo,
            icon: 'warning',
            allowEscapeKey: false,
            allowOutsideClick: false,
            confirmButtonText: 'OK'
        }).then((result)=>{
            if (result.isConfirmed)
                scene.resume();
        })
    }
}
