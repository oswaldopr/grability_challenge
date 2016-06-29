<!DOCTYPE HTML>
<head>
    <meta http-equiv="content-type" content="text/html" />
    {load_css sheet="app"}
    {$templateCSS}
    {$templateJS}
    <title>{$appName} :: {$appProject}</title>
</head>

<body>
    <div class="titles">
        <h1>{$appName}</h1>
        <h2>{$appProject}</h2>
    </div>
    <iframe id="ifrController" src="{$require}"></iframe>
</body>
</html>