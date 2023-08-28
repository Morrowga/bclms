<script setup></script>
<template>
     <v-card width="300" class="mr-5">
    <div class="resource-main">
      <img src="/images/pdf.png" alt="">
      <div class="physicalresourcepdfbar pa-1 px-2 d-flex align-center" @mouseover="showHoverContent" @mouseout="hideHoverContent">
        <div class="physicalresource-child-content">
          <img src="/images/pdficon.png" class="px-2" />
          <span>Receiptasdasfddsfsadfasdf...</span>
        </div>
        <div class="hover-content" v-show="hovering">
            <img src="/images/pdficon.png" class="px-2" />
          <!-- Add the full content of the card here -->
          <!-- You can use any additional HTML/CSS here -->
        </div>
      </div>
    </div>
  </v-card>
</template>
<style>
.physicalresourcepdfbar > .physicalresource-child-content > span {
    color: #fff !important;
}

.physicalresource-child-content{
    padding: 10px !important;
}

.physicalresourcepdfbar {
  background: rgba(22, 22, 22, 0.80) !important;
}
</style>
