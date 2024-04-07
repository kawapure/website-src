# Mozilla Glossary

This page explains common terminology used by Mozilla. See also: https://firefox-source-docs.mozilla.org/glossary/index.html.

I also recommend reading through [Gecko:Overview](https://wiki.mozilla.org/Gecko:Overview) on the Mozilla wiki for more information.

## "NS" prefix

Mozilla source code has tons of references to "NS". This is simply an abbreviation for Netscape, the company who originally wrote Mozilla technologies. Although they have been defunct for over 20 years, this naming scheme wasn't exactly dropped.

## "XP" prefix

Not related to Windows XP. This is simply an abbreviation for "cross-platform". It is used in the naming of components which are designed in order to be cross-platform, such as XPCOM or XPInstall.

## Chrome

Not directly related to and predates Google Chrome. This was historically a term used to refer to the user interface of a browser, before Google named a browser after it.

## XUL

XUL is Mozilla's XML-based UI markup language, with distinct elements from HTML. It was created back when HTML 4 was the standard, and CSS features like flexbox didn't yet exist. Today, XUL documents were replaced with compatible XHTML documents, but the distinction of XUL elements from HTML elements still remains in the user-interface design of Mozilla programs. Only duplicate elements have been replaced with their HTML variants where applicable.

## XBL

XBL (XML Binding Language) was a feature of older versions of Mozilla. XBL bindings were set via CSS, and shaped the markup and behaviour of an element. It has since been replaced by a combination of modern web technologies, namely Shadow DOM and custom elements.

## [XPCOM](https://wiki.mozilla.org/Gecko:Overview#XPCOM)

XPCOM is Mozilla's cross-platform clone of Microsoft's COM (referred to in Mozilla code as MSCOM), a Windows-only technology. It has historically been ABI-compatible with Microsoft's COM, but this is deprecated and compatibility may break at any time in future Mozilla releases. XPCOM is used for sharing code interfaces, even across languages, within Mozilla applications.

## [XPC / XPConnect](https://wiki.mozilla.org/Gecko:Overview#XPConnect)

XPConnect is used to refer to the system that allows XPCOM objects to be used natively in JavaScript code.

## XPI / XPInstall

This terminology is used by the add-on system present under Mozilla applications. See [Extension Manager:Overview](https://wiki.mozilla.org/Extension_Manager:Overview) on the Mozilla wiki for more information.

## [E10S / Electrolysis](https://wiki.mozilla.org/Electrolysis)

Electrolysis was a project started in 2009 to implement a multi-process Firefox browsing context. This allowed for increased security and stability, at the expense of requiring frontend code (such as browser chrome and classic add-ons) to be rewritten. Electrolysis finally concluded in 2018, after the removal of classic add-ons from Firefox.

## [Fission](https://wiki.mozilla.org/Project_Fission)

Fission is a successor project to Electrolysis, extending process separation to make all distinct websites run in separate processes. It additionally resulted in the reworkings of the IPC system, [introducing modern JSActors](https://firefox-source-docs.mozilla.org/dom/ipc/jsactors.html).