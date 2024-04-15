# Source code for kawapure.github.io

This repository includes the source code for my website, [kawapure.github.io](//kawapure.github.io).

The website uses PHP and the [Latte templating language](//latte.nette.org/en/) to build static site files. The website is open source, so you may fork this system for your own purposes.

## Cloning

This repository uses submodules, so you will need to take this into account when pulling the repository. Use the following command to clone a repository with submodules included:

```
git clone --recurse_submodules https://github.com/kawapure/kawapure.github.io
```

## Testing

If you wish to test a site produced from this, I suggest using XAMPP. You can just replace htdocs to be a symbolic link to the `public/` folder here. A `.htaccess` file is provided in `public/` for convenience.