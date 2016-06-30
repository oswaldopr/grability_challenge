<!DOCTYPE HTML>
<head>
    <meta http-equiv="content-type" content="text/html" />
    {load_css sheet="app"}
    {$templateCSS}
    {load_js script="prototype"}
    {load_js script="app"}
    {load_js script="keyboard_functions"}
    {$templateJS}
    <title>&nbsp;</title>
</head>

<body>
    {$controller}
    {if $errorMessage neq ""}
    <div class="error">{$errorMessage}</div>
    <input type="button" id="btnBack" value="[ BACK ]" />
    {elseif $input neq ""}
    <div id="title">Input Data:</div>
    <div>{$input|upper|nl2br}</div>
    <br />
    <div id="title">Output Data:</div>
    <div>{$output|nl2br}</div>
    <input type="button" id="btnBack" value="[ BACK ]" />
    {else}
    <div>Input: <span id="spnTag">Test-Cases</span></div>
    <div id="divInputData">
        <input type="text" id="tfInputData" />
        <span>
            <input type="button" id="btnAddData" value="[ ADD ]" />
            <input type="button" id="btnClearData" value="[ CLEAR ]" />
        </span>
    </div>
    <form id="frmInput" method="post">
        <textarea name="taInputData" id="taInputData" readonly="readonly"></textarea>
    </form>
    <input type="button" id="btnCalculate" value="[ CALCULATE ]" />
    <input type="button" id="btnCancel" value="[ CANCEL ]" />
    {/if}
</body>
</html>