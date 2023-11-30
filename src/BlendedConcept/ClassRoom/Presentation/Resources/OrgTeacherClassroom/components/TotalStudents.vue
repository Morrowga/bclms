<script setup>
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import { toastAlert } from "@Composables/useToastAlert";
import ChipWithBlueDot from "@mainRoot/components/ChipWithBlueDot/ChipWithBlueDot.vue";
import {
    serverParams,
    onColumnFilter,
    searchItems,
    onPageChange,
    onPerPageChange,
    serverPage,
    serverPerPage,
    routeParam,
} from "@Composables/useServerSideDatable.js";
import { format, differenceInYears } from "date-fns";
const props = defineProps({
    form: {
        type: Object,
        default: {
            students: [],
        },
    },
    students: {
        type: Array,
        default: [],
    },
    classroom_id: {
        default: "",
    },
});
let students = ref([]);
routeParam.value = {
    classroom: props.classroom_id,
};
//## start datatable section
let rows = ref([]);

serverPage.value = ref(props.students.current_page ?? 1);
serverPerPage.value = ref(10);

watch(serverPerPage, function (value) {
    onPerPageChange(value);
});
function calculateAge(dateOfBirth) {
    const currentDate = new Date();
    const formattedDob = format(new Date(dateOfBirth), "yyyy-MM-dd");
    return differenceInYears(currentDate, new Date(formattedDob));
}
const userImage = (user) =>
    user.profile_pic ?? "/images/profile/profilefive.png";
</script>
<template>
    <section>
        <VCard>
            <VDivider />

            <VCol cols="12">
                <VRow class="bg-line mx-1 rounded pa-1 mb-5" align="center">
                    <VCol cols="3" class="d-flex justify-center">
                        <VLabel class="tiggie-label"> Name </VLabel>
                        <VIcon icon="mdi-menu-down"></VIcon>
                    </VCol>
                    <VCol cols="3">
                        <VLabel class="tiggie-label"> Education Level </VLabel>
                    </VCol>
                    <VCol cols="3">
                        <VLabel class="tiggie-label"> Age </VLabel>
                        <VIcon icon="mdi-menu-down"></VIcon>
                    </VCol>

                    <VCol cols="3">
                        <VLabel class="tiggie-label"> Disability Type </VLabel>
                        <VIcon icon="mdi-menu-down"></VIcon>
                    </VCol>
                </VRow>

                <VRow
                    class="bg-line mx-1 rounded pa-1 my-2"
                    v-for="data in props.students.data"
                    :key="data.student_id"
                    align="center"
                >
                    <VCol cols="3">
                        <div class="d-flex align-center">
                            <div class="d-flex align-center">
                                <v-checkbox
                                    class="custom-checkbox"
                                    v-model="props.form.students"
                                    :value="data.student_id"
                                />
                                <v-img
                                    width="100"
                                    :aspect-ratio="16 / 9"
                                    :src="userImage(data.user)"
                                />
                            </div>
                            <span>
                                {{ data.user?.full_name }}
                            </span>
                        </div>
                    </VCol>
                    <VCol cols="3">
                        <span>
                            {{ data.education_level }}
                        </span>
                    </VCol>
                    <VCol cols="3">
                        <p class="tiggie-p">
                            {{ data.dob ? calculateAge(data.dob) : "---" }}
                        </p>
                    </VCol>

                    <VCol cols="3">
                        <ChipWithBlueDot
                            v-for="item in data.disability_types"
                            :key="item.id"
                            :title="item.name"
                        />
                    </VCol>
                </VRow>
                <VRow justify="center" align="center">
                    <VPagination
                        v-model="serverPage"
                        size="small"
                        :total-visible="5"
                        :length="props.students.last_page"
                        @next="onPageChange"
                        @prev="onPageChange"
                        @click="onPageChange"
                        variant="outlined"
                    />
                </VRow>
            </VCol>

            <VDivider />
        </VCard>
    </section>
</template>

<style scoped>
.vgt-table th {
    font-size: 10pt !important;
}
.vgt-table th.vgt-checkbox-col {
    background: rgb(var(--v-theme-surface)) !important;
    padding: 15px;
    border-right: none;
    border-bottom: 1px solid #dcdfe6;
}
.vgt-wrap__footer {
    background: rgb(var(--v-theme-surface)) !important;
    border: none;
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}

.chip {
    display: inline-flex;
    flex-direction: row;
    background-color: #e5e5e5;
    border: none;
    cursor: default;
    height: 36px;
    outline: none;
    padding: 0;
    font-size: 14px;
    color: #333333;
    font-family: "Open Sans", sans-serif;
    white-space: nowrap;
    align-items: center;
    border-radius: 16px;
    vertical-align: middle;
    text-decoration: none;
    justify-content: center;
}

.chip-content {
    cursor: inherit;
    display: flex;
    align-items: center;
    user-select: none;
    white-space: nowrap;
    padding-left: 12px;
    padding-right: 12px;
}

.std-width-high {
    width: 60px !important;
    height: 60px !important;
}
</style>
