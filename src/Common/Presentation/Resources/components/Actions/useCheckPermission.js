import { usePage } from "@inertiajs/vue3";
import { onMounted,computed } from "vue";
const page = usePage();
const permissions = computed(()=>page.props.auth.data.permissions);
const checkPermission = (target)=>{
    let isExist = permissions.value.filter(permission => {
        return permission==target
    });
   return isExist.length > 0 ? true:false;
};

export {checkPermission};