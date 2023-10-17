<script setup>
import { router } from "@inertiajs/core";
import CardAction from "@mainRoot/components/Resource/CardAction.vue";
import { defineProps,defineEmits } from "vue";
const props = defineProps({
    isEditMode: {
        type: Boolean,
        default: false,
    },
    data: {
        type: Object,
    },
    type: {
        type: String,
    },
    currentUser: {
        type: Object
    }
});

const emits = defineEmits(['checkboxChange']);

const isChecked = ref(false); // Initialize checkbox state

const updateSelectedData = () => {
  emits('checkboxChange', { id: props.data.id, checked: isChecked.value });
};

const type = ref(null);
type.value = props.data.mime_type.split('/').pop()

const checkMe = () =>{
    let current = props.currentUser.data
    let id;
    if(props.data.organisation_id !== null && props.data.teacher_id === null){
        return 'Org'
    }

    if(props.data.organisation_id === null && props.data.teacher_id !== null){
        if(current.id === props.data.teacher_id){
            return "Me"
        } else {
            return "Org"
        // return props.data.teacher.full_name
        }
    }

    if(props.data.organisation_id !== null && props.data.teacher_id !== null){
        if(current.id === props.data.teacher_id){
            return "Me"
        } else {
            return "Org"
            // return props.data.teacher.full_name
        }
    }
}

const checkBusinessType = () =>{
    let current = props.currentUser.data

    if(props.data.organisation_id === null) {
        return false;
    } else {
        if(props.data.organisation_id !== null && props.data.teacher_id === null){
            return false
        }

        if(props.data.organisation_id !== null && props.data.teacher_id !== null){
            if(current.id === props.data.teacher_id){
                return true
            } else {
                return false
                // return props.data.teacher.full_name
            }
        }
    }
}

const fileSizeInMB = computed(() => {
  return (props.data.size / (1024 * 1024)).toFixed(2); // Convert bytes to MB and round to 2 decimal places
});

</script>
<template>
    <VCard>
        <CardAction v-if="props.type === 'orgData'" :check_type="checkBusinessType()" :current_user="currentUser" :data="props.data" :hidden="isEditMode" />
        <VCheckbox  v-model="isChecked" @change="updateSelectedData" class="checkboxcard" v-if="isEditMode"></VCheckbox>
        <v-img :src="props.data.thumb_url" height="350" cover></v-img>
        <div class="resource-label">
            <VRow>
                <VCol cols="8" class="text-left">
                    <span class="ruddy-bold"> {{ props.data.name}} </span>
                </VCol>
                <VCol cols="4" class="text-right">
                    <div class="resource-chip">
                        <v-btn class="me-chip" :class="checkMe() == 'Org' ? 'blue-chip' : 'yellow-chip'">
                            {{ checkMe() }}
                        </v-btn>
                    </div>
                </VCol>
            </VRow>
            <VRow>
                <VCol cols="3">
                    <div class="d-flex justify-center">
                        <div>
                            <img
                                src="/images/media.png"
                                width="15"
                                height="15"
                                class="mt-1"
                                alt=""
                            />
                        </div>
                        <div>
                            <span class="media-text ml-1 text-capitalize">{{ type }}</span>
                        </div>
                    </div>
                </VCol>
                <VCol cols="4">
                    <span class="media-text">{{fileSizeInMB}}</span>
                </VCol>
                <VCol cols="4">
                    <span class="media-text">1920x1080</span>
                </VCol>
                <VCol cols="1">
                    <span class="media-text">1920x1080</span>
                </VCol>
            </VRow>
        </div>
    </VCard>
</template>
<style scoped>
.resourcemenu {
    font-weight: bold !important;
    font-size: 20px !important;
    position: absolute;
    z-index: 1;
    cursor: pointer;
    color: #000 !important;
    right: 6%;
}
.checkboxcard {
    font-weight: bold !important;
    font-size: 20px !important;
    position: absolute;
    z-index: 1;
    cursor: pointer;
    color: #fff !important;
    left: 6%;
}
.media-text {
    font-size: 13px !important;
}
.rolling-card {
    border: 3px solid #000;
    background: var(--seaform, #d7f2f0);
}

.me-chip {
    background: #fc0 !important;
    width: 100% !important;
    z-index: 1;
}

.yellow-chip {
    background: #fc0 !important;
}

.blue-chip {
    background: #3749e8 !important;
}
.resource-label {
    height: 13vh;
    position: absolute;
    z-index: 1;
    bottom: 0;
    font-size: 24px;
    width: 100%;
    color: white;
    background-color: #32383b;
    padding: 8px;
    border-radius: 4px;
}
</style>
