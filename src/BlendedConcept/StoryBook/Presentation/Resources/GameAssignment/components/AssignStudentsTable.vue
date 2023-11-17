<script setup>
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps, onUpdated } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import SecondaryBtn from "@mainRoot/components/SecondaryBtn/SecondaryBtn.vue";
import PrimaryBtn from "@mainRoot/components/PrimaryBtn/PrimaryBtn.vue";
import { SuccessDialog } from "@actions/useSuccess";
import { calculateAge } from "@actions/useCalculateAge";

import {
    serverParams,
    onColumnFilter,
    searchItems,
    onPageChange,
    onPerPageChange,
    serverPage,
    serverPerPage,
    truncatedText,
} from "@Composables/useServerSideDatable.js";
let props = defineProps(["students", "game", "assignments"]);

serverPage.value = ref(props.students.current_page ?? 1);
serverPerPage.value = ref(10);
let permissions = computed(() => usePage().props.auth.data.permissions);

let options = ref({
    enabled: true,
    mode: "pages",
    perPage: props.students.per_page,
    setCurrentPage: props.students.current_page,
    perPageDropdown: [10, 20, 50, 100],
    dropdownAllowAll: false,
});

watch(serverPerPage, function (value) {
    onPerPageChange(value);
});

let columns = [
    {
        label: "Name",
        field: "name",
        sortable: false,
    },
    {
        label: "Education Level",
        field: "education_level",
        sortable: false,
    },
    {
        label: "Age",
        field: "age",
        sortable: false,
    },
    {
        label: "Disability Type",
        field: "disability_types",
        sortable: false,
    },
];

const form = useForm({
    game_id: props.game.id,
    student_ids: [],
});

const selectionChanged = (data) => {
    form.student_ids = data.selectedRows.map((item) => item.student_id);
};

const assignStudent = () => {
    form.post(route("gameassign.assign"), {
        onSuccess: () => {
            SuccessDialog({ title: "Assigned Game Success" });
        },
        onError: (error) => {
            console.log(error);
        },
    });
};
const getImage = (item) => {
    return item.thumbnail_img == "" || !item.thumbnail_img
        ? "/images/image8.png"
        : item.thumbnail_img;
};
const backHome = () => {
    router.get(route("game-assign"));
};
const userImage = (user) =>
    user.profile_pic ?? "/images/profile/profilefive.png";

onMounted(() => {
    form.student_ids = props.assignments?.map((game) => game.student_id);
});
</script>
<template>
    <div>
        <section></section>
        <section class="mt-8">
            <h1 class="ruddy-bold head-text">Assign to Students</h1>
            <VCard class="mt-10">
                <VDivider />

                <VCol cols="12">
                    <VRow
                        class="bg-line mx-1 rounded pa-1 mb-5 mt-4"
                        align="center"
                    >
                        <VCol cols="3" class="d-flex justify-center">
                            <VLabel class="tiggie-label"> Name </VLabel>
                            <VIcon icon="mdi-menu-down"></VIcon>
                        </VCol>
                        <VCol cols="3">
                            <VLabel class="tiggie-label">
                                Education Level
                            </VLabel>
                        </VCol>
                        <VCol cols="3">
                            <VLabel class="tiggie-label"> Age </VLabel>
                            <VIcon icon="mdi-menu-down"></VIcon>
                        </VCol>

                        <VCol cols="3">
                            <VLabel class="tiggie-label">
                                Disability Type
                            </VLabel>
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
                                        v-model="form.student_ids"
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
                                {{ calculateAge(data.dob) }}
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
        <section class="mt-5">
            <v-row>
                <v-col cols="12" class="d-flex justify-center">
                    <SecondaryBtn
                        type="button"
                        class="mr-4"
                        title="Back"
                        @click="backHome()"
                    />
                    <PrimaryBtn
                        title="Assign"
                        :isLink="false"
                        @click="assignStudent()"
                    />
                </v-col>
            </v-row>
        </section>
    </div>
</template>

<style scoped>
.head-text {
    font-size: 30px !important;
    color: #000;
}
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
.assign-std {
    color: var(--text, #161616);
    /* H3 Ruddy */

    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
}
.assign-std-width-high {
    width: 60px;
    height: 60px;
}

.position-relative {
    position: relative;
}

.position-absolute {
    position: absolute;
    right: 10px;
    top: 5px;
}
</style>
