<?php
require "vendor/autoload.php";
require "context.php";
require "functions.php";

KawapureSiteContext::$workingDir = realpath(dirname(__FILE__));

// Begin site building:
echo "Building website...\n";

// Register all standard pages:
require "registry/standard_page_registry.php";

// Register all MSD pages:
require "registry/msd_registry.php";

// Build MSD-related pages:

// In order to avoid dependency issues, this page is simply built last so that it can access the
// MSD registry.
buildPage("mozilla_simple_docs/index", "msd", "templates/msd");

MSD::buildAll();

echo "Building static resources...\n";

/*
 * Build Gulp resources (CSS, JS).
 *
 * We disable the PHP time limit here, since this could realistically take longer
 * than the time limit, and we're waiting on an external script.
 */
set_time_limit(0);
shell_exec("gulp build");