<?php

function alerts($title,$text,$icon,$confirmButtonText,$location){

    $a = '<script>
            Swal.fire({
                title: "'.$title.'",
                text: "'.$text.'",
                icon: "'.$icon.'",
                confirmButtonText:  "'.$confirmButtonText.'"
            }).then((result) => {window.location =  "'.$location.'"; }) 
         </script>';
    
    return $a;
}