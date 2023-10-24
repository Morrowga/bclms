<script setup>
import { initialAbility } from "@/plugins/casl/ability";
import { useAppAbility } from "@/plugins/casl/useAppAbility";
import { usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import UserExperienceSurvey from "./components/UserExperienceSurvey.vue";
import { defineProps, onMounted, watch, computed } from "vue";

const ability = useAppAbility();
let page = usePage();
const userData = computed(() => page.props.auth);
let user_role = computed(() => page.props.user_info.user_role.name);
const profileRoute = ref(route("userprofile"));
let user_survey_logout = computed(() => page?.props?.user_survey_logout);
/***
 *  implementation logout for both multitant and b2c user
 *
 */

const hasSurvey = ref(false);

const logout = () => {
    const PREFIX =
        (localStorage.getItem("tenant") != "" || Object.is(localStorage.getItem('tenant',null)))
        ? `/${localStorage.getItem("tenant")}`
            : "";
    localStorage.removeItem("menu_title");

    if(localStorage.getItem("tenant") != "" || Object.is(localStorage.getItem('tenant',null)))
    {
        router.post('/logout');
    }

    else
    {
        router.post(`${PREFIX}/logout`);
    }

};

const checkSurvey = () => {
    if(user_survey_logout.value){
        hasSurvey.value = true;
        console.log(hasSurvey.value);
    } else {
        logout()
    }
}

const dynamicProfileLink = () => {
    console.log(user_role.value);
    switch (user_role.value) {
        case "Teacher":
            return route("profiles.org-teacher");
            break;

        default:
            return route("userprofile");
            break;
    }
};
</script>

<template>
    <VBadge
        dot
        location="bottom right"
        offset-x="3"
        offset-y="3"
        color="success"
        bordered
    >
        <VAvatar class="cursor-pointer" color="primary" variant="tonal">
            <VImg
                v-if="userData?.data && userData?.data?.image"
                :src="userData?.data?.image"
            />
            <VIcon v-else icon="mdi-account-outline" />

            <!-- SECTION Menu -->

            <VMenu activator="parent" width="230" offset="14px">
                <VList class="my-menu">
                    <!-- 👉 User Avatar & Name -->
                    <VListItem>
                        <template #prepend>
                            <VListItemAction start>
                                <VBadge
                                    dot
                                    location="bottom right"
                                    offset-x="3"
                                    offset-y="3"
                                    color="success"
                                >
                                    <VAvatar color="primary" variant="tonal">
                                        <VImg
                                            v-if="
                                                userData?.data &&
                                                userData?.data?.image
                                            "
                                            :src="userData?.data?.image"
                                        />
                                        <VIcon
                                            v-else
                                            icon="mdi-account-outline"
                                        />
                                    </VAvatar>
                                </VBadge>
                            </VListItemAction>
                        </template>

                        <VListItemTitle class="font-weight-semibold">
                            {{ userData?.data?.name }}
                        </VListItemTitle>
                        <VListItemSubtitle>{{
                            userData?.data?.roles?.name
                        }}</VListItemSubtitle>
                    </VListItem>

                    <VDivider class="my-2" />

                    <!-- 👉 Profile -->
                    <VListItem @click="() => router.get(dynamicProfileLink())">
                        <template #prepend>
                            <VIcon
                                class="me-2"
                                icon="mdi-account-outline"
                                size="22"
                            />
                        </template>

                        <VListItemTitle>Profile</VListItemTitle>
                    </VListItem>

                    <!-- Divider -->
                    <!-- <VDivider class="my-2" /> -->

                    <!-- 👉 Logout -->
                    <VListItem @click="checkSurvey">
                        <template #prepend>
                            <VIcon class="me-2" icon="mdi-logout" size="22" />
                        </template>

                        <VListItemTitle>Logout</VListItemTitle>
                    </VListItem>
                </VList>
            </VMenu>
            <UserExperienceSurvey
            v-model:hasSurvey="hasSurvey"
            :data="user_survey_logout" />
            <!-- !SECTION -->
        </VAvatar>
    </VBadge>
</template>

<style scoped>
.my-menu {
    margin-top: 0;
    contain: initial;
    overflow: visible;
}
.my-menu::before {
    position: fixed;
    content: "";
    top: 0;
    right: 10px;
    transform: translateY(-100%);
    width: 10px;
    height: 13px;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    border-bottom: 13px solid rgb(var(--v-theme-surface));
}
.menu-profile {
    position: relative;
}
</style>
