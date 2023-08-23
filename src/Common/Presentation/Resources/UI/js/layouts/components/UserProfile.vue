<script setup>
import { initialAbility } from "@/plugins/casl/ability";
import { useAppAbility } from "@/plugins/casl/useAppAbility";
import { usePage, Link } from "@inertiajs/vue3";
import { computed } from "vue";
import { router } from "@inertiajs/core";
const ability = useAppAbility();
const userData = computed(() => usePage().props.auth);
console.log(userData);
const logout = () => {
    const PREFIX =
        localStorage.getItem("tenant") != ""
            ? `/${localStorage.getItem("tenant")}`
            : "";
    localStorage.removeItem("menu_title");
    router.post(`${PREFIX}/logout`);
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
                            userData?.data?.roles?.[0]?.name
                        }}</VListItemSubtitle>
                    </VListItem>

                    <VDivider class="my-2" />

                    <!-- 👉 Profile -->
                    <VListItem @click="() => router.get('userprofile')">
                        <template #prepend>
                            <VIcon
                                class="me-2"
                                icon="mdi-account-outline"
                                size="22"
                            />
                        </template>

                        <VListItemTitle>Profile</VListItemTitle>
                    </VListItem>

                    <!-- 👉 Settings -->
                    <VListItem
                        :to="{
                            name: 'pages-account-settings-tab',
                            params: { tab: 'account' },
                        }"
                    >
                        <template #prepend>
                            <VIcon
                                class="me-2"
                                icon="mdi-cog-outline"
                                size="22"
                            />
                        </template>

                        <VListItemTitle>Settings</VListItemTitle>
                    </VListItem>

                    <!-- 👉 Pricing -->
                    <VListItem :to="{ name: 'pages-pricing' }">
                        <template #prepend>
                            <VIcon
                                class="me-2"
                                icon="mdi-currency-usd"
                                size="22"
                            />
                        </template>

                        <VListItemTitle>Pricing</VListItemTitle>
                    </VListItem>

                    <!-- 👉 FAQ -->
                    <VListItem :to="{ name: 'pages-faq' }">
                        <template #prepend>
                            <VIcon
                                class="me-2"
                                icon="mdi-help-circle-outline"
                                size="22"
                            />
                        </template>

                        <VListItemTitle>FAQ</VListItemTitle>
                    </VListItem>

                    <!-- Divider -->
                    <VDivider class="my-2" />

                    <!-- 👉 Logout -->
                    <VListItem link @click="logout">
                        <template #prepend>
                            <VIcon class="me-2" icon="mdi-logout" size="22" />
                        </template>

                        <VListItemTitle>Logout</VListItemTitle>
                    </VListItem>
                </VList>
            </VMenu>

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
