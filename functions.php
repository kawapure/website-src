<?php
// Functions for the build system
function buildPage(
    string $path,
    string $pageContextName = "",
    string $template = "",
    array $params = []
): void
{
    if (empty($pageContextName))
    {
        $pageContextName = $path;
    }

    if (empty($template))
    {
        $template = "templates/" . $path;
    }

    $params["pageName"] = $pageContextName;
    $params["getMsdPages"] = KawapureSiteContext::getGetMsdPagesWrapper();

    echo "Building page $path.html ($pageContextName) with $template.latte \n";

    $output = KawapureSiteContext::$latte->renderToString($template . ".latte", $params);

    KawapureSiteContext::writePublicPage("public/" . $path . ".html", $output);
}