/*
 * JS script for keyboard functions
 */
var KEYBOARD_FUNCTIONS = {};
KEYBOARD_FUNCTIONS.filterSpace = false;

function isKeyRETURN(eventHandler) {
    return (eventHandler.keyCode == Event.KEY_RETURN);
}

function applyKeyRETURN(eventHandler, myFunction) {
    if(isKeyRETURN(eventHandler))
        myFunction(eventHandler);
}

function isKeyESC(eventHandler) {
    return (eventHandler.keyCode == Event.KEY_ESC);
}

function applyKeyESC(eventHandler, myFunction) {
    if(isKeyESC(eventHandler))
        myFunction(eventHandler);
}

function keyFilter(eventHandler, type) {
    if(isKeySpecial(eventHandler))
        return;
    var result = false;
    var filter = type.split("+");
    $A(filter).each(
        function(filterType) {
            filterType = filterType.trim();
            switch(filterType) {
                case "digit":
                    if(filterDigits(eventHandler)) {
                        result = result || true;
                        KEYBOARD_FUNCTIONS.filterSpace = false;
                    }
                    break;
                case "letter":
                    if(filterLetters(eventHandler)) {
                        result = result || true;
                        KEYBOARD_FUNCTIONS.filterSpace = false;
                    }
                    break;
                case "accent":
                    if(filterAccents(eventHandler)) {
                        result = result || true;
                        KEYBOARD_FUNCTIONS.filterSpace = false;
                    }
                    break;
                case "space":
                    if(!KEYBOARD_FUNCTIONS.filterSpace) {
                        KEYBOARD_FUNCTIONS.filterSpace = filterSpace(eventHandler);
                        result = result || KEYBOARD_FUNCTIONS.filterSpace;
                    }
                    else
                        result = false;
                    break;
            }
        });
    if(!result) {
        try {
            window.event.returnValue = false;
        }
        catch(e) {
            eventHandler.preventDefault();
        }
    }
}

function isKeySpecial(eventHandler) {
    switch(eventHandler.keyCode) {
        case Event.KEY_BACKSPACE:
        case Event.KEY_DELETE:
        case Event.KEY_HOME:
        case Event.KEY_END:
        case Event.KEY_LEFT:
        case Event.KEY_RIGHT:
        case Event.KEY_TAB:
            return true;
    }
    return false;
}

function filterDigits(eventHandler) {
    return (eventHandler.keyCode >= 48 && eventHandler.keyCode <= 57);//0-9
}

function filterLetters(eventHandler) {
    switch(true) {
        case (eventHandler.keyCode >= 65 && eventHandler.keyCode <= 90)://A-Z
        case (eventHandler.keyCode >= 97 && eventHandler.keyCode <= 122)://a-z
            return true;
    }
    return false;
}

function filterAccents(eventHandler) {
    var character = String.fromCharCode(eventHandler.keyCode);
    switch(true) {
        case (character == "á" || character == "Á"):
        case (character == "é" || character == "É"):
        case (character == "í" || character == "Í"):
        case (character == "ó" || character == "Ó"):
        case (character == "ú" || character == "Ú"):
        case (character == "ñ" || character == "Ñ"):
            return true;
    }
    return false;
}

function filterSpace(eventHandler) {
    return (eventHandler.keyCode == 32);
}