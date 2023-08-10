<script setup>
import {ref} from "vue"
import { useForm } from "@inertiajs/vue3";

import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import {SuccessDialog} from '@actions/useSuccess';

let form = useForm({
    plan_type: "Basic Plan",
    description: "Allow access to basic features",
    price: "$4.99",
    nofstudent: 1,
    storage_space : "1GB",
    isCustomization : false,
    isPresentation : false,
    isFullAccess : false,
    isConcurrentAccess : false,
    isWeeklyLearningReport : false,
    isDedicatedStudentReport : false,

})

let onFormSubmit = () => {
SuccessDialog({title:"Subscription plan edited"})
}

</script>
<template>
    <AdminLayout>
        <VContainer>
            <VForm class="mt-6" @submit.prevent="onFormSubmit">
            <VRow justify="space-around" :gutter="10">
                <VCol cols="6">
                    <span class="tiggie-title margin-buttom-18"> Edit Subscription Plan</span>
                </VCol>
                <VCol cols="6"></VCol>
                <VCol cols="6">
                    <span class="tiggie-subtitle ">Basic Details</span>
                    <VRow gutters="5">
                        <VCol cols="8">
                            <VLabel class="tiggie-label">Plan Name</VLabel>
                            <VTextField placeholder="Type here.." v-model="form.plan_type" />
                        </VCol>
                        <VCol cols="8">
                            <VLabel class="tiggie-label">Description</VLabel>
                            <VTextField placeholder="Type here..." v-model="form.description"/>
                        </VCol>
                        <VCol cols="8">
                            <VLabel class="tiggie-label">Price</VLabel>
                            <VTextField placeholder="Type here..." v-model="form.price" />
                        </VCol>
                    </VRow>
                </VCol>
                <VCol cols="6">
                    <span class="tiggie-subtitle">Usage Allowance</span>
                    <VRow>
                        <VCol cols="8">
                            <VLabel class="tiggie-label">Number of Student Profile</VLabel>
                            <VTextField placeholder="Type here.." v-model="form.nofstudent"/>
                        </VCol>
                        <VCol cols="8">
                            <VLabel class="tiggie-label">Storage space</VLabel>
                            <VTextField placeholder="Type here..." v-model="form.storage_space" />
                        </VCol>
                        <VCol cols="8">
                            <VRow no-gutters>
                                <VCol cols="6">
                                    <VLabel class="tiggie-label">Customization </VLabel>
                                    <VSwitch v-model="form.isCustomization" inset/>
                                </VCol>
                                <VCol cols="6">
                                    <VLabel class="tiggie-label">Personalization</VLabel>
                                    <VSwitch v-model="form.isPresentation" inset/>
                                </VCol>
                                <VCol cols="6">
                                    <VLabel class="tiggie-label">Full Library Access </VLabel>
                                    <VSwitch v-model="form.isFullAccess" inset/>
                                </VCol>
                                <VCol cols="6">
                                    <VLabel class="tiggie-label">Concurrent Access</VLabel>
                                    <VSwitch v-model="form.isConcurrentAccess" inset/>
                                </VCol>
                                <VCol cols="6">
                                    <VLabel class="tiggie-label">Weekly Learning Report </VLabel>
                                    <VSwitch v-model="form.isWeeklyLearningReport" inset/>
                                </VCol>
                                <VCol cols="6">
                                    <VLabel class="tiggie-label">Dedicated Student Report</VLabel>
                                    <VSwitch v-model="form.isDedicatedStudentReport" inset/>
                                </VCol>
                            </VRow>

                        </VCol>
                    </VRow>
                </VCol>

                 <VCol cols="12" class="d-flex flex-wrap justify-center gap-10">
                        <Link :href="route('plans.index')" class="text-black">
                           <VBtn color="gray" height="50" class="" width="200">
                            Cancel
                          </VBtn>
                        </Link>
                    <VBtn type="submit" class="" height="50" width="200"> Update </VBtn>
                </VCol>
            </VRow>
            </VForm>
        </VContainer>
    </AdminLayout>
</template>
