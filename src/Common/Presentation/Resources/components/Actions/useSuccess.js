import Swal from "sweetalert2";

let SuccessDialog = ({title,icon = "success",color = "#48BC65"}) => {

    Swal.fire({
        position: 'center',
        icon: icon,
        title: "Success!",
        text: title,
        showConfirmButton: true,
        confirmButtonColor: color,
        iconColor: color,
    })

};
export { SuccessDialog };
