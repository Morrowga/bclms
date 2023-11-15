<script setup>
import { ref, watch } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { SuccessDialog } from "@actions/useSuccess";
import axios from "axios";
import MultiSelectBox from "@mainRoot/components/MultiSelectBox/MultiSelectBox.vue";
let props = defineProps([
    "organisations",
    "announcement",
    "b2cUsers",
    "teachers",
    "bcStaff",
]);

let groupSelectBox = ["Super Admin", "BC Staff", "Organisation Admin"];
const tos = ref([
    "BC Staff",
    "Organisation Admin",
    "Organisation Teacher",
    "B2C Users",
]);

// const visibleToSelectBox = ref(true);
// const visibleToOriginizationList = ref(true);
// const visibleToOrganisationSelectBox = ref(true);
// const visibleToB2CUserSelectBox = ref(true);
// const visibleToTeacherSelectBox = ref(true);
// const visibleToBcStaffSelectBox = ref(true);
// const visibleToB2bTeacherList = ref(true);

// let organisation_user_ids = ref([]);
// let b2c_user_ids = ref([]);
// let b2b_teacher_ids = ref([]);
// let bc_staff_ids = ref([]);
// let b2bteacherbyorg_ids = ref([]);
// let orglist = ref([]);
// console.log(props.announcement.data.icon);
const form = useForm({
    title: props.announcement.data.title,
    icon: props.announcement.data.icon,
    message: props.announcement.data.message,
    to: props.announcement.data.to,
    by: props.announcement.data.by,
    //   org: [],
    //   users: []
});

// if(props.announcement.data.by === 'Organisation Admin'){
//     visibleToOriginizationList.value = false
//     visibleToB2bTeacherList.value = false
// } else {
//     visibleToSelectBox.value = false
// }

// watch(() => form.by, (newValue, oldValue) => {
//     if(newValue != 'Select Group'){
//         if(newValue == 'Organisation Admin'){
//             visibleToOriginizationList.value = false
//             visibleToB2bTeacherList.value = false
//             visibleToSelectBox.value = true
//             visibleToOrganisationSelectBox.value = true
//             visibleToB2CUserSelectBox.value = true
//             visibleToTeacherSelectBox.value = true
//             visibleToBcStaffSelectBox.value = true
//         } else {
//             visibleToSelectBox.value = false;
//             visibleToOriginizationList.value = true
//             visibleToB2bTeacherList.value = true
//             visibleToOrganisationSelectBox.value = true
//             visibleToB2CUserSelectBox.value = true
//             visibleToTeacherSelectBox.value = true
//             visibleToBcStaffSelectBox.value = true
//         }
//     }
// });

// watch(orglist, (newValue, oldValue) => {
//     console.log(newValue);
//     getTeacherByOrganisation(newValue);
// })

// watch(() => form.to, (newValue, oldValue) => {
//        if(newValue == 'All'){
//             visibleToOrganisationSelectBox.value = false
//             visibleToB2CUserSelectBox.value = false
//             visibleToTeacherSelectBox.value = false
//             visibleToBcStaffSelectBox.value = false
//         } else if(newValue == 'Organisation Admin'){
//             visibleToOrganisationSelectBox.value = false
//             visibleToB2CUserSelectBox.value = true
//             visibleToTeacherSelectBox.value = true
//             visibleToBcStaffSelectBox.value = true
//         } else if(newValue == 'Organisation Teacher'){
//             visibleToOrganisationSelectBox.value = true
//             visibleToB2CUserSelectBox.value = true
//             visibleToTeacherSelectBox.value = false
//             visibleToBcStaffSelectBox.value = true
//         } else if(newValue == 'B2C Users'){
//             visibleToOrganisationSelectBox.value = true
//             visibleToB2CUserSelectBox.value = false
//             visibleToTeacherSelectBox.value = true
//             visibleToBcStaffSelectBox.value = true
//         } else if(newValue == 'BC Staff') {
//             visibleToOrganisationSelectBox.value = true
//             visibleToB2CUserSelectBox.value = true
//             visibleToTeacherSelectBox.value = true
//             visibleToBcStaffSelectBox.value = false
//         }
// });

// const org_array = ref([])
// for (let i = 0; i < props.organisations.length; i++) {
//     org_array.value.push({
//         'id': props.organisations[i].id,
//         'name': props.organisations[i].name
//     })
// }
// const org_teacher_array = ref([])
// for (let i = 0; i < props.teachers.data.length; i++) {
//     org_teacher_array.value.push({
//         'id': props.teachers.data[i].id,
//         'name': props.teachers.data[i].first_name + ' ' + props.teachers.data[i].last_name
//     })
// }

// const b2c_users_array = ref([])
// for (let i = 0; i < props.b2cUsers.data.length; i++) {
//     b2c_users_array.value.push({
//         'id': props.b2cUsers.data[i].id,
//         'name': props.b2cUsers.data[i].first_name + ' ' + props.b2cUsers.data[i].last_name
//     })
// }

// const bc_staff_array = ref([])
// for (let i = 0; i < props.bcStaff.data.length; i++) {
//     bc_staff_array.value.push({
//         'id': props.bcStaff.data[i].id,
//         'name': props.bcStaff.data[i].first_name + ' ' + props.bcStaff.data[i].last_name
//     })
// }

// const b2bteacherbyorg = ref([]);

const toSelect = ref(null);

// let author_id = computed(() => usePage().props.auth.data.roles.name);
const showDialog = ref(false);
const icon = ref("");
const searchIcon = ref("");
const chosenIcon = ref(props.announcement.data.icon);

const isAllSelected = computed(() => form.to.length === tos.value.length);

