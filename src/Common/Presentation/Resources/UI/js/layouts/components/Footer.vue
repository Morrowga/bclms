<template>
    <img src="/images/defaults/divider.png" class="footer-image"/>
    <div class="h-100 d-flex align-center justify-space-between footer-font-style ">
        <!-- 👉 Footer: left content -->
        <span class="d-flex align-center footer-font-style">
            &copy;
            {{ new Date().getFullYear() }}
            Made With
            <VIcon icon="mdi-heart" color="error" size="1.25rem" class="mx-1" />
            By
            <span href="#" target="_blank" rel="noopener noreferrer" class="ms-1 leaptech">Leaptechnology</span>
        </span>
        <span class="company-contact footer-font-style">
            +65 1234 5678
        </span>
        <!-- 👉 Footer: right content -->
        <span class="d-md-flex gap-x-4 text-primary d-none footer-font-style">
            <a
                href="/"
                class="footer-font-style"
                target="noopener noreferrer">tiggiekids.com</a>
        </span>
    </div>
</template>

<style scoped>
.footer-font-style {
    color:  #282828 !important;
    /* font-family: PP Pangram Sans; */
    font-size: 16px !important;
    font-style: normal !important;
    font-weight: 500 !important;
    line-height: 26px !important;
    /* background-color: red; */
    /* 162.5% */
}

.footer-image
{
    /* background:lightgray -1.001px -2458.607px / 100.174% 28624.995% no-repeat; */
    width: 100% !important;
    padding-left: 10px;
    padding-right: 10px;
    /* border-radius: 20% !important; */
}

.leaptech
{
    color:  #666CFF !important;
}
</style>
