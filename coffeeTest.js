"use strict";
const startBtn = document.querySelector("#startBtn");

startBtn.addEventListener("click", () => {
  document.querySelector(".intro").style.display = "none";
  init();
});

const questions = [
  {
    id: 1,
    question: "How do you make your coffee?",
    text: "blablabla blablabla blablabla",
    type: "radio",
    answerQ: function() {
      let values = [
        {
          title: "Moka pot",
          img: "moka.png"
        },
        {
          title: "Pour over",
          img: "pour.png"
        },
        {
          title: "Refillable pods",
          img: "pod.jpg"
        },
        {
          title: "French Press",
          img: "french_press.png"
        },
        {
          title: "Espresso machine",
          img: "espresso.png"
        },
        {
          title: "Chemex",
          img: "chemex.png"
        },
        {
          title: "Coffee Maker",
          img: "maker.png"
        },
        {
          title: "Aeropress",
          img: "aero.png"
        },
        {
          title: "Percolator",
          img: "percolator.png"
        }
      ];
      let form = document.createElement("form");
      // form.setAttribute("id", "gridWith3columns");
      // form.setAttribute("class", "listenTo");
      form.className = "listenTo gridWith3columns";
      values.forEach(function(value) {
        let divWrapper = document.createElement("div");
        let label = document.createElement("label");
        let theInput = document.createElement("input");
        let theBreak = document.createElement("br");
        let divAnswer = document.querySelector("#answer");
        // divAnswer.setAttribute("class", "addGrid");
        divWrapper.setAttribute("class", "wrapper");
        // label.setAttribute("class", "labelClass");
        theInput.setAttribute("type", "radio");
        theInput.setAttribute("name", "tools");
        theInput.setAttribute("value", value.title);
        let divWrapperP = document.createElement("div");
        let nameInput = document.createElement("p");
        let img = document.createElement("img");
        nameInput.style.display = "inline";
        divWrapperP.setAttribute("class", "btnRadio");
        nameInput.innerHTML = value.title;

        img.setAttribute("class", "imgSize");
        img.setAttribute("src", "img/" + value.img);

        divWrapperP.appendChild(nameInput);
        divWrapperP.appendChild(img);
        // nameInput.appendChild(img);
        form.appendChild(divWrapper);

        label.appendChild(theInput);
        label.appendChild(divWrapperP);
        divWrapper.appendChild(label);
        divWrapper.appendChild(theBreak);
      });
      return form;
    },
    userAnswer: null
  },
  {
    id: 2,
    question: "How do you prefer your roast?",
    text: "blablabla blablabla blablabla",
    type: "radio",
    answerQ: function() {
      let values = [
        {
          title: "Light Roast",
          desc: "Light, fragrant, floral or fruity coffee notes"
        },
        {
          title: "Medium roast",
          desc: "Flavorful, traditional taste"
        },
        {
          title: "Dark roast",
          desc: "Heavy mouthfeel and strong flavor"
        },
        {
          title: "I do not know",
          desc: "We will make a choice for you based on your other preferences."
        }
      ];
      let form = document.createElement("form");

      // form.setAttribute("class", "listenTo");
      // form.setAttribute("class", "gridWith2columns");
      form.className = "listenTo gridWith2columns";
      values.forEach(function(value) {
        let divWrapper = document.createElement("div");
        let label = document.createElement("label");
        let theInput = document.createElement("input");
        let theBreak = document.createElement("br");
        let divAnswer = document.querySelector("#answer");
        // divAnswer.setAttribute("class", "addGrid");
        divWrapper.setAttribute("class", "wrapper");
        // label.setAttribute("class", "labelClass");
        theInput.setAttribute("type", "radio");
        theInput.setAttribute("name", "roast");
        theInput.setAttribute("value", value.title);
        let divWrapperP = document.createElement("div");
        let nameInput = document.createElement("p");
        let description = document.createElement("p");
        nameInput.style.display = "inline";
        divWrapperP.setAttribute("class", "btnRadio");
        nameInput.innerHTML = value.title;
        description.textContent = value.desc;

        divWrapperP.appendChild(nameInput);
        divWrapperP.appendChild(description);
        // nameInput.appendChild(img);
        form.appendChild(divWrapper);

        label.appendChild(theInput);
        label.appendChild(divWrapperP);
        divWrapper.appendChild(label);
        divWrapper.appendChild(theBreak);
      });
      return form;
    },
    userAnswer: null
  },
  {
    id: 3,
    question: "How do you drink your coffee?",
    text: "blablabla blablabla blablabla",
    type: "radio",
    answerQ: function() {
      let values = [
        {
          title: "Black",
          img: "black.png"
        },
        {
          title: "With milk",
          img: "milk.png"
        },
        {
          title: "Black with sugar",
          img: "sugar_black.png"
        },
        {
          title: "With sugar and milk",
          img: "sugar_milk.png"
        }
      ];
      let form = document.createElement("form");

      // form.setAttribute("class", "listenTo");
      // form.setAttribute("class", "gridWith2columns");
      form.className = "listenTo gridWith2columns";
      values.forEach(function(value) {
        let divWrapper = document.createElement("div");
        let label = document.createElement("label");
        let theInput = document.createElement("input");
        let theBreak = document.createElement("br");
        let divAnswer = document.querySelector("#answer");
        // divAnswer.setAttribute("class", "addGrid");
        divWrapper.setAttribute("class", "wrapper");
        // label.setAttribute("class", "labelClass");
        theInput.setAttribute("type", "radio");
        theInput.setAttribute("name", "adds");
        theInput.setAttribute("value", value.title);
        let divWrapperP = document.createElement("div");
        let nameInput = document.createElement("p");
        let img = document.createElement("img");
        nameInput.style.display = "inline";
        divWrapperP.setAttribute("class", "btnRadio");
        nameInput.innerHTML = value.title;

        img.setAttribute("class", "imgSize");
        img.setAttribute("src", "img/" + value.img);

        divWrapperP.appendChild(nameInput);
        divWrapperP.appendChild(img);
        // nameInput.appendChild(img);
        form.appendChild(divWrapper);

        label.appendChild(theInput);
        label.appendChild(divWrapperP);
        divWrapper.appendChild(label);
        divWrapper.appendChild(theBreak);
      });
      return form;
    },
    userAnswer: null
  },
  {
    id: 4,
    question: "Would you like to choose a region of origin?",
    text: "blablabla blablabla blablabla",
    type: "radio",
    answerQ: function() {
      let values = [
        {
          title: "South America",
          desc:
            "American coffees typically exhibit a slight sweetness in the flavor which is often accented by a sparkling, crisp, and lively acidity that may be also be spicy"
        },
        {
          title: "Asia",
          desc:
            "It has a good balance of sweetness and acidity, with a honey-like scent and hints of flowers and cherries"
        },
        {
          title: "Africa",
          desc:
            "These coffees often feature a big body that's enhanced with a strong sweetness. Flavors from Ethiopia's, Rwanda's, Kenya's and Burundi's coffees are often fruity or floral."
        },
        {
          title: "I do not know",
          desc: "We will make a choice for you based on your other preferences."
        }
      ];
      let form = document.createElement("form");
      // form.setAttribute("class", "gridWith2columns");
      // form.setAttribute("class", "listenTo");
      form.className = "listenTo gridWith2columns textBtns";
      values.forEach(function(value) {
        let divWrapper = document.createElement("div");
        let label = document.createElement("label");
        let theInput = document.createElement("input");
        let theBreak = document.createElement("br");
        let divAnswer = document.querySelector("#answer");
        // divAnswer.setAttribute("class", "addGrid");
        divWrapper.setAttribute("class", "wrapper");
        // label.setAttribute("class", "labelClass");
        theInput.setAttribute("type", "radio");
        theInput.setAttribute("name", "origins");
        theInput.setAttribute("value", value.title);
        let divWrapperP = document.createElement("div");
        let nameInput = document.createElement("p");
        let description = document.createElement("p");
        nameInput.style.display = "inline";
        divWrapperP.setAttribute("class", "btnRadio");
        nameInput.innerHTML = value.title;
        description.textContent = value.desc;

        divWrapperP.appendChild(nameInput);
        divWrapperP.appendChild(description);
        // nameInput.appendChild(img);
        form.appendChild(divWrapper);

        label.appendChild(theInput);
        label.appendChild(divWrapperP);
        divWrapper.appendChild(label);
        divWrapper.appendChild(theBreak);
      });
      return form;
    },
    userAnswer: null
  },
  {
    id: 5,
    question: "Here is your recommendation!",
    text: "We think it fits you the best",

    answerQ: function() {
      const coffees = [
        {
          id: 1,
          name: "Coffee1",
          origin: "Brazil",
          taste: "Nice",
          roast: "Medium",
          img: "coffe1.png"
        },
        {
          id: 2,
          name: "Coffee2",
          origin: "Asia",
          taste: "Very nice",
          roast: "Light",
          img: "coffe2.png"
        },
        {
          id: 3,
          name: "Coffee3",
          origin: "Africa",
          taste: "Nice nice",
          roast: "Dark",
          img: "coffe3.png"
        },
        {
          id: 4,
          name: "Coffee4",
          origin: "Argentina",
          taste: "Nice Mice",
          roast: "Medium",
          img: "coffe4.png"
        },
        {
          id: 5,
          name: "Coffee5",
          origin: "Thailand",
          taste: "Pice",
          roast: "Light",
          img: "coffe5.png"
        },
        {
          id: 6,
          name: "Coffee6",
          origin: "Congo",
          taste: "Dice",
          roast: "Dark",
          img: "coffe6.png"
        }
      ];
      let randomChoice = coffees[Math.floor(Math.random() * coffees.length)];
      console.log("randomChoice", randomChoice);

      let divForResults = document.createElement("div");
      // form.setAttribute("class", "gridWith2columns");
      // form.setAttribute("class", "listenTo");
      divForResults.className = "testResults";
      let img = document.createElement("img");
      img.setAttribute("class", "imgResults");
      img.setAttribute("src", "img/" + randomChoice.img);
      let pName = document.createElement("p");
      pName.textContent = randomChoice.name;
      let pOrigin = document.createElement("p");
      pOrigin.textContent = randomChoice.origin;
      let pTaste = document.createElement("p");
      pTaste.textContent = randomChoice.pTaste;
      let pRoast = document.createElement("p");
      pRoast.textContent = randomChoice.roast;
      let startAgainBtn = document.createElement("button");
      startAgainBtn.innerHTML = "Take test again!";
      startAgainBtn.addEventListener("click", () => {
        window.location.reload(true);
      });
      divForResults.append(img, pName, pOrigin, pTaste, pRoast, startAgainBtn);
      return divForResults;
    }
  }
];

