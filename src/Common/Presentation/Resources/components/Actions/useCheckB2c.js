import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
const page = usePage();
const role_name = computed(()=>page.props.user_info.user_role.name);
const checkB2c = ()=>{
    switch (role_name.value) {
        case 'B2B Parent':
            return true;
            
        case 'B2C Parent':
            return true;
        
        case 'BC Subscriber':
            return true;
        default:
            return false;
            
    }
};

export {checkB2c};