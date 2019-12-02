"use strict";
const startBtn = document.querySelector("#startBtn");

startBtn.addEventListener("click", () => {
  document.querySelector(".intro").style.display = "none";
  init();
});

let questions = [
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
      form.setAttribute("class", "gridWith3columns");

      values.forEach(function(value) {
        let divWrapper = document.createElement("div");
        let label = document.createElement("label");
        let theInput = document.createElement("input");
        let theBreak = document.createElement("br");
        let divAnswer = document.querySelector("#answer");
        divAnswer.setAttribute("class", "addGrid");
        divWrapper.setAttribute("class", "wrapper");
        // label.setAttribute("class", "labelClass");
        theInput.setAttribute("type", "radio");
        theInput.setAttribute("name", "coffeeTypes");
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
      form.setAttribute("class", "gridWith2columns");
      values.forEach(function(value) {
        let divWrapper = document.createElement("div");
        let label = document.createElement("label");
        let theInput = document.createElement("input");
        let theBreak = document.createElement("br");
        let divAnswer = document.querySelector("#answer");
        divAnswer.setAttribute("class", "addGrid");
        divWrapper.setAttribute("class", "wrapper");
        // label.setAttribute("class", "labelClass");
        theInput.setAttribute("type", "radio");
        theInput.setAttribute("name", "coffeeTypes");
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
      form.setAttribute("class", "gridWith2columns");

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
        theInput.setAttribute("name", "coffeeAdds");
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
      form.setAttribute("class", "gridWith2columns");
      values.forEach(function(value) {
        let divWrapper = document.createElement("div");
        let label = document.createElement("label");
        let theInput = document.createElement("input");
        let theBreak = document.createElement("br");
        let divAnswer = document.querySelector("#answer");
        divAnswer.setAttribute("class", "addGrid");
        divWrapper.setAttribute("class", "wrapper");
        // label.setAttribute("class", "labelClass");
        theInput.setAttribute("type", "radio");
        theInput.setAttribute("name", "coffeeTypes");
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
}

function nextElement() {
  document.querySelector("#backBtn").style.display = "inline-block";
  answer.textContent = "";
  let currentEl = nextItem();

  questionTitle.textContent = currentEl.question;
  questionText.innerHTML = currentEl.text;
  answer.appendChild(questions[currentQuestionIndex].answerQ());
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
  document.getElementById("next_button").disabled = bool;
}

function saveRadioAnswer() {
  let input = answer.querySelector("input");
  let radioName = input.getAttribute("name");
  let radioValue = getRadioCheckedValue(radioName);
  questions[currentQuestionIndex].userAnswer = radioValue[0];
}

function init() {
  insertIntoDOM();
}
