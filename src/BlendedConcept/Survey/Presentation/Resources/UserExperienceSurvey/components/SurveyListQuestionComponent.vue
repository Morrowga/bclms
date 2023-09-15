<script setup>
const props = defineProps(["item", "title", "subtitle"]);

console.log(props);
</script>

<template>
    <VCard class="mt-4 vw-81">
        <VCardTitle
            class="tiggie-subtitle d-flex justify-space-between align-center"
        >
            <p>{{ props?.title }}</p>

            <VMenu location="end">
                <template #activator="{ props }">
                    <VIcon
                        v-bind="props"
                        size="24"
                        icon="mdi-dots-horizontal"
                        color="black"
                        class="mt-n4"
                    />
                </template>
                <VList>
                    <VListItem
                        @click="
                            () => router.get(route('organizations.test.edit'))
                        "
                    >
                        <VListItemTitle>Edit</VListItemTitle>
                    </VListItem>
                    <VListItem @click="deleteOrganization(props.row.id)">
                        <VListItemTitle>Delete</VListItemTitle>
                    </VListItem>
                </VList>
            </VMenu>
        </VCardTitle>
        <VCardSubTitle class="pl-4 pr-10 tiggie-p width-70">
            {{ props?.subtitle }}
        </VCardSubTitle>
        <VDivider />
        <VCardText>
            <VRow no-gutters justify="start">
                <VCol cols="1">
                    <h4 class="tiggie-subtitle">Options</h4>
                </VCol>
                <VCol cols="4" class="mb-10 align-left">
                    <VList>
                        <VListItem
                            v-for="(item, i) in props.item"
                            :key="i"
                            :value="item.text"
                        >
                            <template #prepend>
                                <VIcon :icon="item.icon" />
                            </template>
                            <VListItemTitle v-text="item.text" />
                        </VListItem>
                    </VList>
                </VCol>
            </VRow>
        </VCardText>
    </VCard>
</template>
<style scoped>
.align-left {
    text-align: left;
}
</style>
