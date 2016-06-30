/*
 * App JS script
 */
function getController() {
    return $F("hfController");
}

function loadController(controller) {
    document.location = controller != null ? controller : getController();
}