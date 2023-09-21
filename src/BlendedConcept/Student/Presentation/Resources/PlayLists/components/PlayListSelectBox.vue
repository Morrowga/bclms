<script setup>
import GreenChip from "@mainRoot/components/GreenChip/GreenChip.vue";
import ChipWithBlueDot from "@mainRoot/components/ChipWithBlueDot/ChipWithBlueDot.vue";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
const props = defineProps({
  datas: {
    type: Object,
    required: true,
  },
  storybooks: {
    type: Object,
    required: true,
  },
});

const stateList = [
    "Alabama",
    "Alaska",
    "Arizona",
    "Arkansas",
    "California",
    "Colorado",
    "Connecticut",
    "Delaware",
    "Florida",
    "Georgia",
    "Hawaii",
];

const panel = ref(0);


const extractStudentId = (studentId) => {
    console.log('Student ID:', studentId);
 }

 const selectedStorybooks = ref([]);

// Function to add or remove a storybook ID from the selectedStorybooks array
const toggleSelectedStorybook = (storybookId) => {
  const index = selectedStorybooks.value.indexOf(storybookId);
  if (index === -1) {
    selectedStorybooks.value.push(storybookId);
  } else {
    selectedStorybooks.value.splice(index, 1);
  }
  console.log(selectedStorybooks.value);
};

</script>

<template>
    <VExpansionPanels v-model="panel">
        <VExpansionPanel>
            <VExpansionPanelTitle class="tiggie-teacher-title"
                >Step 1: Select Student</VExpansionPanelTitle
            >

            <VExpansionPanelText>
                <VForm @submit.prevent="() => {}">
                    <VRow justify="center">
                        <VCol cols="12">
                            <VTextField
                                placeholder="Search ..."
                                append-inner-icon=""
                                density="compact"
                                rounded
                            >
                                <template #append-inner>
                                    <VIcon
                                        v-bind="props"
                                        icon="mdi-magnify"
                                        size="30"
                                    />
                                </template>
                            </VTextField>
                        </VCol>
                    </VRow>
                    <VRow class="bg-line rounded pa-1 mb-5" align="center">
                        <VCol cols="3" class="ml-4">
                            <VLabel class="tiggie-label">Name</VLabel>
                            <VIcon icon="mdi-menu-down"></VIcon>
                        </VCol>
                        <VCol cols="2">
                            <VLabel class="tiggie-label"
                                >Education Level</VLabel
                            >
                            <VIcon icon="mdi-menu-down"></VIcon>
                        </VCol>

                        <VCol cols="1">
                            <VLabel class="tiggie-label">Age</VLabel>
                            <VIcon icon="mdi-menu-down"></VIcon>
                        </VCol>
                        <VCol cols="4">
                            <VLabel class="tiggie-label"
                                >Disability Type</VLabel
                            >
                            <VIcon icon="mdi-menu-down"></VIcon>
                        </VCol>
                    </VRow>
                    <VRow
                        class="bg-line rounded pa-5 mb-2"
                        align="center"
                        v-for="item in props.datas"
                        :key="item"
                    >
                        <VCol cols="3">
                            <div class="d-flex align-center gap-1">
                                <VRadio @click="extractStudentId(item.student_id)" />
                                <VImg
                                    src="/teacherdashboard/student1.png"
                                    width="56px"
                                    height="56px"
                                />
                                <span
                                    class="tiggie-teacher-label tiggie-black-color"
                                    >{{ item.user.full_name  }}</span
                                >
                            </div>
                        </VCol>
                        <VCol cols="2">
                            <span
                                class="tiggie-teacher-label ml-10 tiggie-black-color"
                                >{{ item.education_level }}</span
                            >
                        </VCol>
                        <VCol cols="1">
                            <span
                                class="tiggie-teacher-label ml-5 tiggie-black-color"
                                >{{item.age}}</span
                            >
                        </VCol>
                        <VCol cols="4">
                            <div class="d-flex flex-column gap-2 w-50">
                                <ChipWithBlueDot
                                v-for="disability_type in props.datas.disability_types"
                                 :key="disability_type"
                                    title="Down Syndrome"
                                    class="ma-1"
                                />
                            </div>
                        </VCol>
                    </VRow>
                    <VRow justify="center" align="center">
                        <VPagination
                            v-model="currentPage"
                            variant="outlined"
                            :length="5"
                        />
                    </VRow>
                </VForm>
            </VExpansionPanelText>
        </VExpansionPanel>
        <VExpansionPanel>
            <VExpansionPanelTitle class="tiggie-teacher-title"
                >Step 2: Select Storybooks</VExpansionPanelTitle
            >
            <VExpansionPanelText>
                <VRow justify="end">
                    <VCol cols="2">
                        <VTextField
                            placeholder="Search ..."
                            density="compact"
                            rounded
                        >
                            <template #append-inner>
                                <VIcon
                                    v-bind="props"
                                    icon="mdi-magnify"
                                    size="30"
                                />
                            </template>
                        </VTextField>
                    </VCol>

                    <VCol cols="2">
                        <SelectBox
                            placeholder="Sort By"
                            density="compact"
                            rounded
                        >
                        </SelectBox>
                    </VCol>
                </VRow>
                <VRow justify="center">
                    <VCol cols="3" v-for="item in props.storybooks" :key="item" class="pa-1">
                        <VCard>
                            <VImg
                                :src="item.thumbnail_img == '' || item.thumbnail_img == null  ? 'images/2.jpg' : item.thumbnail_img"
                                height="282px"
                                cover
                            />
                            <div class="select-box">
                                <VCheckbox
                                    color="secondary"
                                    class="checkbox-position"
                                    :value="item.id"
                                    @change="toggleSelectedStorybook(item.id)"
                                />
                            </div>
                            <VCardItem>
                                <VCardTitle
                                    class="text-center tiggie-teacher-p tiggie-black-color fw-700"
                                    >
                                    <!-- {{}} -->
                                </VCardTitle>
                            </VCardItem>
                            <VCardActions>
                                <div class="d-flex gap-1">
                                    <GreenChip title="Switch" />
                                    <GreenChip title="Eye-Gaze" />
                                    <GreenChip title="Touch" />
                                </div>
                            </VCardActions>
                        </VCard>
                    </VCol>
                </VRow>
                <VRow justify="center">
                    <VCol cols="2">
                        <VBtn
                            variant="flat"
                            color="pale-blue"
                            class="text-tiggie-blue"
                            rounded
                        >
                            Load more
                        </VBtn>
                    </VCol>
                </VRow>
            </VExpansionPanelText>
        </VExpansionPanel>
    </VExpansionPanels>
</template>

<style lang="scss">
.delivery-options {
    .v-selection-control-group {
        inline-size: 100%;
    }
}

.delivery-option {
    padding: 1rem;
    border: 1px solid rgba(var(--v-border-color), var(--v-border-opacity));

    &.active {
        border-color: rgb(var(--v-theme-primary));
    }
}
.checkbox-position {
    position: absolute;
    top: 4px;
    right: 10px;
    padding: initial;
    color: #282828;
}

.chip {
    background-color: #ffffff !important;
}

input[type="checkbox"] {
    accent-color: red !important;
}
</style>
