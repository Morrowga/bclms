<script setup>
// import RecommendedGameCard from "./RecommendedGameCard.vue";
import CreateStorybookVersion from "./CreateStorybookVersion.vue";

const props = defineProps(["games"]);

console.log(props.games)
</script>
<template>
  <div>
    <div class="header-sec d-flex justify-center align-center">
      <span> Recommended Games </span>
    </div>
    <div class="body-sec">
      <div
        class="d-flex justify-start justify-md-center align-center gap-10 f-wrap"
      >
        <div v-for="item in games.data" :key="item.id" class="width-290">
          <div>
            <div class="body-sec">
              <div
                class="d-flex justify-start justify-md-center align-center gap-10 f-wrap"
              >
                <v-card>
                  <v-card-title>
                    <v-img :src="item.thumbnail" />
                  </v-card-title>

                  <v-card-text class="text-center">
                    <div class="text-center">
                      <span class="text-subtitle-2 font-weight-bold t-black">
                        {{item.name}}
                      </span>
                      <br />
                      <span class="text-subtitle-1 font-weight-bold">
                      {{item.description}}
                      </span>
                    </div>
                  </v-card-text>
                </v-card>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.header-sec {
  width: 100%;
  gap: 20px;
}
.header-sec span {
  color: var(--text, #161616);
  /* H3 Ruddy */

  font-size: 40px !important;
  font-style: normal !important;
  font-weight: 700 !important;
  line-height: 52px !important; /* 130% */
  text-transform: capitalize !important;
}
.body-sec {
  padding-top: 40px;
}
</style>
