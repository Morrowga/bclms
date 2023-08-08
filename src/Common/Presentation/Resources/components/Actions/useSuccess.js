import Swal from "sweetalert2";

let SuccessDialog = ({title,icon = "success"}) => {

    Swal.fire({
        position: 'center',
        icon: icon,
        title: title,
        text: "Form updated Successfully",
        showConfirmButton: true
    })

};
export { SuccessDialog };
