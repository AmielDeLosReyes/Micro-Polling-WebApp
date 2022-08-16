
function pollCreate(event) {
    var valid = true;
    var warnings = "";

    // Get field values
    var elements = event.currentTarget;
    var pollQuestion = elements[0].value;
    var answer1 = elements[1].value;
    var answer2 = elements[2].value;
    var answer3 = elements[3].value;
    var answer4 = elements[4].value;
    var answer5 = elements[5].value;


    // Get reference on message errors
    var msg_question = document.getElementById("msg_question");
    var msg_answer1 = document.getElementById("msg_answer1");
    var msg_answer2 = document.getElementById("msg_answer2");
    var msg_answer3 = document.getElementById("msg_answer3");
    var msg_answer4 = document.getElementById("msg_answer4");
    var msg_answer5 = document.getElementById("msg_answer5");
    msg_question.innerHTML  = "";
    msg_answer1.innerHTML = "";
    msg_answer2.innerHTML = "";
    msg_answer3.innerHTML = "";
    msg_answer4.innerHTML = "";
    msg_answer5.innerHTML = "";


    //Variables for DOM Manipulation commands
    var textNode;

    if (pollQuestion == null || pollQuestion == "") {
        textNode = document.createTextNode("Poll Question cannot be empty.");
        msg_question.appendChild(textNode);
        valid = false;
    }else if (pollQuestion.length > 100) {
        textNode = document.createTextNode("Poll Question cannot be longer than 100 characters.");
        msg_question.appendChild(textNode);
        valid = false;
    }

    if (answer1.length > 50) {
        textNode = document.createTextNode("Answer cannot be longer than 50 characters.");
        msg_answer1.appendChild(textNode);
        valid = false;
    }

    if (answer2.length > 50) {
        textNode = document.createTextNode("Answer cannot be longer than 50 characters.");
        msg_answer2.appendChild(textNode);
        valid = false;
    }

    if (answer3.length > 50) {
        textNode = document.createTextNode("Answer cannot be longer than 50 characters.");
        msg_answer3.appendChild(textNode);
        valid = false;
    }

    if (answer4.length > 50) {
        textNode = document.createTextNode("Answer cannot be longer than 50 characters.");
        msg_answer4.appendChild(textNode);
        valid = false;
    }

    if (answer5.length > 50) {
        textNode = document.createTextNode("Answer cannot be longer than 50 characters.");
        msg_answer5.appendChild(textNode);
        valid = false;
    }

    if(valid == false) {    

        //prevent form to be submitted if one of above fields is invalid
        event.preventDefault();
     }else {
        document.location.href = 'pollManagementPage.html';
     }
}


// Character count for the question
const pollQuestionInput = document.getElementById('pollCreationQuestion');
const characterCountInput = document.getElementById('charCount');
const maxNumOfChars = 100;

const countCharacters = () => {
    let numOfEnteredChars = pollQuestionInput.value.length;
    let counter = maxNumOfChars - numOfEnteredChars;

    if(counter < 0) {
        let msg_question = document.getElementById("msg_question");
        msg_question.innerHTML = "";
        let textNode;
        textNode = document.createTextNode("Exceeded characters! ");
        msg_question.appendChild(textNode);
    } else {
        let msg_question = document.getElementById("msg_question");
        msg_question.innerHTML = "";
        var textNode;
        textNode = document.createTextNode("");
        msg_question.appendChild(textNode);

        characterCountInput.textContent = counter + "/100";
    }

    if (counter < 0) {
        characterCountInput.style.color = "red";
    }else if (counter < 20) {
        characterCountInput.style.color = "orange";
    } else {
        characterCountInput.style.color = "black";
    }
    
};

// Character count for answer1
var answerInput = document.getElementById('answer1');
var answerCharCountInput = document.getElementById('ansCharCount1');
var ansMaxNumOfChars1 = 50;

var answerCountCharacters1 = () => {
    let numOfEnteredChars = answerInput.value.length;
    let counter1 = ansMaxNumOfChars1 - numOfEnteredChars;
    
    if (counter1 < 0) {
        let msg_ans = document.getElementById("msg_answer1");
        msg_ans.innerHTML = "";
        let textNode;
        textNode = document.createTextNode("Exceeded characters! ");
        msg_ans.appendChild(textNode);
    }else {
        let msg_ans = document.getElementById("msg_answer1");
        msg_ans.innerHTML = "";
        let textNode;
        textNode = document.createTextNode("");
        msg_ans.appendChild(textNode);
        answerCharCountInput.textContent = counter1 + "/50";
    }
    
    if (counter1 < 0) {
        answerCharCountInput.style.color = "red";
    }else if (counter1 < 20) {
        answerCharCountInput.style.color = "orange";
    } else {
        answerCharCountInput.style.color = "black";
    }
};

var ansCounter = 1;
// Function to create new input field for answers
function createNewField() {
    ansCounter += 1;

    html = '<table id="pollAnswerTable'+ ansCounter + '">\
            <tr>\
                <td>&nbsp;</td>\
                <td><label id="msg_answer' + ansCounter + '" class="err_msg"></label></td>\
            </tr>\
            <tr>\
                <td>Answer: </td>\
                <td>\
                <textarea type="text" id="answer' + ansCounter + '" name="answer' + ansCounter + '" cols="50" rows="5" maxlength="51"></textarea><br/>Character Count: <b id="ansCharCount' + ansCounter + '">0/50</b>\
                </td>\
            </tr>';

    var form = document.getElementById('pollAnswerTable'+ ansCounter + '');
    form.innerHTML += html;
}
