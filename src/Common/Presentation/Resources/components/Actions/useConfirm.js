import Swal from "sweetalert2";

let isConfirmedDialog = ({
    title = '',
    color = '',
    icon = "warning",
    confirmButtonText ='Save',
    denyButtonText="Don't save",
    onConfirm = null
}) => {

    Swal.fire({
        title: 'Are you sure?',
        text: title,
        icon: icon,
        showConfirmButton:false,
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: confirmButtonText,
        denyButtonText: denyButtonText,

    }).then((result) => {
        if (result.isDenied && onConfirm) {
            onConfirm(); // Execute the callback function if confirmed
          }
    })


};
export { isConfirmedDialog };
