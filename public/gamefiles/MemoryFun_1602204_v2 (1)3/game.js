/*-- Document Ready Starts --*/
$(document).ready(function () {
  // Declear local variable
  var myVolume = 1;
  var myClickVolume = 0.5;
  var myInsVolume = 1;
  var obj1, obj2, questionSet;
  var cardCtr = 0;
  var questionCtr = 0;
  var liveHelp = true;
  var whEvent;
  var hoverTime = 1800;
  var evType = 1;
  var totalTimeSpendS = 0;
  var spendtimerobj;
  var totalAttempts = -1;
  var accuracyRes;
  var settingClick = true;
  var tryagainctr = 0;
  var correctctr = 0;
  var intval;
  resizeHandler();


  $("#setting_button").bind("click", showsetting2);
  $("#close_setting_btn").bind("click", closesetting2);
  $("#save_changes_btn").bind("click", closesetting2);
  $("#close_setting").bind("click", exitgame);
  $("#exit_game_btn").bind("click", exitgame);
  $("#start_activity").bind("click", nextscreen);
  $("#tiggie").bind("click", playins);
  totalTimeSpend();
  update_ui_Settings();

  
  function nextscreen() {
    $("#settingpage").hide();
    $("#stopclick").show();
    playsintrovo();
    setTimeout(function(){
    helpLive("scene0");
    }, 6000)
    startgame();
  }

  function startgame() {
    addCards();
    if (localStorage.getItem('musicon') == "OFF") {
      $("#bgm_music").removeClass("musicon").html("OFF");
      objPlayPauseMusic.pause();
    } else {
      playbgm();
    }
  }

  function addCards() {
    $("#startgame").show();
    $("#gameCont").hide().remove();
    $("<div/>", {
      id: "gameCont",
      class: "equalHMVWrap eqWrap",
    }).appendTo("#startgame");
    questionSet = gamedata["numbers"][questionCtr]["optionSet"];
    shuffleArray(questionSet);

    for (var i = 0; i < questionSet.length; i++) {
      let evenWidth = questionSet.length;

      $("<div/>", {
        id: "scene" + i,
        class: "scene equalHMV eq",
        // tabindex:i
      }).appendTo("#gameCont");
      $("#scene" + i).addClass("scenecard" + i);

      $("#scene" + i).removeClass("animated zoomIn");
      $("#scene" + i).addClass("animated zoomIn");

      if (evenWidth != 2) {
        $("#gameCont").css(
          "width",
          $(".scene").width() * (evenWidth / 2) + 100
        );
      }


      $("<div/>", {
        id: "card" + i,
        class: "card",
        tabindex: i + 100,
      }).appendTo("#scene" + i);

      $("<div/>", {
        id: "cardface_f" + i,
        class: "cardface",
      }).appendTo("#card" + i);
      $("#cardface_f" + i).addClass("cardfacefront");

      $("<div/>", {
        id: questionSet[i] + i,
        class: "cardface",
      }).appendTo("#card" + i);
      $("#" + questionSet[i] + i).addClass("cardfaceback");

      $("#" + questionSet[i] + i).css(
        "background-image",
        "url(Assets/Data/images/game/" + questionSet[i] + ".png)"
      );
      $("#" + questionSet[i] + i).css({
        "background-size": "contain",
        "background-repeat": "no-repeat",
      });
    }

    addEventOnCard();

  }


  // 1st time work properlly not again need to fix
  function addEventOnCard() {
    // alert("--"+evType)
    var card = document.querySelector(".card");
    if (evType == 1) {
      // $($("#gameCont").find(".scene").find(`[tabindex]`)).removeAttr(
      //   "tabindex"
      // );
      whEvent = "click";
    }
    var timer;
    if (evType == 4) {
      var that = $(".card");
      // $($("#gameCont").find(".scene").find(`[tabindex]`)).removeAttr(
      //   "tabindex"
      // );
      $(that)
        .mouseenter(function (e) {
          timer = setTimeout(function () {
            $(e.currentTarget).toggleClass("is_flipped");
            checkMatchCards(e.currentTarget);
          }, hoverTime);
        })
        .mouseleave(function () {
          clearTimeout(timer);
        });
    }

    //console.log($(".card")+"--1111--"+evType, whEvent)
    $(".card").off(whEvent).on(whEvent, function (e) {
      //console.log("--222--"+evType, whEvent)
      if((evType == 1 || evType == 4) && e.handleObj.origType == 'keypress'){
        return;
      }
      switch (evType) {
        case 1:
          //console.log("-------11")
          $(this).toggleClass("is_flipped");
          checkMatchCards(this);
          break;
        case 2:
          //console.log("-------32+++"+e.which)
          if (e.which == 32) {
            clearTimeout(intval);
          } else {
            //console.log("-------22")
            if(e.handleObj.origType == 'keypress'){
              $(this).toggleClass("is_flipped");
              checkMatchCards(this);
            }
          }
          break;
        case 3:
          //console.log("-------33+++"+e.which)
          if (e.which == 32) {
            // return
          }
          if (whEvent == "keypress click") {
            //console.log("-------33")
            $(this).toggleClass("is_flipped");
            checkMatchCards(this);
          }
          break;
        case 4:
          //console.log("-------44")
          $(this).toggleClass("is_flipped");
          checkMatchCards(this);
          whEvent = "hover"
          break;
      }
    });
    if (evType == 2) {
      // $('#card0').addClass('highlight').focus();
    }
  }
  function cycle(selector, cssClass, interval) {
    var elems = document.querySelectorAll(selector),
      last = elems[0],
      index = 0,
      cssClassRe = new RegExp("\\s*\\b" + cssClass + "\\b");

    if (elems.length === 0) return;

    return setInterval(function () {
      if (last) last.className = last.className.replace(cssClassRe, "");
      index %= elems.length;
      elems[index].className += " " + cssClass;
      $(elems[index]).focus();
      last = elems[index++];
    }, interval);
  }
  function cycleBySpace(selector, cssClass) {
    var elems = document.querySelectorAll(selector),
      index = 0;
  
    if (elems.length === 0) return;
  
    // Define the event handler function
    function handleKeyDown(event) {
      //console.log("keydown--" + event);
      if (elems.length === 0) return;
  
      // Check if the pressed key is the spacebar
      if (event.keyCode === 32 || event.key === ' ') {
        // Remove the specified CSS class from all elements
        elems.forEach(function (elem) {
          elem.classList.remove(cssClass);
        });
  
        // Calculate the index for the next element and ensure it stays within bounds
        if (elems.length === index) {
          index = 0;
        }
        index = (index + 1) % elems.length;
  
        // Add the specified CSS class to the next element
        elems[index].classList.add(cssClass);
  
        // Set focus on the next element
        elems[index].focus();
      }
    }
  
    // Add event listener for the 'keydown' event
    document.removeEventListener('keydown', handleKeyDown);
    document.addEventListener('keydown', handleKeyDown);
  
    // Return a function (closure) that can be used to manually cycle through elements
    return function () {
      // Remove the specified CSS class from all elements
      elems.forEach(function (elem) {
        elem.classList.remove(cssClass);
      });
  
      // Calculate the index for the next element and ensure it stays within bounds
      index = (index + 1) % elems.length;
  
      // Add the specified CSS class to the next element
      elems[index].classList.add(cssClass);
  
      // Set focus on the next element
      elems[index].focus();
    };
  
    // If you want to remove the event listener externally, you can use:
    // document.removeEventListener('keydown', handleKeyDown);
  }
  function attachEvent() {
    clearTimeout(intval);
    setTimeout(function () {
      if (evType == 3) {
        $('.card').removeClass('highlight')
        intval = cycle(".card", "highlight", 2000);
      }
      if (evType == 2) {
        var cycle1 = cycleBySpace(".card", "highlight");

        // Call cycle() to cycle through elements
        cycle1();
      }
    }, 1300);
  }
  // End 1st time work properlly not again need to fix
  

  function helpLive(id) {
    if (liveHelp) {
      $("#handindicator").hide().remove();
      $("<div/>", {
        id: "handindicator",
      }).appendTo("#" + id);


      $("#scene0,#scene1").addClass("pointer_none");
      setTimeout(function () {
        $("#card0").click();
        $("#handindicator").hide().remove();
        $("<div/>", {
          id: "handindicator",
        }).appendTo("#scene1");
      }, 1500)

      setTimeout(function () {
        $("#card1").click();
        // $("#card1").focus();    
      }, 2000);
    }
  }

  function checkMatchCards(evt) {
    playsfxselect();
    $("#gameCont")
      .find(".is_flipped")
      .each(function (index) {
        if (index == 0) {
          obj1 = this;
          if (liveHelp) {
            $("#scene0").addClass("pointer_none");
          }
          // $(this).addClass('is_flipped');
        }

        if (index == 1) {
          obj2 = this;
          // $('.card').removeClass('is_flipped')
          var str1 = $($(obj1).children()[1]).attr("id");
          var str2 = $($(obj2).children()[1]).attr("id");

          str1 = str1.split("_")[0].replace(/[0-9]/g, "");
          str2 = str2.split("_")[0].replace(/[0-9]/g, "");

          if (str1 == str2) {
            liveHelp = false;
            // $("#scene1,#scene0").removeClass("pointer_none");
            $("#handindicator").hide().remove();
            $("#stopclick").show();
            var setTimerObj1 = setTimeout(function () {
              $("#stopclick").hide();
              $(obj1).removeClass("is_flipped");
              $(obj2).removeClass("is_flipped");
              $(obj1).hide().remove();
              $(obj2).hide().remove();
              if (evType == 2) {
                if ($('#card0').length > 0) {
                  $('#card0').addClass('highlight').focus();
                } else if ($('#card1').length > 0) {
                  $('#card0').addClass('highlight').focus();
                }
                else if ($('#card2').length > 0) {
                  $('#card2').addClass('highlight').focus();
                }
                else if ($('#card3').length > 0) {
                  $('#card3').addClass('highlight').focus();
                }
              }

              attachEvent()

              clearTimeout(setTimerObj1);
              cardCtr++;

              if (cardCtr == questionSet.length / 2) {
                breakEggs(questionCtr);
                if (questionCtr == 3) {
                  clearInterval(spendtimerobj);
                  accuracyRes = (7 / totalAttempts) * 100;
                  accuracyRes = accuracyRes.toFixed(2);
                  localStorage.setItem('Percentage_correct', accuracyRes);
                  document.cookie = 'Percentage_correct=' + accuracyRes;

                } else {
                  setTimeout(function () {
                    questionCtr++;
                    correctctr = 0;
                    tryagainctr = 0;
                    cardCtr = 0;
                    addCards();
                  }, 1000);
                }
              }
            }, 800);

            playsfxcorrect();
            correctctr++;
            totalAttempts++;
            localStorage.setItem('TotalSelection', totalAttempts);
            document.cookie = 'TotalSelection=' + totalAttempts;


          } else {
            playsfxwrong();
            tryagainctr++;
            totalAttempts++;
            localStorage.setItem('TotalSelection', totalAttempts);
            document.cookie = 'TotalSelection=' + totalAttempts;

            $("#stopclick").show();
            var setTimerObj2 = setTimeout(function () {
              $(obj1).removeClass("is_flipped");
              $(obj2).removeClass("is_flipped");
              $("#stopclick").hide();
              clearTimeout(setTimerObj2);
            }, 800);
          }
        }
      });
  }

  function breakEggs(cor) {
    let j = 0;
    switch (cor) {
      case 0:
        return;
        break;
      case 1:
        break;
      case 2:
        cor = 3;
        break;
      case 3:
        cor = 5;
        break;
      default:
    }
    for (let i = 0; i <= cor; i++) {
      setTimeout(function () {
        $("#lives" + i).addClass("breakEgg");
      }, 250);
    }
  }

  function shuffleArray(array) {
    for (var i = array.length - 1; i > 0; i--) {
      var j = Math.floor(Math.random() * (i + 1));
      var temp = array[i];
      array[i] = array[j];
      array[j] = temp;
    }
  }

  // update UI as per settins js parameters function
  function update_ui_Settings() {
    //  update UI for instruction backgrounds like backgroundImage or backgroundColor
    const instructiongameElm = document.getElementById("settingpage");
    if (game_ui["instruction_screen"].backgroundImage == "none") {
      instructiongameElm.style.backgroundColor =
        game_ui["instruction_screen"].backgroundColor;
    } else {
      instructiongameElm.style.backgroundImage =
        "url(" + game_ui["instruction_screen"].backgroundImage + ")";
    }

    //  update UI for instruction title text
    const instructionTextElm = document.getElementById("instruction_title");
    instructionTextElm.textContent =
      game_ui["instruction_screen"]["titleUI"].titleText;

    //  update UI for main game backgrounds like backgroundImage or backgroundColor
    const maingameElm = document.getElementById("game_container");
    if (game_ui["game_screen"].backgroundImage == "none") {
      maingameElm.style.backgroundColor =
        game_ui["game_screen"].backgroundColor;
    } else {
      maingameElm.style.backgroundImage =
        "url(" + game_ui["game_screen"].backgroundImage + ")";
    }

    //  update liives as per settings
    if (
      game_ui["game_screen"]["lives"].number >= 1 &&
      game_ui["game_screen"]["lives"].enable == true
    ) {
      for (var i = 0; i < game_ui["game_screen"]["lives"].number; i++) {
        $("<div/>", {
          id: "lives" + i,
          class: "lives",
        }).appendTo("#livesbox");
      }
    }

    // Review link
    $("#reviewbtn").bind("click", function () {
      var url = game_ui["game_screen"]["reviewlink"].link; // Specify the URL of the link to be opened
      window.open(url, "_blank");
    });
  }

  function totalTimeSpend() {
    spendtimerobj = setInterval(function () {
      totalTimeSpendS++;
      localStorage.setItem('Totaltime', totalTimeSpendS);
      document.cookie = 'Totaltime=' + totalTimeSpendS;
    }, 1000);

  }

  function exitgame() {
    var url = "https://extrainfotech.com/";
    window.location.replace(url);
  }


  // Start Setting events

  function showsetting2() {
    playclick();
    LoadCaptchaScreen();
  }

  // on game setting change
  function closesetting2() {
    playclick();
    $("#settingpage2").hide();
    clearTimeout(intval);
    addEventOnCard();
    attachEvent();

  }

  $(".settingbtns").click(function () {
    playclick();
    removeclass();
    if ($(this).attr("num") == "1") {
      $("#tap_mouse_1").addClass("activebtn");
      $("#tap_mouse_2").addClass("activebtn");
      evType = 1;
      whEvent = "click";
    }
    if ($(this).attr("num") == "2") {
      $("#dual_switch_1").addClass("activebtn");
      $("#dual_switch_2").addClass("activebtn");
      evType = 2;
      whEvent = "keypress click";
    }
    if ($(this).attr("num") == "3") {
      $("#single_switch_1").addClass("activebtn");
      $("#single_switch_2").addClass("activebtn");
      evType = 3;
      whEvent = "keypress click";
    }
    if ($(this).attr("num") == "4") {
      $("#eye_tracker_1").addClass("activebtn");
      $("#eye_tracker_2").addClass("activebtn");
      evType = 4;
      whEvent = "keypress click";
    }
  });

  function removeclass() {
    $(".settingbtns").each(function () {
      $(this).removeClass("activebtn");
    });
  }
  // End Setting events



  /*-- Captcha Screen : Starts --*/
  var CaptchaObj = { Q: "", A: 0 };
  function RegisterCaptchaEvents() {
    
    $("#closeCaptcha").click(function () {
      $("#captchaScreen").addClass("ClsHide");
    });

    $(".clsNumBtn").click(function (e) {
      playclick();
      ValidateCaptcha(e);
    });
   
  }
  function LoadCaptchaScreen() {
    $("#captchaScreen").removeClass("ClsHide").addClass("slide-right");
    GenerateCaptchaQues();
  }

  function HideCaptchaScreen() {
    playclick();
    $("#captchaScreen").removeClass("slide-right").addClass("ClsHide");
    $("#settingpage2").show();
  }

  function ValidateCaptcha(e) {
    var CaptchaAns = Number($("#" + e.target.id).attr("data-value"));
    if (CaptchaAns == CaptchaObj.A) {
      HideCaptchaScreen();
    }
  }

  function GenerateCaptchaQues() {
    CaptchaObj = { Q: "", A: 0 };
    var Num1 = Math.floor(Math.random() * 9);
    var SecondNumLimit = 8 - Num1;
    var Num2 = Math.floor(Math.random() * SecondNumLimit);
    var QStr = "What is " + Num1 + " + " + Num2 + " ?";
    CaptchaObj.Q = QStr;
    CaptchaObj.A = Num1 + Num2;
    $("#CaptchaQ").html(CaptchaObj.Q);
  }

  RegisterCaptchaEvents();

  /*-- Captcha Screen : Ends --*/


  //  start game sfx and vo 

  // create and add bgm audio
  var bgmsrc = game_ui["game_screen"].backgroundMusic;
  var objPlayPauseMusic = document.createElement("audio");
  objPlayPauseMusic.src = bgmsrc;
  objPlayPauseMusic.addEventListener("ended", playbgm);
  $("#bgm_music").bind("click", playbgm);

  var bgmUIValue;
  if (localStorage.getItem('myVolume')) {
    myVolume = localStorage.getItem('myVolume');
    bgmUIValue = localStorage.getItem('bgmUIValue');
  } else {
    myVolume = 1;
    bgmUIValue = 94.5;
  }

  $("#volume1").slider({
    min: 0,
    max: 100,
    value: bgmUIValue,
    range: "min",
    slide: function (event, ui) {
      setVolume(ui.value / 100);
      localStorage.setItem('myVolume', ui.value / 100);
      localStorage.setItem('bgmUIValue', ui.value);
      playsfxmovevolume();
    },
    stop: function (event, ui) {
      if ($(this).slider('value') > 94.5) {
        $(this).slider('value', 94.5);
        localStorage.setItem('myVolume', 1);
        localStorage.setItem('bgmUIValue', 94.5);
      }
    },
  });

  var clickUIValue;
  if (localStorage.getItem('myClickVolume')) {
    myClickVolume = localStorage.getItem('myClickVolume');
    clickUIValue = localStorage.getItem('clickUIValue');
  } else {
    myClickVolume = 0.5;
    clickUIValue = 59;
  }

  $("#volume2").slider({
    min: 0,
    max: 100,
    value: clickUIValue,
    range: "min",
    slide: function (event, ui) {
      setVolumeClick(ui.value / 100);
      localStorage.setItem('myClickVolume', ui.value / 100);
      localStorage.setItem('clickUIValue', ui.value);
      playsfxmovevolume();
    },
    stop: function (event, ui) {
      if ($(this).slider('value') > 94.5) {
        $(this).slider('value', 94.5);
        localStorage.setItem('myClickVolume', 1);
        localStorage.setItem('clickUIValue', 94.5);
      }
    },
  });

  var insUIValue;
  if (localStorage.getItem('myInsVolume')) {
    myInsVolume = localStorage.getItem('myInsVolume');
    insUIValue = localStorage.getItem('insUIValue');
  } else {
    myInsVolume = 1;
    insUIValue = 94.5;
  }

  $("#volume3").slider({
    min: 0,
    max: 100,
    value: insUIValue,
    range: "min",
    slide: function (event, ui) {
      setVolumeIns(ui.value / 100);
      localStorage.setItem('myInsVolume', ui.value / 100);
      localStorage.setItem('insUIValue', ui.value);
      playsfxmovevolume();
    },
    stop: function (event, ui) {
      if ($(this).slider('value') > 94.5) {
        $(this).slider('value', 94.5);
        localStorage.setItem('myInsVolume', 1);
        localStorage.setItem('insUIValue', 94.5);
      }
    },
  });

  var myMedia = document.createElement("audio");
  $("#player1").append(myMedia);
  $("#player2").append(myMedia);
  $("#player3").append(myMedia);
  myMedia.id = "myMedia";

  function setVolume(val) {
    if (val >= 1) {
      val = 1;
    }
    objPlayPauseMusic.volume = val;
    myVolume = val;
  }

  // play bgm audio function
  function playbgm() {

    objPlayPauseMusic.setAttribute("loop", "loop");
    setVolume(myVolume);
    if (objPlayPauseMusic.paused) {
      $("#bgm_music").removeClass("musicon");
      $("#bgm_music").addClass("musicon").html("ON");
      objPlayPauseMusic.play();
      localStorage.setItem('musicon', "ON");
    } else {
      $("#bgm_music").removeClass("musicon").html("OFF");
      objPlayPauseMusic.pause();
      localStorage.setItem('musicon', "OFF");
    }
  }

  // create and add click audio
  var objPlayClickMusic = document.createElement("audio");
  objPlayClickMusic.src = "Assets/Data/audio/sfx_selecting_card.mp3";

  $("#sound_effect").bind("click", playclickbtns);

  var clicktbtn;

  if (localStorage.getItem('clicktbtn') == "false") {
    clicktbtn = false;
    $("#sound_effect").removeClass("musicon").html("OFF");
  } else {

    clicktbtn = true;
    $("#sound_effect").removeClass("musicon");
    $("#sound_effect").addClass("musicon").html("ON");
  }

  function playclickbtns() {
    if (clicktbtn == true) {
      clicktbtn = false;
      $("#sound_effect").removeClass("musicon").html("OFF");
      localStorage.setItem('clicktbtn', false);
    } else {
      $("#sound_effect").removeClass("musicon");
      $("#sound_effect").addClass("musicon").html("ON");
      localStorage.setItem('clicktbtn', true);
      clicktbtn = true;
    }
  }

  function setVolumeClick(val) {
    if (val >= 1) {
      val = 1;
    }
    objPlayClickMusic.volume = val;
    myClickVolume = val;
  }

  // play click audio function
  function playclick() {
    setVolumeClick(myClickVolume);
    if (clicktbtn == true) {
      objPlayClickMusic.play();
    } else {
      objPlayClickMusic.pause();
    }
  }

  // create and add ins audio
  var objPlayInsMusic = document.createElement("audio");
  objPlayInsMusic.src = "Assets/Data/audio/instruction_vo.mp3";
  $("#game_voiceover").bind("click", playinsbtns);

  var instbtn;
  if (localStorage.getItem('instbtn') == "false") {
    instbtn = false;
    $("#game_voiceover").removeClass("musicon").html("OFF");
  } else {
    instbtn = true;
    $("#game_voiceover").removeClass("musicon");
    $("#game_voiceover").addClass("musicon").html("ON");

  }

  function playinsbtns() {
    if (instbtn == true) {
      instbtn = false;
      $("#game_voiceover").removeClass("musicon").html("OFF");
      localStorage.setItem('instbtn', false);
    } else {
      $("#game_voiceover").removeClass("musicon");
      $("#game_voiceover").addClass("musicon").html("ON");
      localStorage.setItem('instbtn', true);
      instbtn = true;
    }
  }

  function setVolumeIns(val) {
    if (val >= 1) {
      val = 1;
    }
    objPlayInsMusic.volume = val;
    myInsVolume = val;
  }

  function playins() {
    setVolumeIns(myInsVolume);
    if (instbtn == true) {
      objPlayInsMusic.play();
      $("#tiggie").addClass("tiggieanim");
    } else {
      objPlayInsMusic.pause();
      $("#tiggie").removeClass("tiggieanim");
    }
    objPlayInsMusic.addEventListener("ended", endInsMusic);
  }

  function endInsMusic() {
    $("#tiggie").removeClass("tiggieanim");
  }

  function playsfxmovevolume() {
    var objsfxmovevolume = document.createElement("audio");
    objsfxmovevolume.src = "Assets/Data/audio/setting_sfx_move_volume.mp3";
    objsfxmovevolume.play();
  }

  function playsintrovo() {
    var objsintrovo = document.createElement("audio");
    objsintrovo.src = "Assets/Data/audio/intro_vo.mp3";
    objsintrovo.play();
    objsintrovo.addEventListener("ended", displaysettingbtn);


  }

  function displaysettingbtn() {
    $("#setting_button").show();
    $("#stopclick").hide();

  }

  function playsfxselect() {
    var objsfxselect = document.createElement("audio");
    objsfxselect.src = "Assets/Data/audio/sfx_selecting_card.mp3";
    if (myClickVolume >= 1) {
      myClickVolume = 1;
    }
    objsfxselect.volume = myClickVolume;
    myClickVolume = myClickVolume;
    if (clicktbtn == true) {
      objsfxselect.play();
    } else {
      objsfxselect.pause();
    }
  }

  function playsfxwrong() {
    var objsfxwrong = document.createElement("audio");
    objsfxwrong.src = "Assets/Data/audio/sfx_wrong_match.mp3";
    
    if (myClickVolume >= 1) {
      myClickVolume = 1;
    }
    objsfxwrong.volume = myClickVolume;
    myClickVolume = myClickVolume;
    if (clicktbtn == true) {
      objsfxwrong.play();
      objsfxwrong.addEventListener("ended", playwrongvo);
    } else {
      objsfxwrong.pause();
    }

  }

  function playwrongvo() {

    if (myInsVolume >= 1) {
      myInsVolume = 1;
    }
    myInsVolume = myInsVolume;
    if (instbtn == true) {
      if (tryagainctr == 1) {
        var objwrongvo1 = document.createElement("audio");
        objwrongvo1.src = "Assets/Data/audio/oops_vo.mp3";
        objwrongvo1.volume = myInsVolume;
        objwrongvo1.play();
      } else {
        var objwrongvo2 = document.createElement("audio");
        objwrongvo2.src = "Assets/Data/audio/try_again_vo.mp3";
        objwrongvo2.volume = myInsVolume;
        objwrongvo2.play();
      }
    } else {
      if (tryagainctr == 1) {
        var objwrongvo1 = document.createElement("audio");
        objwrongvo1.src = "Assets/Data/audio/oops_vo.mp3";
        objwrongvo1.volume = myInsVolume;
        objwrongvo1.pause();
      } else {
        var objwrongvo2 = document.createElement("audio");
        objwrongvo2.src = "Assets/Data/audio/try_again_vo.mp3";
        objwrongvo2.volume = myInsVolume;
        objwrongvo2.pause();
      }
      
    }
  }

  function playsfxcorrect() {

    var objsfxcorrect = document.createElement("audio");
    objsfxcorrect.src = "Assets/Data/audio/sfx_correct_match.mp3";
    
    if (myClickVolume >= 1) {
      myClickVolume = 1;
    }
    objsfxcorrect.volume = myClickVolume;
    myClickVolume = myClickVolume;
    if (clicktbtn == true) {
      objsfxcorrect.play();
      objsfxcorrect.addEventListener("ended", playcorrectvo);
    } else {
      objsfxcorrect.pause();
    }

  }

  function playcorrectvo() {

    if (myInsVolume >= 1) {
      myInsVolume = 1;
    }
    myInsVolume = myInsVolume;
    if (instbtn == true) {
      if (questionCtr == 3) {
        var objPlayEndMusic = document.createElement("audio");
        objPlayEndMusic.src = "Assets/Data/audio/well_done_all_match_vo.mp3";
        objPlayEndMusic.volume = myInsVolume;
        objPlayEndMusic.play();
      } else {
        if (correctctr == 1) {
          var objcorrectvo1 = document.createElement("audio");
          objcorrectvo1.src = "Assets/Data/audio/thats_right_vo.mp3";
          objcorrectvo1.volume = myInsVolume;
          objcorrectvo1.play();
        } else {
          var objcorrectvo2 = document.createElement("audio");
          objcorrectvo2.src = "Assets/Data/audio/well_done_vo.mp3";
          objcorrectvo2.volume = myInsVolume;
          objcorrectvo2.play();
        }
      }

    } 

  }

  // end game sfx and vo

});
