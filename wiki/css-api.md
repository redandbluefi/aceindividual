# Eternia SCSS

There is a high likelihood that Eternia will be split in multiple parts in the near future. These parts will likely be a logical core, a theme to control style definitions, and a block plugin that utilises said style definitions. Some blocks come pre-made as block library components, so they need to be able to rely on style definitions that are unified across all projects. This is what the style API is for.

## Naming conventions

CSS variables are namespaced with 'rnb' as the first element, to prevent conflicts & confusion with other CSS variables. A double undescore follows the namespace, after which a css attribute name is defined. The last component is separated by a double dash, and is the role or function of the variable.

### Simple example

```css
:root {
  --rnb--font-family--paragraph : GT America
}

p {
  font-family: var(--rnb--font-family--paragraph);
}
```

### Assigning variables as variables

A further abstraction is sometimes used, where a variable is assigned another variable. For example color HSL value could be mapped to ```--color--red: hsl(23, 23, 10)```, which may be used as ```--color--primary: var(--color--red)```. This is done to allow for a single point of change for a color.

## Role definitions

### Color

Project accent colors are assigned as latinate ordinal numbers.

````css
--color--primary
--color--secondary
--color--tertiary
--color--quaternary
````

Text and background elements are typically named by their role.

````css
--color--text
--color--background
--color--paper
````
