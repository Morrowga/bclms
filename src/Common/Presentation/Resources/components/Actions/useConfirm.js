import Swal from "sweetalert2";

let isConfirmedDialog = ({ title = '', icon = "warning",confirmButtonText ='Save',denyButtonText="Don't save"}) => {

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
        if (result.isConfirmed) {
            Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            )
        }
    })


};
export { isConfirmedDialog };
