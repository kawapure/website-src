<?php

/**
 * Stores global site building context.
 */
class KawapureSiteContext
{
    public static Latte\Engine $latte;

    public static string $workingDir;

    /**
     * Writes a finished page build to the public directory.
     */
    public static function writePublicPage(string $path, string $data): void
    {
        $fh = fopen(self::$workingDir . "/" . $path, "w");

        if ($fh)
        {
            fwrite($fh, $data);
            fclose($fh);
        }
    }

    /**
     * Gets MSD::getEntries, wrapped in a Closure for consumption in the
     * Latte environment.
     */
    public static function getGetMsdPagesWrapper(): Closure
    {
        return Closure::fromCallable(MSD::class . "::getEntries");
    }
}

KawapureSiteContext::$latte = new Latte\Engine;

/**
 * Mozilla Simple Docs controller class
 */
class MSD
{
    private static array $registry = [];

    /**
     * Registers an MSD page.
     */
    public static function register(string $title, string $doc): void
    {
        self::$registry[] = [$title, $doc];
    }

    /**
     * Builds all MSD pages in the registry.
     */
    public static function buildAll(): void
    {
        foreach (self::$registry as $entry)
        {
            self::build($entry[0], $entry[1]);
        }
    }

    /**
     * Gets all registered MSD pages.
     */
    public static function getEntries(): array
    {
        return self::$registry;
    }

    /**
     * Builds a single MSD page.
     */
    protected static function build(string $title, string $doc): void
    {
        echo "Building Mozilla simple docs page $title ($doc)\n";

        $pd = new Parsedown();
        $file = file_get_contents("templates/mozilla_simple_docs/$doc.md");

        $contents = $pd->text($file);

        $output = KawapureSiteContext::$latte->renderToString("templates/mozilla_doc_page.latte", [
            "pageName" => "mozilla-simple-docs-$doc",
            "msdTitle" => $title,
            "msdContents" => $contents
        ]);

        KawapureSiteContext::writePublicPage("public/mozilla_simple_docs/" . $doc . ".html", $output);
    }
}