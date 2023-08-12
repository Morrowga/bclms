<script setup>

const props = defineProps(['item', 'title', 'subtitle']);

console.log(props)
</script>

<template>
    <VCard style="width:81vw" class="mt-4">
        <VCardTitle class="tiggie-subtitle d-flex justify-space-between align-center">
            <p>{{ props?.title }}</p>

            <VMenu location="end">
                <template #activator="{ props }">
                    <VIcon v-bind="props" size="24" icon="mdi-dots-horizontal" color="black" class="mt-n4" />
                </template>
                <VList>

                    <VListItem @click="() => router.get(route('organizations.test.edit'))">
                        <VListItemTitle>Edit</VListItemTitle>
                    </VListItem>
                    <VListItem @click="deleteOrganization(props.row.id)">
                        <VListItemTitle>Delete</VListItemTitle>
                    </VListItem>
                </VList>
            </VMenu>
        </VCardTitle>
        <VCardSubTitle class="pl-4 pr-10 tiggie-p" style="width:70% !important">
            {{ props?.subtitle }}
        </VCardSubTitle>
        <VDivider />
        <VCardText>
            <VRow no-gutters justify="start">
                <VCol cols="1">
                    <h4 class="tiggie-subtitle">Options</h4>
                </VCol>
                <VCol cols="4" style="text-align: left;" class="mb-10">
                    <VList>
                        <VListItem v-for="(item, i) in props.item" :key="i" :value="item.text">
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
