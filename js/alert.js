/*
    https://sweetalert2.github.io/recipe-gallery/queue-with-back-button.html
    https://www.w3schools.com/html/html5_video.asp

*/
export default class Alert {
    constructor() {
    }
    
    async gameplay(scene){
        const steps = ['1', '2', '3']
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
                title: `Explicación ${steps[currentStep]}`,
                showCancelButton: currentStep > 0,
                currentProgressStep: currentStep,
                html:
                "<video width='320' height='240' autoplay loop><source src='./video/movie.mp4' type='video/mp4'></video><p>Explicacion</p>"
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

}
