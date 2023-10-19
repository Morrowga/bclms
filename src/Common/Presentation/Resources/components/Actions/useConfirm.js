import Swal from "sweetalert2";

let isConfirmedDialog = ({
    title = '',
    color = '',
    icon = "warning",
    confirmButtonText ='Save',
    denyButtonColor='#FF6262',
    denyButtonText="Save",
    onConfirm = null
}) => {

    Swal.fire({
        title: 'Are you sure?',
        text: title,
        icon: icon,
        showConfirmButton:false,
        denyButtonColor: denyButtonColor,
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
