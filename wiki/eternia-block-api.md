# Eternia's extended Block API

We have migrated Eternia into a model where block get registered with Block JSON instead of our previous theme settings based model. We however had some custom keys and automatic loading we wanted to retain, so these are likewise migrated to Block JSON files.

## Using Eternia to register blocks

Use the block.json files to register new blocks for the project. You will need to fill out the core required base data for the blocks, and can additionally add ACF or Eternia settings to define block behaviour. ACF and Eternia specific settings are added automatically, but you may well want to overwrite them - the theme will respect settings set in the block.json, but will fill missing data to improve consistency. For example cache is toggled on by default, and ACF preview and render settings are automatically populated if missing.

Scripts and styles are compiled with themes build, and are only loaded if the block exists on a page. If you add the files to the correct folder, the compilation and loading of assets to front end is automated. You can however overwrite the automation by providing a explicit loading path for assets in block.json registration. If you use JS libraries, we suggest registering the scripts as a module to DOM, and loading the assets via reference to keep the bundle sizes reasonable.

## Understanding Block JSON

### Block JSON by default in Core

In core we would register some basic information for the block, along with its render callback or scripts for dynamic rendering. To use an example of our CTA block, these are part of the core API, which is [documented further here](https://developer.wordpress.org/block-editor/getting-started/fundamentals/block-json/).

```JSON
{
    // Namespace / block slug.
    "name": "acf/cta",
    // Schema will help you validate the block configuration. We may need to extend this with ACF + Eternia.
    "$schema": "https://schemas.wp.org/trunk/block.json",
    "title": "Call to action",
    "description": "Block that calls user to do a specific action, by opening a link.",
    "category": "common",
    // Icon can be dashicon or custom SVG. We load custom SVG automatically if found.
    "icon": "admin-comments",
    // Used to find the block in the block inserter.
    "keywords": [
        "cta",
        "call to action"
    ],
    // Attributes are blocks instance data.
    "attributes": {
        // All ACF fields live under "data" attribute.
        "data": {
            "type": "object",
            "default": {}
        }
    },
    // Example is used to preview the block in the inserter.
    "example" : {
        // Width of the inserter preview. By default our desktop design size.
        "viewportWidth" : 1440,
        "attributes" : {
            // Enables dynamic PHP rendering for the inserter.
            "mode" : "preview",
            // ACF uses data as a wrapper for its fields.
            "data" : {
                "title" : "Call to action",
                "text" : "This is a call to action block.",
                "link" : "https://www.example.com",
                "linkText" : "Click here"
            }
        },
    }
}
```

### ACF Modifications

ACF needs to accomodate its metadata handling and various settings, and those are initially entered through the ACF key.

```JSON
    "acf" : {
        // Whether the block should preview or show fields in the editor. With auto, only focused block will show fields.
        "mode" : "auto", 
        // Blocks are by default open to all block types, but you can limit that here.
        "postTypes" : ["post", "page"],
        "renderCallback": "Eternia\\render_acf_block",
    },
```

### Eternia modifications

```JSON
    "eternia" : {
        // Sets the block instance cache method.
        "cache" : {
            "mode" : "general", // general | user | off | post_type
            "post_types" : ["my-cpt"], // Define depency on post types: block's cache is purged when these are updated.
        },
        // Ensure a module gets loaded with the block.
        "dependencies" : {
            "scripts" : [ "wp-element", "wp-i18n" ],
            "styles" : [ ]
        }
    },
```

All Eternia specific modifications live under the key **eternia**. We have separated our block logic below its own key, to avoid conflicts with core and plugin code. It should also improve code legibility. The eternia object (Eternia's block API) is localized to editor, and more importantly also accessible in render callback. It should be noted that the API is saved for the block type and not the block instance, so any updates to the API will affect all instances of the block - even those previously saved to the database.

By default, all blocks are cached. This means that for every page, the block is rendered only once, and from then on served from the object cache. If the block includes user specific data, you may wish to set the cache mode to **user**. This will cache the block instance for each user, and serve it from the object cache. If you wish to disable caching entirely, set the mode to **off**. The last option is highly discouraged, as it will cause the block to be rendered on every page load.

### Eternia autopopulates

Setting every key for every block can get a tiny bit tedious, so we have automated some of the core keys. Namely scripts and styles need not be set in block.json -file, though you absolutely can if you want more control. By default we will load the viewscript and block styles, if a file with the block slug exists in set folders.

```JSON
    {
        "style" : "cta.css",     // build/css/$env/blocks-acf/cta.css
        "viewScript" : "cta.js", // build/js/$env/blocks-acf/cta.js
        "icon" : "cta.svg",      // build/img/block-icons/cta.svg
    }
```

Advanced custom fields (ACF) plugin settings for preview and rendering are included by default. The render callback is shared for all blocks, and takes care of block instance caching, so it should not usually be altered. Mode will set the acf field behaviour so that it will render a preview of blocks in editor block flow, but open the fields for currently focused block. Project specific default behaviour can modified at `add_acf_block_defaults` function, whereas block specific behaviour can be set in block.json.
```JSON
    "acf" : {
        "mode" : "auto", 
        "renderCallback": "Eternia\\render_acf_block",
    },
```

### Stylesheets

Because each block's SCSS file will be compiled independently, Eternia's SCSS tooling should be imported in the beginning of the file using `app/sass/loaders/_scss-tooling-import.scss` file. This file contains only SCSS tooling, and doesn't generate any CSS itself, but makes it possible to use Eternia's SCSS mixins inside block's SCSS file. Therefore, first line of block's SCSS file should be:

```
@import "../../../app/sass/loaders/scss-tooling-import";
```

### Preview image

Block's preview view in editor can be rendered based on a screenshot preview image. Preview image should be named as `preview.png` and placed inside blocks folder, e.g. `acf-blocks/my-block/preview.png`. If preview file is included, it will be processed and copied to `build/img/block-preview/` and placed into a subfolder with folder block's slug, e.g. `build/img/block-preview/my-block/preview.png` . As a part of block's registration process, if preview image is found from this location, it will be used for generating preview.

Note. Including `preview.png` will override dynamic preview rendering defined in `block.json` file. It is a good practice to include `preview.png` only if dynamic preview rendering is not feasible, e.g. with blocks that include complicated acf-repeater fields etc.