const questionTitle = document.querySelector("#question");
const questionText = document.querySelector("#questionText");
const answer = document.querySelector("#answer");

let currentQuestionIndex = 0;

function insertIntoDOM() {
  document.querySelector("#backBtn").style.display = "none";

  questionTitle.textContent = questions[currentQuestionIndex].question;
  questionText.textContent = questions[currentQuestionIndex].text;

  answer.appendChild(questions[currentQuestionIndex].answerQ());

  document.getElementById("backBtn").addEventListener("click", function() {
    prevElement();
  });
  document.getElementById("nextBtn").addEventListener("click", function() {
    nextElement();
  });
}

function prevElement() {
  answer.textContent = "";
  let currentEl = prevItem();
  questionTitle.textContent = currentEl.question;
  questionText.innerHTML = currentEl.text;

  answer.appendChild(questions[currentQuestionIndex].answerQ());
  if (
    questions[currentQuestionIndex].type == "radio" &&
    !questions[currentQuestionIndex].userAnswer
  ) {
    setNextBtnDisabled(true);
  }

  if (questions[currentQuestionIndex].userAnswer) {
    radioAnswerInsert();
    setNextBtnDisabled(false);
  }

  if (questions[currentQuestionIndex].id == 1) {
    document.querySelector("#backBtn").style.display = "none";
  }
  timeline(questions);
  eventlistenerForRadio();
}

