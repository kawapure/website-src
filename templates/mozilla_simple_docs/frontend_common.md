# Common Mozilla Frontend Things

This page discusses a lot of things common to the Mozilla frontend, common to almost all Mozilla applications.

Note: "frontend" here refers to a similar topic to what you'll see referred to elsewhere as the "browser chrome" or "browser context". I chose neutral language for this article, as I am discussing something common to Mozilla applications rather than a Firefox-centric feature.

## Frontend implementation

The frontend in the majority of Mozilla applications is implemented in XUL. This may sound like outdated information in 2024, but it actually still holds true even for the latest versions of Firefox and Thunderbird. Although the XUL markup language doesn't exist anymore and the browser doesn't support loading XUL documents anymore, the XUL toolkit still exists and is heavily used throughout contemporary frontend implementations.

XUL-based frontends are implemented with a web document format supported by Gecko (such as HTML or XHTML, or previously the XUL markup language), JavaScript, and CSS. The stack is basically the same as websites, but frontend scripts are given more permission than scripts on webpages are given.

Note that there was previously support for non-XUL-based frontends, but this was deprecated long ago and the option to build Gecko without XUL has long since been removed ([here's the commit if you're interested](https://github.com/mozilla/gecko-dev/commit/8e411675acccb75de91220050815526916857e1a)). As far as I can tell, this was only used in the Mac-OS-only browser Camino (formerly Chimera) ([Wikipedia](https://en.wikipedia.org/wiki/Camino_(web_browser)), [Source code](https://hg.mozilla.org/camino/file/default)).

## Variable access in JavaScript

*This section applies mostly to current-day `.sys.mjs` files at the moment. I don't have documentation on `.jsm` context separation at the moment.*

There are some things to keep in mind when writing JavaScript code for the Mozilla frontend.

Code is separated into modules (currently done via ES6-standard modules using the `.sys.mjs` extension, but formerly implemented with a custom format in `.jsm` files). Modules all have different scopes from one another, so they can't access each other's unexported variables (or the page's global context directly).

However, each module does have global access to some things. XPConnect creates a global object with just about the same global variables as `window` called a `BackstagePass`. This is the actual context that global scripts run in, which means that they can define global variables liberally without affecting anything else.

There are some other kinds of global object they can use (such as `Sandbox`), but these are significantly less common.