// function toggleSelectAll() {
//   if (!isAllSelected.value) {
//     // If "Select All" is checked, select all options including "All"
//     form.to = 'All';
//   } else {
//     // If "Select All" is unchecked, clear the selection
//     form.to = '';
//   }
//   if (toSelect.value) {
//     toSelect.value.isActive = false;
//   }
// }

const allIcons = ref([
    "account",
    "account-alert",
    "account-box",
    "account-box-outline",
    "account-check",
    "account-circle",
    "account-key",
    "tooltip-account",
    "account-minus",
    "account-multiple",
    "account-multiple-outline",
    "account-multiple-plus",
    "account-network",
    "account-outline",
    "account-plus",
    "account-remove",
    "account-search",
    "account-star",
    "account-switch",
    "airballoon",
    "airplane",
    "airplane-off",
    "alarm",
    "alarm-check",
    "alarm-multiple",
    "alarm-off",
    "alarm-plus",
    "album",
    "alert",
    "alert-box",
    "alert-circle",
    "alert-octagon",
    "alpha",
    "alphabetical",
    "amazon",
    "google-cloud",
    "ambulance",
    "android",
    "android-debug-bridge",
    "android-studio",
    "apple",
    "apple-finder",
    "apple-ios",
    "apple-safari",
    "apps",
    "archive",
    "arrange-bring-forward",
    "arrange-bring-to-front",
    "arrange-send-backward",
    "arrange-send-to-back",
    "arrow-all",
    "arrow-bottom-left",
    "arrow-bottom-right",
    "arrow-collapse",
    "arrow-down",
    "arrow-down-bold",
    "arrow-down-bold-circle",
    "arrow-down-bold-circle-outline",
    "arrow-down-bold-hexagon-outline",
    "arrow-expand",
    "arrow-left",
    "arrow-left-bold",
    "arrow-left-bold-circle",
    "arrow-left-bold-circle-outline",
    "arrow-left-bold-hexagon-outline",
    "arrow-right",
    "arrow-right-bold",
    "arrow-right-bold-circle",
    "arrow-right-bold-circle-outline",
    "arrow-right-bold-hexagon-outline",
    "arrow-top-left",
    "arrow-top-right",
    "arrow-up",
    "arrow-up-bold",
    "arrow-up-bold-circle",
    "arrow-up-bold-circle-outline",
    "arrow-up-bold-hexagon-outline",
    "at",
    "attachment",
    "auto-fix",
    "auto-upload",
    "baby",
    "backburger",
    "backup-restore",
    "bank",
    "barcode",
    "barley",
    "barrel",
    "basket",
    "basket-fill",
    "basket-unfill",
    "battery",
    "battery-10",
    "battery-20",
    "battery-30",
    "battery-40",
    "battery-50",
    "battery-60",
    "battery-70",
    "battery-80",
    "battery-90",
    "battery-alert",
    "battery-charging-100",
    "battery-charging-20",
    "battery-charging-30",
    "battery-charging-40",
    "battery-charging-60",
    "battery-charging-80",
    "battery-charging-90",
    "battery-minus",
    "battery-negative",
    "battery-outline",
    "battery-plus",
    "battery-positive",
    "battery-unknown",
    "beach",
    "beaker",
    "beaker-outline",
    "beer",
    "bell",
    "bell-off",
    "bell-outline",
    "bell-ring",
    "bell-ring-outline",
    "bell-sleep",
    "beta",
    "bike",
    "binoculars",
    "bio",
    "biohazard",
    "bitbucket",
    "black-mesa",
    "blinds",
    "block-helper",
    "blogger",
    "bluetooth",
    "bluetooth-audio",
    "bluetooth-connect",
    "bluetooth-settings",
    "bluetooth-transfer",
    "blur",
    "blur-linear",
    "blur-off",
    "blur-radial",
    "bone",
    "book",
    "book-multiple",
    "book-open",
    "book-variant",
    "bookmark",
    "bookmark-check",
    "bookmark-music",
    "bookmark-outline",
    "bookmark-plus",
    "bookmark-remove",
    "border-all",
    "border-bottom",
    "border-color",
    "border-horizontal",
    "border-inside",
    "border-left",
    "border-none",
    "border-outside",
    "border-right",
    "border-top",
    "border-vertical",
    "bowling",
    "box",
    "briefcase",
    "briefcase-check",
    "briefcase-download",
    "briefcase-upload",
    "brightness-1",
    "brightness-2",
    "brightness-3",
    "brightness-4",
    "brightness-5",
    "brightness-6",
    "brightness-7",
    "brightness-auto",
    "broom",
    "brush",
    "bug",
    "bulletin-board",
    "bullhorn",
    "bus",
    "cake",
    "cake-variant",
    "calculator",
    "calendar",
    "calendar-blank",
    "calendar-check",
    "calendar-clock",
    "calendar-multiple",
    "calendar-multiple-check",
    "calendar-plus",
    "calendar-remove",
    "calendar-text",
    "calendar-today",
    "camcorder",
    "camcorder-off",
    "camera",
    "camera-front",
    "camera-front-variant",
    "camera-iris",
    "camera-party-mode",
    "camera-rear",
    "camera-rear-variant",
    "camera-switch",
    "camera-timer",
    "candycane",
    "car",
    "car-wash",
    "carrot",
    "cart",
    "cart-outline",
    "cash",
    "cash-100",
    "cash-multiple",
    "cash-usd",
    "cast",
    "cast-connected",
    "castle",
    "cat",
    "cellphone",
    "cellphone-android",
    "cellphone-dock",
    "cellphone-iphone",
    "cellphone-link",
    "cellphone-link-off",
    "cellphone-settings",
    "chair-school",
    "chart-arc",
    "chart-areaspline",
    "chart-bar",
    "chart-histogram",
    "chart-line",
    "chart-pie",
    "check",
    "check-all",
    "checkbox-blank",
    "checkbox-blank-circle",
    "checkbox-blank-circle-outline",
    "checkbox-blank-outline",
    "checkbox-marked",
    "checkbox-marked-circle",
    "checkbox-marked-circle-outline",
    "checkbox-marked-outline",
    "checkbox-multiple-blank",
    "checkbox-multiple-blank-outline",
    "checkbox-multiple-marked",
    "checkbox-multiple-marked-outline",
    "checkerboard",
    "chevron-double-down",
    "chevron-double-left",
    "chevron-double-right",
    "chevron-double-up",
    "chevron-down",
    "chevron-left",
    "chevron-right",
    "chevron-up",
    "church",
    "city",
    "clipboard",
    "clipboard-account",
    "clipboard-alert",
    "clipboard-arrow-down",
    "clipboard-arrow-left",
    "clipboard-check",
    "clipboard-outline",
    "clipboard-text",
    "clippy",
    "clock",
    "clock-fast",
    "close",
    "close-box",
    "close-box-outline",
    "close-circle",
    "close-circle-outline",
    "close-network",
    "closed-caption",
    "cloud",
    "apple-icloud",
    "cloud-check",
    "cloud-circle",
    "cloud-download",
    "cloud-outline",
    "cloud-off-outline",
    "cloud-upload",
    "cloud-refresh",
    "cloud-lock",
    "cloud-lock-outline",
    "cloud-question",
    "cloud-tags",
    "cloud-print",
    "cloud-print-outline",
    "cloud-search",
    "cloud-search-outline",
    "code-array",
    "code-braces",
    "code-equal",
    "code-greater-than",
    "code-less-than",
    "code-less-than-or-equal",
    "code-not-equal",
    "code-not-equal-variant",
    "code-string",
    "code-tags",
    "codepen",
    "coffee",
    "coffee-to-go",
    "color-helper",
    "comment",
    "comment-account",
    "comment-account-outline",
    "comment-alert",
    "comment-alert-outline",
    "comment-check",
    "comment-check-outline",
    "comment-multiple-outline",
    "comment-outline",
    "comment-plus-outline",
    "comment-processing",
    "comment-processing-outline",
    "comment-remove-outline",
    "comment-text",
    "comment-text-outline",
    "compare",
    "compass",
    "compass-outline",
    "console",
    "content-copy",
    "content-cut",
    "content-duplicate",
    "content-paste",
    "content-save",
    "content-save-all",
    "contrast",
    "contrast-box",
    "contrast-circle",
    "cow",
    "credit-card",
    "credit-card-multiple",
    "crop",
    "crop-free",
    "crop-landscape",
    "crop-portrait",
    "crop-square",
    "crosshairs",
    "crosshairs-gps",
    "crown",
    "cube",
    "cube-outline",
    "cube-unfolded",
    "cup",
    "cup-water",
    "currency-btc",
    "currency-eur",
    "currency-gbp",
    "currency-inr",
    "currency-rub",
    "currency-try",
    "currency-usd",
    "cursor-default",
    "cursor-default-outline",
    "cursor-move",
    "cursor-pointer",
    "database",
    "database-minus",
    "database-outline",
    "database-plus",
    "debug-step-into",
    "debug-step-out",
    "debug-step-over",
    "decimal-decrease",
    "decimal-increase",
    "delete",
    "delete-variant",
    "deskphone",
    "desktop-mac",
    "desktop-tower",
    "details",
    "deviantart",
    "diamond",
    "dice-1",
    "dice-2",
    "dice-3",
    "dice-4",
    "dice-5",
    "dice-6",
    "directions",
    "disqus",
    "division",
    "division-box",
    "dns",
    "domain",
    "dots-horizontal",
    "dots-vertical",
    "download",
    "drag",
    "drag-horizontal",
    "drag-vertical",
    "drawing",
    "drawing-box",
    "drone",
    "dropbox",
    "drupal",
    "duck",
    "dumbbell",
    "earth",
    "earth-off",
    "eject",
    "elevation-decline",
    "elevation-rise",
    "elevator",
    "email",
    "email-open",
    "email-outline",
    "emoticon",
    "emoticon-cool",
    "emoticon-devil",
    "emoticon-happy",
    "emoticon-neutral",
    "emoticon-poop",
    "emoticon-sad",
    "emoticon-tongue",
    "engine",
    "engine-outline",
    "equal",
    "equal-box",
    "eraser",
    "escalator",
    "evernote",
    "exclamation",
    "exit-to-app",
    "export",
    "eye",
    "eye-off",
    "eyedropper",
    "eyedropper-variant",
    "facebook",
    "facebook-messenger",
    "factory",
    "fan",
    "fast-forward",
    "ferry",
    "file",
    "file-cloud",
    "file-delimited",
    "file-document",
    "file-excel-box",
    "file-find",
    "file-image",
    "file-multiple",
    "file-music",
    "file-outline",
    "file-pdf",
    "file-pdf-box",
    "file-powerpoint",
    "file-powerpoint-box",
    "file-presentation-box",
    "file-video",
    "file-word",
    "file-word-box",
    "film",
    "filmstrip",
    "filmstrip-off",
    "filter",
    "filter-outline",
    "filter-remove-outline",
    "filter-variant",
    "fire",
    "firefox",
    "fish",
    "flag",
    "flag-checkered",
    "flag-outline",
    "flag-triangle",
    "flag-variant",
    "flash",
    "flash-auto",
    "flash-off",
    "flashlight",
    "flashlight-off",
    "flip-to-back",
    "flip-to-front",
    "floppy",
    "flower",
    "folder",
    "folder-account",
    "folder-download",
    "folder-google-drive",
    "folder-image",
    "folder-lock",
    "folder-lock-open",
    "folder-move",
    "folder-multiple",
    "folder-multiple-image",
    "folder-multiple-outline",
    "folder-outline",
    "folder-plus",
    "folder-remove",
    "folder-upload",
    "food",
    "food-apple",
    "food-variant",
    "football",
    "football-helmet",
    "format-align-center",
    "format-align-justify",
    "format-align-left",
    "format-align-right",
    "format-bold",
    "format-clear",
    "format-color-fill",
    "format-float-center",
    "format-float-left",
    "format-float-none",
    "format-float-right",
    "format-header-1",
    "format-header-2",
    "format-header-3",
    "format-header-4",
    "format-header-5",
    "format-header-6",
    "format-header-decrease",
    "format-header-equal",
    "format-header-increase",
    "format-header-pound",
    "format-indent-decrease",
    "format-indent-increase",
    "format-italic",
    "format-line-spacing",
    "format-list-bulleted",
    "format-paint",
    "format-paragraph",
    "format-size",
    "format-strikethrough",
    "format-subscript",
    "format-superscript",
    "format-text",
    "format-textdirection-l-to-r",
    "format-textdirection-r-to-l",
    "format-underline",
    "format-wrap-inline",
    "format-wrap-square",
    "format-wrap-tight",
    "format-wrap-top-bottom",
    "forum",
    "forward",
    "fridge",
    "fullscreen",
    "fullscreen-exit",
    "function",
    "gamepad",
    "gamepad-variant",
    "gas-station",
    "gavel",
    "gender-female",
    "gender-male",
    "gender-male-female",
    "gender-transgender",
    "gift",
    "git",
    "github",
    "glass-flute",
    "glass-mug",
    "glass-stange",
    "glass-tulip",
    "glasses",
    "gmail",
    "google",
    "google-chrome",
    "google-circles",
    "google-circles-communities",
    "google-circles-extended",
    "google-circles-group",
    "google-controller",
    "google-controller-off",
    "google-drive",
    "google-earth",
    "google-glass",
    "google-maps",
    "google-play",
    "google-plus",
    "google-hangouts",
    "grid",
    "grid-off",
    "group",
    "guitar-pick",
    "guitar-pick-outline",
    "hand-pointing-right",
    "hanger",
    "harddisk",
    "headphones",
    "headphones-box",
    "headphones-settings",
]);

