<script setup>
import { themeConfig } from "@themeConfig";
import { onMounted, ref } from "vue";
import { Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { toastAlert } from "@Composables/useToastAlert";
import { loadStripe } from "@stripe/stripe-js";
import axios from "axios";
import SecondaryBtn from "@mainRoot/components/SecondaryBtn/SecondaryBtn.vue";
import PrimaryBtn from "@mainRoot/components/PrimaryBtn/PrimaryBtn.vue";

import B2CRegister from "./B2CRegister.vue";
import B2BRegister from "./B2BRegister.vue";

const props = defineProps({
    form: {
        type: Object,
    },
    plans: {
        type: Object,
    }
});
const emit = defineEmits(["update:hasSurvey", "update:isDialogVisible"]);

const stripePromise = loadStripe(
    "pk_test_51O3CwpFAxSyBvPem5qU56paMzEVJzZ2dwLNZWCf8FB0PvQ4hZZwYRQ9THQl1AWDavJPE9YWoMwYT1qQXTJkGBPVd00U17bOF2t"
);
let elements;
const isDonePayment = ref(false);

const isDialogVisible = ref(false);

const spinner = ref(false);
const disable = ref(false);

const stripes = ref(null);

const isPasswordVisible = ref(false);

let emailAddress = props.form.email;

// Fetches a payment intent and captures the client secret
async function initialize(data) {
    try {
        let stripeData = [{ id: data.id }];
        const response = await axios.post("/create-stripe?cost=" + parseInt(data.price), {
            body: JSON.stringify({ stripeData }),
        });

        const { clientSecret } = response.data;

        const stripe = await stripePromise; // Wait for Stripe to load

        elements = stripe.elements({ clientSecret });

        const linkAuthenticationElement = elements.create("linkAuthentication");
        linkAuthenticationElement.mount("#link-authentication-element");

        const paymentElementOptions = {
            layout: "tabs",
        };
        const paymentElement = elements.create(
            "payment",
            paymentElementOptions
        );
        paymentElement.mount("#payment-element");
    } catch (error) {
        console.log(error);
    }
}

// Fetches the payment intent status after payment submission
async function checkStatus() {
    const clientSecret = new URLSearchParams(window.location.search).get(
        "payment_intent_client_secret"
    );

    if (!clientSecret) {
        return;
    }

    const { paymentIntent } = await stripePromise.retrievePaymentIntent(
        clientSecret
    );

    switch (paymentIntent.status) {
        case "succeeded":
            showMessage("Payment succeeded!");
            break;
        case "processing":
            showMessage("Your payment is processing.");
            break;
        case "requires_payment_method":
            showMessage("Your payment was not successful, please try again.");
            break;
        default:
            showMessage("Something went wrong.");
            break;
    }
}

async function handleSubmit(e) {
  e.preventDefault();
  setLoading(true);

  const stripe = await stripePromise; // Wait for Stripe to load

  stripe
    .confirmPayment({
      elements,
      confirmParams: {
        // Make sure to change this to your payment completion page
        receipt_email: emailAddress,
      },
      redirect: 'if_required',
    })
    .then((result) => {
      if (result.error) {
        // Handle any errors
        if (result.error.type === "card_error" || result.error.type === "validation_error") {
            setLoading(false);
          showMessage(result.error.message);
        } else {
          setLoading(false);
          showMessage("An unexpected error occurred.");
        }
      } else {
        console.log(result.paymentIntent.status)
        if(result.paymentIntent.status == 'succeeded'){
            emit("update:isDialogVisible", false);
            isDialogVisible.value = false;
            if(props.form.student_code != null || props.form.student_code != ''){
                chooseBothPlan()
            } else {
                choosePaidPlan()
            }
            isDonePayment.value = true;
        }
        // Payment was successful, you can handle success here
        showMessage("Payment was successful!");
        // You can redirect to a success page or perform any other action you need
      }
    });

  function showMessage(messageText) {
    const messageContainer = document.querySelector("#payment-message");

    messageContainer.classList.remove("hidden");
    messageContainer.textContent = messageText;

    setTimeout(function () {
      messageContainer.classList.add("hidden");
      messageContainer.textContent = "";
    }, 4000);
  }

  function setLoading(isLoading) {
    if (isLoading) {
      // Disable the button and show a spinner
      disable.value = true;
      spinner.value = true;
    } else {
      disable.value = false;
      spinner.value = false;
    }
  }
}


const showPayment = (data) => {
    isDialogVisible.value = true;
    props.form.plan = data.id
    props.form.price = data.price
    initialize(data);
    checkStatus();
};

const chooseFreePlan = () => {
    if(props.form.student_code != null || props.form.student_code != ''){
        chooseBothPlan()
    } else {
        props.form.post(route("choose-free-plan"), {
            onSuccess: () => {
                isDonePayment.value = true
            },
        });
    }
};

const resend = () => {
    props.form.post(route("resend"), {
        onSuccess: () => {
            // router.get(route("login"));
        },
    });
}

const closeAndLogin = () => {
    isDonePayment.value = false
    router.get(route("login"));
}

const choosePaidPlan = () => {
    props.form.post(route("choose-paid-plan"), {
        onSuccess: () => {
            // router.get(route("login"));
        },
    });
};

const chooseBothPlan = () => {
    props.form.post(route("choose-both-plan"), {
        onSuccess: () => {
            // router.get(route("login"));
        },
    });
};
</script>

<template>
    <div>
        <div class="layout-navbar">
            <div
                class="navbar-content-container d-flex justify-space-between px-10 py-5"
            >
                <h1
                    class="text-h5 font-weight-bold leading-normal text-capitalize"
                >
                    {{ themeConfig.app.title }}
                </h1>
                <VBtn color="primary" class="b-0 text-white">
                    <Link :href="route('login')" class="text-white">
                        Login
                    </Link>
                </VBtn>
            </div>
        </div>
        <SystemErrorAlert
            :sytemErrorMessage="sytemErrorMessage"
            v-if="sytemErrorMessage"
        />

        <VDivider></VDivider>

        <div class="text-center mt-5">
            <p class="pppangram-bold plan-title">Plans</p>
            <VRow class="mt-10">
                <VCol cols="3"> </VCol>
                <VCol cols="6" class="text-left input-awine">
                    <p class="plan-text pppangram-bold">
                        How many student accounts do you need ?
                    </p>
                    <VTextField
                        placeholder="eg 5 "
                        variant="plain"
                        density="compact"
                    >
                        <template #append-inner>
                            <VIcon
                                icon="mdi-magnify"
                                size="26px"
                                height="26px"
                                class="abs-top"
                            >
                            </VIcon>
                        </template>
                    </VTextField>
                </VCol>
                <VCol cols="3"> </VCol>
            </VRow>
        </div>

        <div class="mx-15">
            <table class="heavyTable">
                <thead>
                    <tr>
                        <th>
                            <div class="th-emtpy-width"></div>
                        </th>
                        <th v-for="plan in props.plans" :key="plan.id">
                            <div class="th-width">
                                <p class="th-text pppangram-bold mt-5">{{ plan.name }}</p>

                                <p
                                    class="text-left ml-3 plan-mini-text textmargin"
                                >
                                    {{  plan.description }}
                                    <!-- ss<strong>0</strong> <br />
                                    /month -->
                                </p>
                            </div>
                            <VBtn
                                @click="plan.id == 1 ? chooseFreePlan() : showPayment(plan)"
                                class="th-btn mb-5"
                                color="#FC0"
                                variant="flat"
                                rounded
                                >Sign Up</VBtn
                            >
                        </th>
                        <!-- <th>
                            <div class="th-width">
                                <p class="th-text pppangram-bold mt-5">Base</p>

                                <p class="text-left plan-mini-text ml-3 mt-15">
                                    Free <br />
                                    for 1 month <br />
                                    Then, starts of ss<strong>10</strong> <br />
                                    /month
                                </p>
                            </div>
                            <VBtn
                                class="th-btn mb-5"
                                color="#FC0"
                                variant="flat"
                                rounded
                                @click="showPayment()"
                                >Sign Up</VBtn
                            >
                        </th>
                        <th>
                            <div class="th-width">
                                <p class="th-text pppangram-bold mt-5">Pro</p>

                                <p class="text-left plan-mini-text ml-3 mt-15">
                                    Free <br />
                                    for 1 month <br />
                                    Then, starts of ss<strong>50</strong> <br />
                                    /month
                                </p>
                            </div>
                            <VBtn
                                class="th-btn mb-5"
                                color="#FC0"
                                variant="flat"
                                rounded
                                @click="showPayment()"
                                >Sign Up</VBtn
                            >
                        </th>
                        <th>
                            <div class="th-width">
                                <p class="th-text pppangram-bold mt-5">
                                    Premium
                                </p>

                                <p class="text-left plan-mini-text ml-3 mt-15">
                                    Free <br />
                                    for 1 month <br />
                                    Then, starts of ss<strong>100</strong>
                                    <br />
                                    /month
                                </p>
                            </div>
                            <VBtn
                                class="th-btn mb-5"
                                color="#FC0"
                                variant="flat"
                                rounded
                                @click="showPayment()"
                                >Sign Up</VBtn
                            >
                        </th> -->
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-left">
                        <td >Free Student Profile</td>
                        <td v-for="plan in props.plans" :key="plan.id">{{ plan.num_student_profiles }}</td>
                    </tr>
                    <tr class="text-left">
                        <td>Additional Student Profile</td>
                        <td v-for="plan in props.plans" :key="plan.id">
                          <VIcon :icon="plan.id == 1 ? 'mdi-close' : 'mdi-check'"></VIcon>
                        </td>
                    </tr>
                    <tr class="text-left">
                        <td>Storage Space</td>
                        <td v-for="plan in props.plans" :key="plan.id">{{ plan.storage_limit == '0.00' ? 'NA' : plan.storage_limit + ' GB'}}</td>
                    </tr>
                    <tr class="text-left">
                        <td>Free Library Access</td>
                        <td v-for="plan in props.plans" :key="plan.id">
                            <VIcon icon="mdi-check"></VIcon>
                        </td>
                    </tr>
                    <tr class="text-left">
                        <td>Personalization</td>
                        <td v-for="plan in props.plans" :key="plan.id">
                            <VIcon :icon="plan.allow_personalisation != 1 ? 'mdi-close' : 'mdi-check'"></VIcon>
                        </td>
                    </tr>
                    <tr class="text-left">
                        <td>Customization</td>
                        <td v-for="plan in props.plans" :key="plan.id">
                            <VIcon :icon="plan.allow_customisation != 1 ? 'mdi-close' : 'mdi-check'"></VIcon>
                        </td>
                    </tr>
                    <tr class="text-left">
                        <td>Full Library Access</td>
                        <td v-for="plan in props.plans" :key="plan.id">
                            <VIcon :icon="plan.full_library_access != 1 ? 'mdi-close' : 'mdi-check'"></VIcon>
                        </td>
                    </tr>
                    <tr class="text-left">
                        <td>Concurrent Access</td>
                        <td v-for="plan in props.plans" :key="plan.id">
                            <VIcon :icon="plan.concurrent_access != 1 ? 'mdi-close' : 'mdi-check'"></VIcon>
                        </td>
                    </tr>
                    <tr class="text-left">
                        <td>Weekly Learning Progress Report</td>
                        <td v-for="plan in props.plans" :key="plan.id">
                            <VIcon :icon="plan.weekly_learning_report != 1 ? 'mdi-close' : 'mdi-check'"></VIcon>
                        </td>
                    </tr>
                    <tr class="text-left">
                        <td>Dedicated Student Report</td>
                        <td v-for="plan in props.plans" :key="plan.id">
                            <VIcon :icon="plan.dedicated_student_report != 1 ? 'mdi-close' : 'mdi-check'"></VIcon>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <VDialog v-model="isDialogVisible" width="50%">
            <VCard class="pa-16">
                <!-- <DialogCloseBtn
                    variant="text"
                    size="small"
                    @click="isDialogVisible = false"
                /> -->
                <div class="text-end">
                    <VBtn
                        color="secondary"
                        variant="text"
                        @click="isDialogVisible = false"
                        icon
                    >
                        <VIcon>mdi-close</VIcon>
                    </VBtn>
                </div>
                <VCardSutitle class="">
                    <div class="mt-10">
                        <VRow>
                            <VCol cols="8" offset-md="2">
                                <VBtn
                                    color="#000"
                                    class="text-white"
                                    prepend-icon="mdi-apple"
                                    block
                                    >Pay</VBtn
                                >
                            </VCol>
                        </VRow>
                    </div>
                    <div class="divider-container mt-10">
                        <div class="divider"></div>
                        <span class="pppangram-normal">Or pay with card</span>
                        <div class="divider"></div>
                    </div>
                    <div class="mt-10">
                        <VRow>
                            <VCol cols="8" offset-md="2">
                                <form id="payment-form">
                                    <div id="link-authentication-element">
                                        <!--Stripe.js injects the Link Authentication Element-->
                                    </div>
                                    <div id="payment-element">
                                        <!--Stripe.js injects the Payment Element-->
                                    </div>
                                    <VBtn
                                        id="submit"
                                        class="stripe-submit mt-3"
                                        :disabled="disable"
                                        :loading="spinner"
                                        block
                                    >
                                        <span
                                            id="button-text"
                                            @click="handleSubmit"
                                            v-if="!spinner"
                                            >Pay now</span
                                        >
                                    </VBtn>
                                    <div
                                        id="payment-message"
                                        class="hidden"
                                    ></div>
                                </form>
                            </VCol>
                        </VRow>
                    </div>
                </VCardSutitle>
            </VCard>
        </VDialog>
        <VDialog v-model="isDonePayment" width="50%">
            <VCard class="pa-16">
                <div class="text-end">
                    <VBtn
                        color="secondary"
                        variant="text"
                        @click="isDonePayment = false"
                        icon
                    >
                        <VIcon>mdi-close</VIcon>
                    </VBtn>
                </div>

                <VCardSubtitle class="text-center">
                    <span class="pppangram-bold head-signup"
                        >Thank You For Signing Up!</span
                    >
                    <p class="mt-4">
                        We've sent a verification email to
                        <Link href="">{{ emailAddress }}</Link> to verify your
                        email address and <br />
                        activate your account. The link is your email will
                        expire in 24 hours.
                    </p>
                </VCardSubtitle>

                <VCardActions class="mt-10">
                    <VRow justify="center">
                        <VCol cols="5">
                            <SecondaryBtn
                                type="button"
                                @click="closeAndLogin"
                                title="Close"
                            />
                        </VCol>
                        <VCol cols="5">
                            <PrimaryBtn
                                @click="resend"
                                :isLink="false"
                                type="button"
                                title="Resend Email"
                            />
                        </VCol>
                    </VRow>
                </VCardActions>
            </VCard>
        </VDialog>
    </div>
</template>

<style lang="scss" scoped>
@use "@styles/@core/template/pages/page-auth.scss";
.regiser-image {
    //   background: url("/public/images/signupnew.png") 100% no-repeat;
    height: 100vh;
    background-size: cover;
}
.th-btn {
    width: 90% !important;
    color: #fff;
}

.divider-container {
    display: flex;
    align-items: center; /* Center items vertically */
}

.divider {
    flex: 1; /* Distribute remaining space equally on both sides */
    border-top: 1px solid rgb(0, 0, 0, 0.2); /* Style the divider line */
    margin: 0 10px; /* Add some spacing between the text and the dividers */
}

.textmargin {
    margin-top: 12vh;
}

.textmargin1 {
    margin-top: 10vh;
}

.head-signup {
    font-size: 20px !important;
    color: #000;
}

.plan-mini-text {
    font-size: 12px !important;
}

.plan-title {
    color: var(--Text, #161616);
    font-size: 36px !important;
    font-style: normal;
    font-weight: 700;
    line-height: 44px; /* 122.222% */
    text-transform: capitalize;
}

.heavyTable {
    width: 100%;
    height: 326px;
    border-collapse: collapse;
    border: 1px solid #38678f;
    margin: 50px auto;
    background: white;
    box-shadow: 0px 2px 10px 0px rgba(76, 78, 100, 0.22);
}

.heavyTable > thead > tr > th {
    border: 1px solid #bfc0c1 !important;
}

.heavyTable > thead {
    background: #fff !important;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

.heavyTable > tbody > tr:nth-child(odd) {
    background: #bfc0c1 !important;
}

.heavyTable > tbody > tr > td:nth-child(1) {
    width: 35vh;
}

.color-black {
    color: #000 !important;
}

.heavyTable > tbody > tr > td {
    border: 1px solid rgb(0, 0, 0, 0.2) !important;
    padding: 10px;
}

.th-width {
    width: 100px;
    padding: 10px !important;
    height: 300px;
}

.td-width {
    width: 50px;
    padding: 10px !important;
    height: 300px;
}

.plan-text {
    color: var(--Graphite, #282828);
    font-size: 16px !important;
    font-style: normal;
    font-weight: 700;
    line-height: 26px; /* 162.5% */
}

.th-text {
    color: var(--Graphite, #282828);
    text-align: center;
    /* H3 Pangram Bold */
    font-size: 40px !important;
    font-style: normal;
    font-weight: 700;
    line-height: 32px; /* 80% */
}
// .primary {
//   color: #001a8f !important;
// }

:deep(.input-awine .v-text-field input) {
    border-radius: 100px !important;
    border: 1px solid #bfc0c1 !important;
    padding: 8px 16px 8px 20px !important;
    background: #fff !important;
}
:deep(.custom-label-color .v-field__append-inner) {
    margin-top: 5px !important;
}

.check-circle{
    color: green;
}

.check-false{
    color: red;
}

.abs-top {
    position: absolute;
    right: 10px;
}

//stripe payment element
#payment-message {
    color: rgb(105, 115, 134);
    font-size: 16px;
    line-height: 20px;
    padding-top: 12px;
    text-align: center;
}

#payment-element {
    margin-bottom: 24px;
}

/* Buttons and links */
.stripe-submit {
    border-radius: 4px;
    border: 0;
    font-size: 16px;
    font-weight: 600;
    display: block;
    transition: all 0.2s ease;
    width: 100%;
}

.stripe-submit:hover {
    filter: contrast(115%);
}
.stripe-submit:disabled {
    opacity: 0.5;
    cursor: default;
}

@media only screen and (max-width: 600px) {
    form {
        width: 80vw;
        min-width: initial;
    }
}
</style>
