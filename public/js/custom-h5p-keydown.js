console.log("Keydown loaded"); 

 //Select multi choice and handle multiple icon
 document.addEventListener('keydown', function(event) {
    var dialogWrapper = document.querySelector(".h5p-dialog-wrapper");
    if (event.code === "Space") {
      // Check the display style of the dialogWrapper
      if (dialogWrapper && (dialogWrapper.style.display === 'none')) {
        var openMultiChoice = document.querySelector('.h5p-interaction-button');
        var endScreen = document.querySelector('.h5p-interactive-video-bubble-endscreen-active');
        var endScreenButton = document.querySelector('.h5p-interactive-video-endscreen-submit-button');
        //Check if not end screen
        if (openMultiChoice && !endScreen) {
          openMultiChoice.click();
        //Remove button after clicking
        openMultiChoice.parentElement.remove();
        }
        else if (endScreen) {
            endScreenButton.click();
        }
        event.preventDefault();
        }
    }
});



//Select multi choice and handle multiple icon
document.addEventListener('keydown', function(event) {
  var dialogWrapper = document.querySelector(".h5p-dialog-wrapper");
  if (event.code === "Enter") {
  // Check the display style of the dialogWrapper
    if (dialogWrapper && (dialogWrapper.style.display === 'none')) {
      var openMultiChoice = document.querySelector('.h5p-interaction-button');
      var endScreen = document.querySelector('.h5p-interactive-video-bubble-endscreen-active');
      var endScreenButton = document.querySelector('.h5p-interactive-video-endscreen-submit-button');
      //Check if not end screen
      if (openMultiChoice && !endScreen) {
        openMultiChoice.click();
      //Remove button after clicking
      openMultiChoice.parentElement.remove();
      }
      else if (endScreen) {
          endScreenButton.click();
      }
      event.preventDefault();
      }
  }
});
