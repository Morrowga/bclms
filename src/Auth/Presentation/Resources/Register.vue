<script setup>
import { useForm, Link } from "@inertiajs/inertia-vue3";
let form = useForm({
  email: "",
  password: "",
});
</script>

<template>
      <v-row  justify="center">
      <v-col>
         <h1
                class=""
              >
                Are you signing up under
              </h1>
              <h1
                class=""
              >
                an Organization account ?
              </h1>

      </v-col>
       <v-col>
       <h1>hello world</h1>
      </v-col>
    </v-row>
</template>
