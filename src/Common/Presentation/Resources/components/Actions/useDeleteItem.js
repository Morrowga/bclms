/***
 *   @globale composable function to delet item int the database
 *   don't touch this gonna effect all the module
 *   Author : hareom284
 */
import { router } from "@inertiajs/core";
import { usePage } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import { computed} from "vue";
import { SuccessDialog } from "@actions/useSuccess";

let flash = computed(() => usePage().props.flash);

const deleteItem = (id,route_name) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: 'warning',
        showConfirmButton:false,
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Save',
        denyButtonText: "Yes,delete it!",
    }).then((result) => {
        if (result.isDenied) {
            router.delete(`${route_name}/${id}`, {
                onSuccess: () => {
                    SuccessDialog({ title: flash?.successMessage });
                },
            });
          }
    })
}

export default deleteItem;