function nextElement() {
  document.querySelector("#backBtn").style.display = "inline-block";

  saveRadioAnswer();

  answer.textContent = "";
  let currentEl = nextItem();

  questionTitle.textContent = currentEl.question;
  questionText.innerHTML = currentEl.text;
  answer.appendChild(questions[currentQuestionIndex].answerQ());
  if (questions[currentQuestionIndex].id != 5) {
    eventlistenerForRadio();
    disabledIfEmpty();
    timeline(questions);
  } else {
    document.querySelector("#nextBtn").style.display = "none";
  }
}

function prevItem() {
  if (currentQuestionIndex - 1 < 0) {
    currentQuestionIndex = 0;
  } else {
    currentQuestionIndex--;
  }
  return questions[currentQuestionIndex];
}

function nextItem() {
  if (currentQuestionIndex + 1 < questions.length) {
    currentQuestionIndex++;
  }
  return questions[currentQuestionIndex];
}

function setNextBtnDisabled(bool) {
  document.getElementById("nextBtn").disabled = bool;
}

function saveRadioAnswer() {
  let input = answer.querySelector("input");
  let radioName = input.getAttribute("name");
  let radioValue = getRadioCheckedValue(radioName);
  questions[currentQuestionIndex].userAnswer = radioValue[0];
}

