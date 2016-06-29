/*
 * App JS script
 */
function getController() {
    return $F("hfController");
}

function isKeyRETURN(eventHandler) {
    return (eventHandler.keyCode == Event.KEY_RETURN);
}

function applyKeyRETURN(eventHandler, button) {
    if(isKeyRETURN(eventHandler))
        button.click();
}