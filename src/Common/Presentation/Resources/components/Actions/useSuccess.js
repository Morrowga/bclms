import Swal from "sweetalert2";

let SuccessDialog = ({title,icon = "success"}) => {

    Swal.fire({
        position: 'center',
        icon: icon,
        title: "Success!",
        text: title,
        showConfirmButton: true
    })

};
export { SuccessDialog };