function getRadioCheckedValue(radio_name) {
  let formToCheck = document.querySelector(".listenTo");
  let oRadio = formToCheck.elements[radio_name];

  for (let u = 0; u < oRadio.length; u++) {
    if (oRadio[u].checked) {
      // console.log("u index", u);
      return [oRadio[u].value, u];
    }
  }
  // console.log("radio value returned?", oRadio[u].value);
  return "";
}

function radioAnswerInsert() {
  if (questions[currentQuestionIndex].type == "radio") {
    let allRadios = answer.querySelectorAll("input");
    let radioArr = Array.prototype.slice.call(allRadios);
    for (let u = 0; u < radioArr.length; u++) {
      if (radioArr[u].value == questions[currentQuestionIndex].userAnswer) {
        radioArr[u].checked = true;
      }
    }
  }
}

function eventlistenerForRadio() {
  console.log("eventlistener runs");
  document.querySelector(".listenTo").addEventListener("click", function() {
    let allRadios = document.querySelectorAll("input[type=radio]");
    console.log("we are inside eventlistener");
    for (let i = 0; i < allRadios.length; i++) {
      console.log("we are inside the loop");
      if (allRadios[i].checked == true) {
        let radioValue = allRadios[i].value;
        questions[currentQuestionIndex].answer = radioValue;
        console.log({ radioValue });
      }
    }
    setNextBtnDisabled(false);
  });
}

function disabledIfEmpty() {
  setNextBtnDisabled(true);
  if (questions[currentQuestionIndex].userAnswer) {
    setNextBtnDisabled(false);
  }
}
function timeline(questions) {
  let timelineInput = document.querySelector("#timeline");
  let allQuestionsDigit = questions.length - 1;
  let currentQuestionDigit = questions[currentQuestionIndex].id;
  timelineInput.textContent = currentQuestionDigit + "/" + allQuestionsDigit;
}

function init() {
  timeline(questions);
  insertIntoDOM();
  eventlistenerForRadio();
}
