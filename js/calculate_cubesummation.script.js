/*
 * JS script for controller: "calculate_cubesummation"
 */
var objectInputDataValidator = function(name) {
    var value = 0;
    var count = 0;
    this.getName = function() { return name; }
    this.set = function(newValue) { value = newValue; }
    this.getValue = function() { return value; }
    this.add = function() { count++; }
    this.getCount = function() { return count; }
    this.getCount1 = function() { return count + 1; }
    this.isComplete = function() { return (value > 0 && value == count); }
    this.reset = function() { value = count = 0; }
}

var CALCULATE_CUBESUMMATION = {};
CALCULATE_CUBESUMMATION.testCases = new objectInputDataValidator("test-cases");
CALCULATE_CUBESUMMATION.dimensions = new objectInputDataValidator("dimensions");
CALCULATE_CUBESUMMATION.operations = new objectInputDataValidator("operations");
CALCULATE_CUBESUMMATION.input = CALCULATE_CUBESUMMATION.testCases.getName();
CALCULATE_CUBESUMMATION.completed = false;

document.observe("dom:loaded",
    function(eventHandler) {
        if($("btnCalculate") != null) {
            $("tfInputData").observe("keydown", filterInputData);
            $("tfInputData").observe("keyup",
                function(eventHandler) {
                    applyKeyRETURN(eventHandler, addInputData);
                    applyKeyESC(eventHandler, clearInputData);
                });
            $("btnAddData").observe("click", addInputData);
            $("btnClearData").observe("click", clearInputData);
            $("btnCalculate").observe("click", submitInputData);
            $("btnCancel").observe("click", cancel);
            $("tfInputData").focus();
        }
        else {
            $("btnBack").observe("click", cancel);
            $("btnBack").focus();
        }
    });

function filterInputData(eventHandler) {
    with(CALCULATE_CUBESUMMATION) {
        if(input == testCases.getName())
            keyFilter(eventHandler, "digit");
        else if(input == dimensions.getName())
            keyFilter(eventHandler, "digit+space");
        else if(input == operations.getName())
            keyFilter(eventHandler, "letter+space+digit");
    }
}

function addInputData(eventHandler) {
    if(!$("tfInputData").present())
        return;
    saveInputData();
    $("taInputData").value = $("taInputData").value + $F("tfInputData") + "\n";
    clearInputData();
    if(CALCULATE_CUBESUMMATION.completed) {
        $("tfInputData").disable();
        $("btnAddData").disable();
        $("btnClearData").disable();
        alert("Data Completed!");
        $("btnCalculate").focus();
    }
}

function saveInputData() {
    var tag = "";
    $("tfInputData").value = $F("tfInputData").trim().toUpperCase();
    with(CALCULATE_CUBESUMMATION) {
        if(input == operations.getName()) {
            operations.add();
            tag = "Operation #" + operations.getCount1() + "/" + operations.getValue();
            if(operations.isComplete()) {
                testCases.add();
                completed = testCases.isComplete();
                if(!completed) {
                    dimensions.reset();
                    operations.reset();
                    input = dimensions.getName();
                    tag = "Dimensions-Operations (" + testCases.getCount1() + "/" + testCases.getValue() + ")";
                }
                else
                    tag = "Completed!";
            }
        }
        else if(input == dimensions.getName()) {
            var data = $F("tfInputData").split(" ");
            dimensions.set(data[0]);
            operations.set(data[1]);
            input = operations.getName();
            tag = "Operation #" + operations.getCount1() + "/" + operations.getValue();
        }
        else if(input == testCases.getName()) {
            testCases.set($F("tfInputData"));
            input = dimensions.getName();
            tag = "Dimensions-Operations (" + testCases.getCount1() + "/" + testCases.getValue() + ")";
        }
    }
    $("spnTag").update(tag);
}

function clearInputData(eventHandler) {
    $("tfInputData").clear().focus();
}

function submitInputData(eventHandler) {
    if(!CALCULATE_CUBESUMMATION.completed) {
        alert("Input Data Incomplete!");
        clearInputData();
        return;
    }
    $("frmInput").action = getController() + "?action=calculate";
    $("frmInput").submit();
}

function cancel(eventHandler) {
    loadController();
}