const saveIcon = (selectedIcon) => {
    icon.value = "mdi-" + selectedIcon;
    // console.log(icon.value);
    chosenIcon.value = icon.value;
    form.icon = icon.value;
    showDialog.value = false;
};

watch(searchIcon, (newSearchIcon) => {
    if (newSearchIcon.length === 0) {
        // If searchIcon is empty, reset allIcons to the original array
        allIcons.value = [
            "account",
            "account-alert",
            "account-box",
            "account-box-outline",
            "account-check",
            "account-circle",
            "account-key",
            "tooltip-account",
            "account-minus",
            "account-multiple",
            "account-multiple-outline",
            "account-multiple-plus",
            "account-network",
            "account-outline",
            "account-plus",
            "account-remove",
            "account-search",
            "account-star",
            "account-switch",
            "airballoon",
            "airplane",
            "airplane-off",
            "alarm",
            "alarm-check",
            "alarm-multiple",
            "alarm-off",
            "alarm-plus",
            "album",
            "alert",
            "alert-box",
            "alert-circle",
            "alert-octagon",
            "alpha",
            "alphabetical",
            "amazon",
            "google-cloud",
            "ambulance",
            "android",
            "android-debug-bridge",
            "android-studio",
            "apple",
            "apple-finder",
            "apple-ios",
            "apple-safari",
            "apps",
            "archive",
            "arrange-bring-forward",
            "arrange-bring-to-front",
            "arrange-send-backward",
            "arrange-send-to-back",
            "arrow-all",
            "arrow-bottom-left",
            "arrow-bottom-right",
            "arrow-collapse",
            "arrow-down",
            "arrow-down-bold",
            "arrow-down-bold-circle",
            "arrow-down-bold-circle-outline",
            "arrow-down-bold-hexagon-outline",
            "arrow-expand",
            "arrow-left",
            "arrow-left-bold",
            "arrow-left-bold-circle",
            "arrow-left-bold-circle-outline",
            "arrow-left-bold-hexagon-outline",
            "arrow-right",
            "arrow-right-bold",
            "arrow-right-bold-circle",
            "arrow-right-bold-circle-outline",
            "arrow-right-bold-hexagon-outline",
            "arrow-top-left",
            "arrow-top-right",
            "arrow-up",
            "arrow-up-bold",
            "arrow-up-bold-circle",
            "arrow-up-bold-circle-outline",
            "arrow-up-bold-hexagon-outline",
            "at",
            "attachment",
            "auto-fix",
            "auto-upload",
            "baby",
            "backburger",
            "backup-restore",
            "bank",
            "barcode",
            "barley",
            "barrel",
            "basket",
            "basket-fill",
            "basket-unfill",
            "battery",
            "battery-10",
            "battery-20",
            "battery-30",
            "battery-40",
            "battery-50",
            "battery-60",
            "battery-70",
            "battery-80",
            "battery-90",
            "battery-alert",
            "battery-charging-100",
            "battery-charging-20",
            "battery-charging-30",
            "battery-charging-40",
            "battery-charging-60",
            "battery-charging-80",
            "battery-charging-90",
            "battery-minus",
            "battery-negative",
            "battery-outline",
            "battery-plus",
            "battery-positive",
            "battery-unknown",
            "beach",
            "beaker",
            "beaker-outline",
            "beer",
            "bell",
            "bell-off",
            "bell-outline",
            "bell-ring",
            "bell-ring-outline",
            "bell-sleep",
            "beta",
            "bike",
            "binoculars",
            "bio",
            "biohazard",
            "bitbucket",
            "black-mesa",
            "blinds",
            "block-helper",
            "blogger",
            "bluetooth",
            "bluetooth-audio",
            "bluetooth-connect",
            "bluetooth-settings",
            "bluetooth-transfer",
            "blur",
            "blur-linear",
            "blur-off",
            "blur-radial",
            "bone",
            "book",
            "book-multiple",
            "book-open",
            "book-variant",
            "bookmark",
            "bookmark-check",
            "bookmark-music",
            "bookmark-outline",
            "bookmark-plus",
            "bookmark-remove",
            "border-all",
            "border-bottom",
            "border-color",
            "border-horizontal",
            "border-inside",
            "border-left",
            "border-none",
            "border-outside",
            "border-right",
            "border-top",
            "border-vertical",
            "bowling",
            "box",
            "briefcase",
            "briefcase-check",
            "briefcase-download",
            "briefcase-upload",
            "brightness-1",
            "brightness-2",
            "brightness-3",
            "brightness-4",
            "brightness-5",
            "brightness-6",
            "brightness-7",
            "brightness-auto",
            "broom",
            "brush",
            "bug",
            "bulletin-board",
            "bullhorn",
            "bus",
            "cake",
            "cake-variant",
            "calculator",
            "calendar",
            "calendar-blank",
            "calendar-check",
            "calendar-clock",
            "calendar-multiple",
            "calendar-multiple-check",
            "calendar-plus",
            "calendar-remove",
            "calendar-text",
            "calendar-today",
            "camcorder",
            "camcorder-off",
            "camera",
            "camera-front",
            "camera-front-variant",
            "camera-iris",
            "camera-party-mode",
            "camera-rear",
            "camera-rear-variant",
            "camera-switch",
            "camera-timer",
            "candycane",
            "car",
            "car-wash",
            "carrot",
            "cart",
            "cart-outline",
            "cash",
            "cash-100",
            "cash-multiple",
            "cash-usd",
            "cast",
            "cast-connected",
            "castle",
            "cat",
            "cellphone",
            "cellphone-android",
            "cellphone-dock",
            "cellphone-iphone",
            "cellphone-link",
            "cellphone-link-off",
            "cellphone-settings",
            "chair-school",
            "chart-arc",
            "chart-areaspline",
            "chart-bar",
            "chart-histogram",
            "chart-line",
            "chart-pie",
            "check",
            "check-all",
            "checkbox-blank",
            "checkbox-blank-circle",
            "checkbox-blank-circle-outline",
            "checkbox-blank-outline",
            "checkbox-marked",
            "checkbox-marked-circle",
            "checkbox-marked-circle-outline",
            "checkbox-marked-outline",
            "checkbox-multiple-blank",
            "checkbox-multiple-blank-outline",
            "checkbox-multiple-marked",
            "checkbox-multiple-marked-outline",
            "checkerboard",
            "chevron-double-down",
            "chevron-double-left",
            "chevron-double-right",
            "chevron-double-up",
            "chevron-down",
            "chevron-left",
            "chevron-right",
            "chevron-up",
            "church",
            "city",
            "clipboard",
            "clipboard-account",
            "clipboard-alert",
            "clipboard-arrow-down",
            "clipboard-arrow-left",
            "clipboard-check",
            "clipboard-outline",
            "clipboard-text",
            "clippy",
            "clock",
            "clock-fast",
            "close",
            "close-box",
            "close-box-outline",
            "close-circle",
            "close-circle-outline",
            "close-network",
            "closed-caption",
            "cloud",
            "apple-icloud",
            "cloud-check",
            "cloud-circle",
            "cloud-download",
            "cloud-outline",
            "cloud-off-outline",
            "cloud-upload",
            "cloud-refresh",
            "cloud-lock",
            "cloud-lock-outline",
            "cloud-question",
            "cloud-tags",
            "cloud-print",
            "cloud-print-outline",
            "cloud-search",
            "cloud-search-outline",
            "code-array",
            "code-braces",
            "code-equal",
            "code-greater-than",
            "code-less-than",
            "code-less-than-or-equal",
            "code-not-equal",
            "code-not-equal-variant",
            "code-string",
            "code-tags",
            "codepen",
            "coffee",
            "coffee-to-go",
            "color-helper",
            "comment",
            "comment-account",
            "comment-account-outline",
            "comment-alert",
            "comment-alert-outline",
            "comment-check",
            "comment-check-outline",
            "comment-multiple-outline",
            "comment-outline",
            "comment-plus-outline",
            "comment-processing",
            "comment-processing-outline",
            "comment-remove-outline",
            "comment-text",
            "comment-text-outline",
            "compare",
            "compass",
            "compass-outline",
            "console",
            "content-copy",
            "content-cut",
            "content-duplicate",
            "content-paste",
            "content-save",
            "content-save-all",
            "contrast",
            "contrast-box",
            "contrast-circle",
            "cow",
            "credit-card",
            "credit-card-multiple",
            "crop",
            "crop-free",
            "crop-landscape",
            "crop-portrait",
            "crop-square",
            "crosshairs",
            "crosshairs-gps",
            "crown",
            "cube",
            "cube-outline",
            "cube-unfolded",
            "cup",
            "cup-water",
            "currency-btc",
            "currency-eur",
            "currency-gbp",
            "currency-inr",
            "currency-rub",
            "currency-try",
            "currency-usd",
            "cursor-default",
            "cursor-default-outline",
            "cursor-move",
            "cursor-pointer",
            "database",
            "database-minus",
            "database-outline",
            "database-plus",
            "debug-step-into",
            "debug-step-out",
            "debug-step-over",
            "decimal-decrease",
            "decimal-increase",
            "delete",
            "delete-variant",
            "deskphone",
            "desktop-mac",
            "desktop-tower",
            "details",
            "deviantart",
            "diamond",
            "dice-1",
            "dice-2",
            "dice-3",
            "dice-4",
            "dice-5",
            "dice-6",
            "directions",
            "disqus",
            "division",
            "division-box",
            "dns",
            "domain",
            "dots-horizontal",
            "dots-vertical",
            "download",
            "drag",
            "drag-horizontal",
            "drag-vertical",
            "drawing",
            "drawing-box",
            "drone",
            "dropbox",
            "drupal",
            "duck",
            "dumbbell",
            "earth",
            "earth-off",
            "eject",
            "elevation-decline",
            "elevation-rise",
            "elevator",
            "email",
            "email-open",
            "email-outline",
            "emoticon",
            "emoticon-cool",
            "emoticon-devil",
            "emoticon-happy",
            "emoticon-neutral",
            "emoticon-poop",
            "emoticon-sad",
            "emoticon-tongue",
            "engine",
            "engine-outline",
            "equal",
            "equal-box",
            "eraser",
            "escalator",
            "evernote",
            "exclamation",
            "exit-to-app",
            "export",
            "eye",
            "eye-off",
            "eyedropper",
            "eyedropper-variant",
            "facebook",
            "facebook-messenger",
            "factory",
            "fan",
            "fast-forward",
            "ferry",
            "file",
            "file-cloud",
            "file-delimited",
            "file-document",
            "file-excel-box",
            "file-find",
            "file-image",
            "file-multiple",
            "file-music",
            "file-outline",
            "file-pdf",
            "file-pdf-box",
            "file-powerpoint",
            "file-powerpoint-box",
            "file-presentation-box",
            "file-video",
            "file-word",
            "file-word-box",
            "film",
            "filmstrip",
            "filmstrip-off",
            "filter",
            "filter-outline",
            "filter-remove-outline",
            "filter-variant",
            "fire",
            "firefox",
            "fish",
            "flag",
            "flag-checkered",
            "flag-outline",
            "flag-triangle",
            "flag-variant",
            "flash",
            "flash-auto",
            "flash-off",
            "flashlight",
            "flashlight-off",
            "flip-to-back",
            "flip-to-front",
            "floppy",
            "flower",
            "folder",
            "folder-account",
            "folder-download",
            "folder-google-drive",
            "folder-image",
            "folder-lock",
            "folder-lock-open",
            "folder-move",
            "folder-multiple",
            "folder-multiple-image",
            "folder-multiple-outline",
            "folder-outline",
            "folder-plus",
            "folder-remove",
            "folder-upload",
            "food",
            "food-apple",
            "food-variant",
            "football",
            "football-helmet",
            "format-align-center",
            "format-align-justify",
            "format-align-left",
            "format-align-right",
            "format-bold",
            "format-clear",
            "format-color-fill",
            "format-float-center",
            "format-float-left",
            "format-float-none",
            "format-float-right",
            "format-header-1",
            "format-header-2",
            "format-header-3",
            "format-header-4",
            "format-header-5",
            "format-header-6",
            "format-header-decrease",
            "format-header-equal",
            "format-header-increase",
            "format-header-pound",
            "format-indent-decrease",
            "format-indent-increase",
            "format-italic",
            "format-line-spacing",
            "format-list-bulleted",
            "format-paint",
            "format-paragraph",
            "format-size",
            "format-strikethrough",
            "format-subscript",
            "format-superscript",
            "format-text",
            "format-textdirection-l-to-r",
            "format-textdirection-r-to-l",
            "format-underline",
            "format-wrap-inline",
            "format-wrap-square",
            "format-wrap-tight",
            "format-wrap-top-bottom",
            "forum",
            "forward",
            "fridge",
            "fullscreen",
            "fullscreen-exit",
            "function",
            "gamepad",
            "gamepad-variant",
            "gas-station",
            "gavel",
            "gender-female",
            "gender-male",
            "gender-male-female",
            "gender-transgender",
            "gift",
            "git",
            "github",
            "glass-flute",
            "glass-mug",
            "glass-stange",
            "glass-tulip",
            "glasses",
            "gmail",
            "google",
            "google-chrome",
            "google-circles",
            "google-circles-communities",
            "google-circles-extended",
            "google-circles-group",
            "google-controller",
            "google-controller-off",
            "google-drive",
            "google-earth",
            "google-glass",
            "google-maps",
            "google-play",
            "google-plus",
            "google-hangouts",
            "grid",
            "grid-off",
            "group",
            "guitar-pick",
            "guitar-pick-outline",
            "hand-pointing-right",
            "hanger",
            "harddisk",
            "headphones",
            "headphones-box",
            "headphones-settings",
        ];
    } else {
        // Otherwise, filter the icons based on the search
        const filteredIcons = allIcons.value.filter((i) =>
            i.includes(newSearchIcon)
        );
        allIcons.value = filteredIcons; // Replace with filtered icons
    }
});

