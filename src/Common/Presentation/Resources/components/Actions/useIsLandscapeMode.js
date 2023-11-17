import {onMounted} from 'vue';
let isLandscape=ref(false);
const handleOrientationChange = () => {
    if (isPortrait()) {
        isLandscape.value = false;
    } else {
        isLandscape.value = true;
    }
};

const isPortrait = () => {
    // Check whether the screen is in portrait mode
    return window.innerHeight > window.innerWidth;
};

onMounted(() => {
    // Initial check for orientation
    handleOrientationChange();

    // Add an event listener for orientation change
    window.addEventListener("resize", handleOrientationChange);
});
export {isLandscape};