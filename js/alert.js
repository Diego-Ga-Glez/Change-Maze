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
}