let onFormSubmit = () => {
    // for (let i = 0; i < organisation_user_ids.value.length; i++) {
    //     form.org.push(organisation_user_ids.value[i])
    // }
    // for (let i = 0; i < b2bteacherbyorg_ids.value.length; i++) {
    //     form.users.push(b2bteacherbyorg_ids.value[i])
    // }
    // for (let i = 0; i < b2b_teacher_ids.value.length; i++) {
    //     form.users.push(b2b_teacher_ids.value[i])
    // }

    // for (let i = 0; i < bc_staff_ids.value.length; i++) {
    //     form.users.push(bc_staff_ids.value[i])
    // }
    // console.log(bc_staff_ids.value);

    //  for (let i = 0; i < b2c_user_ids.value.length; i++) {
    //     form.users.push(b2c_user_ids.value[i])
    // }

    // form.users = JSON.stringify(form.users)
    // form.org = JSON.stringify(form.org)

    // let toArray = [];
    // organisation_user_ids.value.length > 0 ? toArray.push('Organisations Admins') : '';
    // b2c_user_ids.value.length > 0 ? toArray.push('B2C Users') : '';
    // b2b_teacher_ids.value.length > 0 ? toArray.push('B2B Teachers') : '';
    // b2bteacherbyorg_ids.value.length > 0 ? toArray.push('B2B Teachers') : '';
    // bc_staff_ids.value.length > 0 ? toArray.push('BC Staff') : '';
    // form.to = toArray.join(', ')

    // console.log(form);
    // refForm.value?.resetValidation();
    form.put(route("announcements.update", props.announcement.data.id), {
        onSuccess: () => {
            form.reset();
            // form.org = [];
            // form.users = [];
            // organisation_user_ids.value = [];
            // b2c_user_ids.value = [];
            // b2b_teacher_ids.value = [];
            // bc_staff_ids.value = [];
            // b2bteacherbyorg_ids.value = [];

            // visibleToSelectBox.value = true;
            // visibleToOriginizationList.value = true;
            // visibleToOrganisationSelectBox.value = true
            // visibleToB2CUserSelectBox.value = true
            // visibleToTeacherSelectBox.value = true
            // visibleToBcStaffSelectBox.value = true
            // visibleToB2bTeacherList.value = true
            // refForm.value?.reset();
            SuccessDialog({
                title: "You've successfully updated announcement",
            });
        },
        onError: (error) => {
            //   form.setError("email", error?.email);
            //   form.setError("password", error?.password);
        },
    });
};

