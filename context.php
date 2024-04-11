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
        $path = "templates/mozilla_simple_docs/$doc.md";
        $file = file_get_contents($path);

        $firstPara = self::getMarkdownFirstParagraph($file);
        $contents = $pd->text($file);

        // Get the last modified time of the document:
        // (for the time being, this is queried from Git, with the file system as a fallback if that doesn't work)
        try
        {
            $lastModifiedTime = shell_exec("git log -1 --pretty=\"format:%ct\" " . $path);
        }
        catch (\Exception $e) {}

        if (!$lastModifiedTime)
        {
            $lastModifiedTime = filemtime($path);
        }

        $output = KawapureSiteContext::$latte->renderToString("templates/mozilla_doc_page.latte", [
            "pageName" => "mozilla-simple-docs-$doc",
            "msdTitle" => $title,
            "msdContents" => $contents,
            "msdMetadataDescription" => $firstPara,
            "msdLastModified" => date("j F Y", $lastModifiedTime)
        ]);

        KawapureSiteContext::writePublicPage("public/mozilla_simple_docs/" . $doc . ".html", $output);
    }

    /**
     * Gets the first paragraph of a markdown document.
     *
     * This is used to get the text for the metadata description, which is visible when the site is
     * linked to on various services.
     *
     * This is a bit of a hacky solution, but since the markdown parser can only parse to a HTML string
     * directly, I decided I would go ahead with a hacky solution.
     *
     * This should be rewritten in the future to properly parse the document, and thus be able to handle
     * cases such as links being in the first paragraph, but that's not necessary right now.
     */
    private static function getMarkdownFirstParagraph(string $doc): string
    {
        // Get the metadata description for this page. We want to get the first paragraph from
        // the document.
        $lines = explode("\n", trim($doc)); // Ensure that whitespace is removed

        if ($lines[0][0] == "#")
        {
            // Drop the first line off of the file and separate new lines.
            $lines = array_slice($lines, 1);
        }

        // Skip over any initial whitespace (or that succeeding a header)
        for ($i = 0; $i < count($lines); $i++)
        {
            if (preg_match("/\w/", $lines[$i]))
            {
                $lines = array_slice($lines, $i);
                break;
            }
        }

        // Opposite thing; we remove past the next blank line.
        for ($i = 1; $i < count($lines); $i++)
        {
            if (!preg_match("/\w/", $lines[$i]))
            {
                $lines = array_slice($lines, 0, $i);
                break;
            }
        }

        // And we should have our result
        $firstPara = trim(implode(" ", $lines));

        assert($firstPara != trim(implode(" ", explode("\n", $doc))));

        return $firstPara;
    }
}