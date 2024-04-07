<?php

class KawapureSiteContext
{
    public Latte\Engine $latte;

    public string $workingDir;

    public function __construct()
    {
        $this->latte = new Latte\Engine;
    }

    public function writePublicPage(string $path, string $data): void
    {
        $fh = fopen($this->workingDir . "/" . $path, "w");

        if ($fh)
        {
            fwrite($fh, $data);
            fclose($fh);
        }
    }

    public function getGetMsdPagesWrapper(): Closure
    {
        return Closure::fromCallable(MSD::class . "::getEntries");
    }
}

/**
 * Mozilla Simple Docs controller class
 */
class MSD
{
    private static array $registry = [];

    public static function register(string $title, string $doc): void
    {
        self::$registry[] = [$title, $doc];
    }

    public static function buildAll(): void
    {
        foreach (self::$registry as $entry)
        {
            self::build($entry[0], $entry[1]);
        }
    }

    public static function getEntries(): array
    {
        return self::$registry;
    }

    public static function build(string $title, string $doc): void
    {
        echo "Building Mozilla simple docs page $title ($doc)\n";
        global $g_context;

        $pd = new Parsedown();
        $file = file_get_contents("templates/mozilla_simple_docs/$doc.md");

        $contents = $pd->text($file);

        $output = $g_context->latte->renderToString("templates/mozilla_doc_page.latte", [
            "pageName" => "mozilla-simple-docs-$doc",
            "msdTitle" => $title,
            "msdContents" => $contents
        ]);

        $g_context->writePublicPage("public/mozilla_simple_docs/" . $doc . ".html", $output);
    }
}