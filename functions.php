<?php
// Functions for the build system
function buildPage(
    string $path,
    string $pageContextName = "",
    string $template = "",
    array $params = []
): void
{
    global $g_context;

    if (empty($pageContextName))
    {
        $pageContextName = $path;
    }

    if (empty($template))
    {
        $template = "templates/" . $path;
    }

    $params["pageName"] = $pageContextName;
    $params["getMsdPages"] = $g_context->getGetMsdPagesWrapper();

    echo "Building page $path.html ($pageContextName) with $template.latte \n";

    $output = $g_context->latte->renderToString($template . ".latte", $params);

    $g_context->writePublicPage("public/" . $path . ".html", $output);
}