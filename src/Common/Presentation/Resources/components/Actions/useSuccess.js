import Swal from "sweetalert2";

let SuccessDialog = ({title,icon = "success",color = "#48BC65", mainTitle = "Success!"}) => {

    Swal.fire({
        position: 'center',
        icon: icon,
        title: mainTitle,
        text: title,
        showConfirmButton: true,
        confirmButtonColor: color,
        iconColor: color,
    })

};
export { SuccessDialog };
