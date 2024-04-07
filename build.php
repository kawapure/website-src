<?php
require "vendor/autoload.php";
require "context.php";
require "functions.php";

$g_context = new KawapureSiteContext;
$g_context->workingDir = realpath(dirname(__FILE__));

echo "Building website...\n";

buildPage("index");
buildPage("credits");
buildPage("about");

// Register all MSD pages
MSD::register("Glossary", "glossary");

// Build MSD-related pages
buildPage("mozilla_simple_docs/index", "msd", "templates/msd");
MSD::buildAll();

echo "Building static resources...\n";

set_time_limit(0);
shell_exec("gulp build");