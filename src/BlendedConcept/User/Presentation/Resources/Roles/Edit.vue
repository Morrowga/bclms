<script setup>
import {
  watch,
  defineEmits,
  defineProps,
  computed,
  ref,
  onMounted,
  onUpdated,
} from "vue";
import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";

const isDialogVisible = ref(false);
let props = defineProps(["permissions", "role"]);
const isFormValid = ref(false);
const refForm = ref();
let module_arr = ref([]);
//## get only module from permission
let modules = computed(() => {
  let permissions = [];
  props.permissions.forEach((permission) => {
    let perArray = permission.name.split("_");
    permissions.push(perArray[1]);
  });
  return new Set(permissions);
});

//## get modules with related permission
let permissions_modules = computed(() => {
  let newArrays = [];
  modules.value.forEach((item, index) => {
    newArrays.push({
      key: index,
      name: item,
      permissions: props.permissions.filter((permission) =>
        permission.name.includes(item)
      ),
    });
  });
  return newArrays;
});
//## for form submit
let form = useForm({
  name: props.role.name,
  description: props.role.description,
  selectedIds: [],
});
//## uncheck modules when selectedIds array is empty
let watchSelectedIds = watch(form.selectedIds, (value) => {
  if (value.length <= 0) {
    document.getElementById("check-all-edit" + props.role.id).checked = false;
  }
});
//## select all permissions
let selectAll = () => {
  form.selectedIds = [];
  let isChecked = document.getElementById(
    "check-all-edit" + props.role.id
  ).checked;
  if (isChecked) {
    modules.value.forEach((item, index) => {
      document.getElementById(
        `${props.role.id}-edit-checkbox-${index}`
      ).checked = true;
      selectByModule(item, index);
    });
  } else {
    modules.value.forEach((item, index) => {
      document.getElementById(
        `${props.role.id}-edit-checkbox-${index}`
      ).checked = false;
    });
    form.selectedIds = [];
  }
};
//## select permission by module
let selectByModule = (item, index) => {
  let isChecked = document.getElementById(
    `${props.role.id}-edit-checkbox-${index}`
  ).checked;
  if (isChecked) {
    props.permissions.forEach((per) => {
      if (
        per.name.split("_")[1].includes(item) &&
        !form.selectedIds.includes(per.id)
      ) {
        form.selectedIds.push(per.id);
      }
    });
  } else {
    props.permissions.forEach((per) => {
      if (per.name.split("_")[1].includes(item)) {
        form.selectedIds = form.selectedIds.filter((item) => item != per.id);
      }
    });
  }
};
//## updateRole
let updateRole = (id) => {
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
      form.put(route("roles.update", { id: id }), form, {
        onSuccess: () => {},
        onError: (error) => {
          form.setError("name", error?.name);
        },
      });
      //## form.reset();
      isDialogVisible.value = false;
      refForm.value?.reset();
      refForm.value?.resetValidation();
    }
  });
};

onUpdated(() => {
  //## reative name and description when edit
  form.selectedIds = [];
  props.role.permissions.filter((rp) => form.selectedIds.push(rp.id));
  form.name = props.role.name;
  form.description = props.role.description;
});
</script>

<template>
  <VDialog v-model="isDialogVisible" max-width="1000">
    <!-- Dialog Activator -->
    <template #activator="{ props }">
      <VBtn
        density="compact"
        icon="mdi-pencil"
        class="ml-2 bg-success"
        v-bind="props"
      >
      </VBtn>
    </template>

    <!-- Dialog Content -->
    <VCard title="Add Role">
      <VForm
        ref="refForm"
        v-model="isFormValid"
        @submit.prevent="updateRole(props.role.id)"
      >
        <DialogCloseBtn
          variant="text"
          size="small"
          @click="isDialogVisible = false"
        />

        <VCardText>
          <VRow>
            <VCol cols="12">
              <VTextField
                label="Role Name"
                v-model="form.name"
                :rules="[requiredValidator]"
              />
            </VCol>
            <VCol cols="12">
              <VTextarea label="Description" v-model="form.description" />
            </VCol>
            <VCol cols="12">
              <div class="mb-6 flex-auto">
                <label for="permission" class="px-6"
                  >Assign Permission To Roles</label
                >

                <div class="relative overflow-x-auto">
                  <table class="w-100">
                    <thead>
                      <tr>
                        <th scope="col" class="px-4 py-4">
                          <div class="flex items-center">
                            <VCheckbox
                              :id="'check-all-edit' + props.role.id"
                              label="Module"
                              density="compact"
                              @click="selectAll"
                              style="font-weight: bold"
                            >
                              <template #label="{ label }">
                                <span>{{ label }}</span>
                              </template>
                            </VCheckbox>
                          </div>
                        </th>
                        <th scope="col" class="px-6 py-3" align="start">
                          <VLabel> Permissions </VLabel>
                        </th>
                      </tr>
                    </thead>
                    <tbody class="text-xs">
                      <tr v-for="item in permissions_modules" :key="item.key">
                        <td class="px-4 py-4">
                          <VCheckbox
                            :id="role.id + '-edit-checkbox-' + item.key"
                            @click="selectByModule(item.name, item.key)"
                            :label="item.name"
                            density="compact"
                            style="font-weight: bold"
                          >
                            <template #label="{ label }">
                              <span class="text-no-wrap">{{ label }}</span>
                            </template>
                          </VCheckbox>
                        </td>
                        <td class="px-4 py-4">
                          <VRow>
                            <VCol
                              cols="4"
                              md="2"
                              v-for="permission in item.permissions"
                              :key="permission.id"
                            >
                              <VCheckbox
                                v-model="form.selectedIds"
                                :value="permission.id"
                                :label="permission.name"
                                density="compact"
                                style="font-weight: bold"
                              >
                                <template #label="{ label }">
                                  <span>{{ label.split("_")[0] }}</span>
                                </template>
                              </VCheckbox>
                            </VCol>
                          </VRow>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </VCol>
          </VRow>
        </VCardText>

        <VCardActions>
          <VSpacer />
          <VBtn color="error" @click="isDialogVisible = false"> Close </VBtn>
          <VBtn type="submit" color="success"> Save </VBtn>
        </VCardActions>
      </VForm>
    </VCard>
  </VDialog>
</template>
<style lang="scss" scoped>
table td,
table td * {
  vertical-align: top;
}
</style>
