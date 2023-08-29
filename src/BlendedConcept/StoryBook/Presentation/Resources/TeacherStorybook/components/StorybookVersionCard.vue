<script setup></script>
<template>
    <v-card>
        <v-card-title>
            <v-btn class="dotbtn" icon="true"
            color="rgba(255, 255, 255, 0.70)"
            >
            <img src="/images/dot.png" width="10" height="18" alt="">
                <v-menu activator="parent">
                    <v-list>
                        <v-list-item>
                            <v-list-item-title>Edit</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>Delete</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </v-btn>
            <v-img src="/images/image1.png" />
        </v-card-title>
        <v-card-text class="text-center">
            <p class="text-subtitle-2" style="color: #000">Toy Story 1</p>

            <span class="text-subtitle-1 font-weight-bold">Original Copy</span>
        </v-card-text>

        <div class="my-3 mx-2">
            <v-btn class="manage-btn" variant="flat" color="#FF8015" rounded>Manage Assignment to Students</v-btn>
        </div>
    </v-card>
</template>
<style scoped>
.header-sec {
    width: 100%;
    gap: 10px;
}

.dotbtn{
   padding: 8px !important;
   position: absolute;
   z-index: 1 !important;
   right: 10% !important;
   top: 5%;
}

.manage-btn{
    color: #fff !important;
}

::v-deep .dotbtn {
    width: 28px !important;
    height: 28px !important;
}

::v-deep .manage-btn > span.v-btn__content {
    font-size: 13px !important;
}

</style>
