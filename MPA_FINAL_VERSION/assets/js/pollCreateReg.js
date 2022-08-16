var counter = 1;


document.getElementById("pollCreation").addEventListener("submit", pollCreate, false);
document.getElementById("pollCreationQuestion").addEventListener("input", countCharacters);
document.getElementById("answer1").addEventListener("input", answerCountCharacters1);
document.getElementById("answer2").addEventListener("input", answerCountCharacters2);
document.getElementById("answer3").addEventListener("input", answerCountCharacters3);
document.getElementById("answer4").addEventListener("input", answerCountCharacters4);
document.getElementById("answer5").addEventListener("input", answerCountCharacters5);
document.getElementById("addNewButton").addEventListener("button", createNewField);