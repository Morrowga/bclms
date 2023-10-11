<script setup>
import { router } from "@inertiajs/core";
import SecondaryBtn from "@mainRoot/components/SecondaryBtn/SecondaryBtn.vue";
import axios from "axios";
import PrimaryBtn from "@mainRoot/components/PrimaryBtn/PrimaryBtn.vue";
import { useForm,usePage } from "@inertiajs/vue3";

let props = defineProps(["route", "count", "label"]);
const isDialogVisible = ref(false)
const isRewardVisible = ref(false)
const isInsufficientVisible = ref(false);

let page = usePage();

let goldCoin = computed(() => page.props.auth.data.student.num_gold_coins);
// let silverCoin = computed(() => page.props.user_info.user_detail.student.silver_coins_needed);
const rolledData = ref(null);

const currentTime = ref(null);
const errorText = ref("You don't have enough to roll the Sticker");

const roll = (num) => {
  if(goldCoin.value >= num){
    currentTime.value = num;
    isDialogVisible.value = true;
  } else {
    isInsufficientVisible.value = true;
  }
}

const rollStop = () => {
    fetchData(currentTime.value);
}

const rollAgain = () => {
    isDialogVisible.value = true;
    isRewardVisible.value = false;
}


async function fetchData(num) {
    try {
        isDialogVisible.value = false;
        const response = await axios.get('/roll-sticker?count=' + num);
        console.log(response.data);
        if(response.data !== ''){
            rolledData.value = response.data
            isRewardVisible.value = true;
        } else {
            errorText.value = 'Something went Wrong! roll again please.'
            isInsufficientVisible.value = true;
        }
    } catch (error) {
        console.error('Error fetching data:', error);
    }
};

</script>
<template #activator="{ props }">
    <VRow class="mt-8">

            <VCol cols="6" class="text-center">
                <v-btn  @click="roll(1)" variant="flat" color="#282828" width="200" height="100"  class="rollbtn pppangram-bold">Roll Once</v-btn>
                <div class="text-center">
                    <span class="rolltext ruddy-bold">Spend <strong class="ruddy-bold">1 Gold Coin</strong></span>
                </div>
            </VCol>
            <VCol cols="6" class="text-center">
                <v-btn  @click="roll(10)" variant="flat" color="#282828" width="200" height="100" class="rollbtn mx-3 pppangram-bold">Roll 10 Times</v-btn>
                <div class="text-center">
                    <span class="rolltext ruddy-bold">Spend <strong class="ruddy-bold">8 Gold Coin</strong></span>
                </div>
            </VCol>
        </VRow>
    <VDialog
        v-model="isDialogVisible"
        width="500"
    >
        <VCard class="rolling-card">
        <VCardText>
                <v-img @click="rollStop()" src="/images/rolling.gif" cover></v-img>
                <div class="d-flex justify-center">
                    <span class="ruddy-bold rolling-text">Rolling for sticker</span>
                </div>
        </VCardText>
        </VCard>
    </VDialog>

    <VDialog
        v-model="isInsufficientVisible"
        width="500"
    >
        <VCard class="rolling-card">
            <VCardText>
                    <div class="d-flex justify-center">
                        <span class="ruddy-bold notenough">{{ errorText  }}</span>
                    </div>
            </VCardText>
        </VCard>
    </VDialog>

    <VDialog v-model="isRewardVisible" :width="currentTime == 1 ? '35%' : '70%'">
        <!-- Activator -->
        <!-- <template #activator="{ props }">
            <VBtn v-bind="props"> UserExperienceSurvey </VBtn>
        </template> -->
        <!-- Dialog Content -->
            <VCard class="pa-16 rolling-card-result">
                <DialogCloseBtn
                    variant="text"
                    size="small"
                    @click="isRewardVisible = false"
                />
                <VCardText v-if="currentTime == 1">
                    <div class="d-flex justify-center">
                        <v-img :src="rolledData.image_url" class="single-roll-img" cover></v-img>
                    </div>
                    <div class="d-flex justify-center">
                        <v-img src="images/star.png" width="50" height="50"></v-img>
                        <span class="ruddy-bold rarity mt-4" :class="rolledData.rarity">{{ rolledData.rarity }}</span>
                        <v-img src="images/star.png" width="50" height="50"></v-img>
                    </div>
                    <div class="d-flex justify-center mt-3">
                        <span class="ruddy-bold stickername">{{ rolledData.name + ' !' }}</span>
                    </div>
                </VCardText>

                <VCardText v-if="currentTime == 10">
                    <VRow>
                        <VCol size="2" v-for="data in rolledData" :key="data.id">
                            <div class="d-flex justify-center">
                                <v-img :src="data.image_url" class="multi-roll-img" cover></v-img>
                            </div>
                            <div class="d-flex justify-center">
                                <v-img src="images/star.png" width="20" height="20"></v-img>
                                <span class="ruddy-bold rarity-multi" :class="data.rarity">{{ data.rarity }}</span>
                                <v-img src="images/star.png" width="20" height="20"></v-img>
                            </div>
                            <div class="d-flex justify-center mt-3">
                                <span class="ruddy-bold stickername-multi">{{ data.name + ' !' }}</span>
                            </div>
                        </VCol>
                    </VRow>
                </VCardText>

                <div>
                    <div class="d-flex justify-center mt-5">
                        <PrimaryBtn :block="true"
                        :isLink="false"
                        @click="rollAgain"
                        :height="80"
                        class="mr-2"
                        type="button" title="Roll Again" />
                        <PrimaryBtn :block="true"
                        :isLink="false"
                        :height="80"
                        type="button" title="Go To Sticker Book" />
                    </div>
                </div>
            </VCard>
    </VDialog>
</template>
<style scoped>
.rolling-card{
    border: 3px solid #000;
    cursor: pointer;
    background: var(--seaform, #D7F2F0);
}

.rolling-card-result{
    border: 10px solid #000;
    cursor: pointer;
    background: var(--seaform, #D7F2F0);
}

.stickername{
    font-size: 35px !important;
    color: #000 !important;
}
.rolling-text{
    bottom: 4%;
    color: var(--teal, #17CAB6) !important;
    text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25) !important;
    font-size: 30px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 104% */
    text-transform: capitalize;
    position: absolute !important;
}

.LEGENDARY{
    color: #FD961C !important;
}

.SUPERRARE{
    color: #ab1412 !important;
}

.RARE{
    color: #0046b3 !important;
}
.EPIC{
    color: #6847d2 !important;
}

.COMMON{
    color: #375e4d !important;
}

.notenough{
    color: red;
}
.rarity{
    font-size: 35px !important;
}
.rarity-multi{
    font-size: 20px !important;
}

.stickername-multi{
    font-size: 20px !important;
}
.single-roll-img{
    width: 70%;
}

.multi-roll-img{
    width: 30%;
}
</style>
