"use strict";
const startBtn = document.querySelector("#startBtn");

startBtn.addEventListener("click", () => {
  console.log("click");
  document.querySelector(".intro").style.display = "none";
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
      form.setAttribute("id", "coffeeTypes");

      values.forEach(function(value) {
        let divWrapper = document.createElement("div");
        let label = document.createElement("label");
        let theInput = document.createElement("input");
        let theBreak = document.createElement("br");
        let divAnswer = document.querySelector(".testContent");
        // divAnswer.setAttribute("class", "addGrid");
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
  }
];

const questionTitle = document.querySelector("#question");
const questionText = document.querySelector("#questionText");
const answer = document.querySelector("#answer");

let currentQuestionIndex = 0;

function insertIntoDOM() {
  document.querySelector("#backBtn").style.display = "none";

  questionTitle.textContent = questions[currentQuestionIndex].question;
  questionText.textContent = questions[currentQuestionIndex].txt;

  answer.appendChild(questions[currentQuestionIndex].answerQ());

  wrapForCanvas.appendChild(questions[currentQuestionIndex].canvasForChart());

  document.getElementById("prev_button").addEventListener("click", function() {
    prevElement();
  });
  document.getElementById("next_button").addEventListener("click", function() {
    nextElement();
  });
}