// let getTeacherByOrganisation = (id) => {
//     axios
//         .get(
//             route("announcements.getb2bteachersbyorg", id)
//         )
//         .then((res) => {
//             b2bteacherbyorg.value = [];
//             for (let i = 0; i < res.data.length; i++) {
//                 b2bteacherbyorg.value.push({
//                     'id': res.data[i].id,
//                     'name': res.data[i].first_name + ' ' + res.data[i].last_name
//                 })
//             }

//         });
// }
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VForm class="mt-6" @submit.prevent="onFormSubmit">
                <!-- <VRow>
                    <VCol cols="8">
                        <span class="tiggie-title margin-buttom-18"
                            >Add Announcement</span
                        >
                    </VCol>
                </VRow> -->
                <VRow justify="space-around" :gutter="10">
                    <VCol cols="8">
                        <VRow justify="start">
                            <VCol cols="12">
                                <span class="tiggie-title margin-buttom-18"
                                    >Add Announcement</span
                                >
                            </VCol>
                        </VRow>
                    </VCol>
                    <VCol cols="8">
                        <VRow justify="start">
                            <VCol cols="6">
                                <VLabel class="tiggie-label required"
                                    >Title</VLabel
                                >
                                <VTextField
                                    v-model="form.title"
                                    class="blue-outline-field"
                                    variant="plain"
                                    placeholder="Type here..."
                                    density="compact"
                                />
                            </VCol>
                            <VCol cols="2">
                                <VLabel class="tiggie-label"></VLabel>
                                <v-dialog
                                    v-model="showDialog"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    transition="scale-transition"
                                    offset-y
                                    max-width="700px"
                                    max-height="850px"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <div @click="showDialog = true">
                                            <VSelect
                                                class="center-prepend-icon"
                                                :v-model="form.icon"
                                                :prepend-inner-icon="chosenIcon"
                                                v-bind="attrs"
                                                v-on="on"
                                                color="deep-purple"
                                                readonly
                                            >
                                            </VSelect>
                                        </div>
                                    </template>
                                    <VCard class="searchcard-icon">
                                        <v-text-field
                                            v-model="searchIcon"
                                            placeholder="Search icon"
                                            prepend-inner-icon="mdi-magnify"
                                            type="text"
                                            onautocomplete="off"
                                            dense
                                        />
                                        <div class="d-flex justify-center">
                                            <VSheet
                                                id="scrolling-techniques-7"
                                                class="overflow-y-auto"
                                                max-height="600"
                                            >
                                                <VCol cols="12">
                                                    <div class="text-center">
                                                        <div
                                                            class="text-center"
                                                        >
                                                            <VBtn
                                                                v-for="(
                                                                    item, i
                                                                ) in allIcons"
                                                                :key="i"
                                                                @click="
                                                                    saveIcon(
                                                                        item
                                                                    )
                                                                "
                                                                color="white"
                                                                class="mr-2 mb-2"
                                                                fab
                                                                small
                                                                depressed
                                                            >
                                                                <v-icon
                                                                    :icon="
                                                                        'mdi-' +
                                                                        item
                                                                    "
                                                                    color="grey darken-3"
                                                                >
                                                                </v-icon>
                                                            </VBtn>
                                                        </div>
                                                    </div>
                                                </VCol>
                                            </VSheet>
                                        </div>
                                    </VCard>
                                </v-dialog>
                                <!-- <VCombobox
                                    class="blue-outline-field"
                                    variant="plain"
                                    v-model="selectedItem"
                                    :items="items"
                                    density="compact"
                                /> -->
                            </VCol>
                            <VCol cols="12">
                                <VLabel class="tiggie-label required"
                                    >Message</VLabel
                                >

                                <VTextarea
                                    class="blue-outline-field"
                                    variant="plain"
                                    placeholder="Type here ...."
                                    v-model="form.message"
                                    auto-grow
                                    rows="3"
                                />
                            </VCol>

                            <!-- <VCol cols="6">
                                <VLabel class="tiggie-label required"
                                    >Announcement By</VLabel
                                >
                                <VSelect
                                    v-model="form.by"
                                    class="blue-outline-field"
                                    variant="plain"
                                    :items="groupSelectBox"
                                    density="compact"
                                    placeholder="Select a group"
                                ></VSelect>
                                <div :hidden="visibleToOriginizationList">
                                    <VSelect
                                        class="blue-outline-field mt-3"
                                        variant="plain"
                                        v-model="orglist"
                                        :items="org_array"
                                        item-title="name"
                                        item-value="id"
                                        density="compact"
                                        placeholder="Select Organisations"
                                    >
                                        <template v-slot:prepend-item>
                                            <v-text-field
                                                v-model="search"
                                                placeholder="Search Organisations"
                                                class="select-search"
                                                type="text"
                                                prepend-inner-icon="mdi-magnify"
                                                dense
                                            />
                                        </template>
                                    </VSelect>
                                </div>
                            </VCol>

                            <VCol cols="6" :hidden="visibleToSelectBox">
                                <VLabel class="tiggie-label required"
                                    >Announcement to</VLabel
                                >
                                <VSelect
                                    :ref="toSelect"
                                    class="blue-outline-field"
                                    variant="plain"
                                    density="compact"
                                    v-model="form.to"
                                    :items="tos"
                                >
                                    <template v-slot:prepend-item>
                                        <v-list-item
                                            title="Select All"
                                            @click="toggleSelectAll"
                                        >
                                        <template v-slot:prepend>
                                            <v-checkbox-btn :input-value="isAllSelected"></v-checkbox-btn>
                                        </template>
                                        </v-list-item>
                                        <v-divider class="mt-2"></v-divider>
                                    </template>
                                </VSelect>
                            </VCol>
                            <VCol cols="6" :hidden="visibleToBcStaffSelectBox">
                            </VCol>
                            <VCol cols="6" :hidden="visibleToBcStaffSelectBox">
                                <VLabel class="tiggie-label required"
                                    >Announcement to BC Staff</VLabel
                                >
                               <MultiSelectBox :items="bc_staff_array" v-model="bc_staff_ids"/>
                            </VCol>
                            <VCol cols="6" :hidden="visibleToOrganisationSelectBox">
                            </VCol>
                            <VCol cols="6" :hidden="visibleToOrganisationSelectBox">
                                <VLabel class="tiggie-label required"
                                    >Announcement to Organisations</VLabel
                                >
                               <MultiSelectBox :items="org_array" v-model="organisation_user_ids"/>
                            </VCol>
                            <VCol cols="6" :hidden="visibleToTeacherSelectBox">
                            </VCol>
                            <VCol cols="6" :hidden="visibleToTeacherSelectBox">
                                <VLabel class="tiggie-label required"
                                    >Announcement to Organisations Teachers</VLabel
                                >
                                <MultiSelectBox :items="org_teacher_array" v-model="b2b_teacher_ids" />
                            </VCol>
                            <VCol cols="6" :hidden="visibleToB2CUserSelectBox">
                            </VCol>
                            <VCol cols="6" :hidden="visibleToB2CUserSelectBox">
                                  <VLabel class="tiggie-label required"
                                    >Announcement to B2C User[s]</VLabel
                                >
                                <MultiSelectBox :items="b2c_users_array" v-model="b2c_user_ids" />
                            </VCol>
                            <VCol cols="6" :hidden="visibleToB2bTeacherList">
                                  <VLabel class="tiggie-label required"
                                    >Announcement to B2B Teacherss</VLabel
                                >
                                <MultiSelectBox :items="b2bteacherbyorg" v-model="b2bteacherbyorg_ids"/>
                            </VCol> -->
                        </VRow>
                    </VCol>
                    <VCol
                        cols="12"
                        class="d-flex flex-wrap justify-center gap-10 mt-10"
                    >
                        <Link
                            :href="route('announcements.index')"
                            class="text-black"
                        >
                            <VBtn color="gray" height="50" class="" width="250">
                                Cancel
                            </VBtn>
                        </Link>
                        <VBtn type="submit" class="" height="50" width="250">
                            Update
                        </VBtn>
                    </VCol>
                </VRow>
            </VForm>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.blue-outline-field {
    border: 1px solid var(--Primary, #001a8f);
    border-radius: 5px;
    background: var(--White, #fff);
    padding: 8px 16px;
}
:deep(.v-field__input) {
    padding: 0 !important;
}

.select-search {
    padding: 10px !important;
}
.searchcard-icon {
    padding: 10px;
}

:deep(.v-field__input input) {
    line-height: 38px !important;
}

:deep(.v-field__prepend-inner > svg) {
    font-size: 30px !important;
}

:deep(.v-field__prepend-inner) {
    padding-left: 12px !important;
}

:deep(textarea) {
    line-height: 58px !important;
    border: 0 !important;
    background: #fff !important;
}
</style>
