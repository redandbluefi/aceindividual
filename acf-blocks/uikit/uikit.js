document.addEventListener('DOMContentLoaded', () => {

  const uikit = document.querySelector('[data-block="uikit"]');
  const moduleTypography = uikit.querySelector('#uikit-typography');
  const moduleColors = uikit.querySelector('#uikit-colors');

  if (moduleTypography) {
      initTypography();
  }

  if (moduleColors) {
      initColors();
  }



  /**
   * Locates typography items and appends relevant meta to them.
   */
  function initTypography() {

      const headingsWrapper = moduleTypography.querySelector('.typography__headings');
      const paragraphsWrapper = moduleTypography.querySelector('.typography__paragraphs');
      const extrasWrapper = moduleTypography.querySelector('.typography__extra');

      // If wrapper is found, select children.
      const headings = headingsWrapper ? headingsWrapper.querySelectorAll('*') : false;
      const paragraphs = paragraphsWrapper ? paragraphsWrapper.querySelectorAll('p') : false;
      const extras = extrasWrapper ? extrasWrapper.querySelectorAll('*') : false;


      if (headings.length > 0) {
          headings.forEach(item => addTypographyMeta(item));
      }

      if (paragraphs.length > 0) {
          paragraphs.forEach(item => addTypographyMeta(item));
      }

      if (extras.length > 0) {
          extras.forEach(item => addTypographyMeta(item));
      }

      // Add event listeners for resizing window.
      window.addEventListener('resize', () => {

          if (headings.length > 0) {
              headings.forEach(item => updateTypographyMeta(item));
          }
  
          if (paragraphs.length > 0) {
              paragraphs.forEach(item => updateTypographyMeta(item));
          }
  
          if (extras.length > 0) {
              extras.forEach(item => updateTypographyMeta(item));
          }
      });
      
  }

  /**
   * Find all Eternia color variables, and creates a list of them.
   * 
   * This crawls through all stylesheets and finds any variables
   * targeted to the document root element itself. If the variable
   * matches "--rnb--color-" it is added to the list.
   * 
   */
  function initColors() {

      const sheets = document.styleSheets;
      let baseColors = [];
      let functionalColors = [];

      // Loop all stylesheets, find and list --rnb--color- variables. 
      for (let i = 0; i < sheets.length; i++) {
          for (let j = 0; j < sheets[i].cssRules.length; j++) {
              if (sheets[i].cssRules[j].selectorText === ":root") {
                  for (let k = 0; k < sheets[i].cssRules[j].style.length; k++) {
                      if ( sheets[i].cssRules[j].style[k].startsWith("--color-") ) {
                          
                          const colorDefinition = window.getComputedStyle(document.documentElement).getPropertyValue(sheets[i].cssRules[j].style[k]);
                          const colorName = sheets[i].cssRules[j].style[k];

                          baseColors.push({name: colorName, value: colorDefinition});
                      } else if ( sheets[i].cssRules[j].style[k].startsWith("--rnb--color-") ) {
                          
                          const colorDefinition = window.getComputedStyle(document.documentElement).getPropertyValue(sheets[i].cssRules[j].style[k]);
                          const colorName = sheets[i].cssRules[j].style[k];

                          functionalColors.push({name: colorName, value: colorDefinition});
                      }
                  }
              }
          }
      }

      const baseColorsWrapper = moduleColors.querySelector('.uikit__colors--base');
      const functionalColorsWrapper = moduleColors.querySelector('.uikit__colors--functional');

      baseColors.forEach(color => {

          const colorItem = createColorItem(color);
          baseColorsWrapper.appendChild(colorItem);
      });

      functionalColors.forEach(color => {

        const colorItem = createColorItem(color);
        functionalColorsWrapper.appendChild(colorItem);
    });

  }
      
      
});

function createColorItem(color) {
    // Construct elements.
    const colorItem = document.createElement('div');
    colorItem.classList.add('color-item');

    const colorSwatch = document.createElement('div');
    colorSwatch.classList.add('color-item__swatch');
    colorSwatch.style.backgroundColor = color.value;

    const colorMeta = document.createElement('div');
    colorMeta.classList.add('color-item__data');

    const metaVariable = document.createElement('div');
    metaVariable.classList.add('color-item__meta');

    const metaDefinition = document.createElement('div');
    metaDefinition.classList.add('color-item__meta');

    const variableTitle = document.createElement('p');
    variableTitle.classList.add('color-meta__title');
    variableTitle.innerText = 'Variable';

    const variableValue = document.createElement('p');
    variableValue.classList.add('color-meta__value');
    variableValue.innerText = color.name;

    const definitionTitle = document.createElement('p');
    definitionTitle.classList.add('color-meta__title');
    definitionTitle.innerText = 'Definition';

    const definitionValue = document.createElement('p');
    definitionValue.classList.add('color-meta__value');
    definitionValue.innerText = color.value;

    // Append elements.
    metaVariable.appendChild(variableTitle);
    metaVariable.appendChild(variableValue);
    metaDefinition.appendChild(definitionTitle);
    metaDefinition.appendChild(definitionValue);
    colorMeta.appendChild(metaVariable);
    colorMeta.appendChild(metaDefinition);
    colorItem.appendChild(colorSwatch);
    colorItem.appendChild(colorMeta);

    return colorItem;
}


/**
* Appends metadata after a typography class item.
* 
* Supports defering the meta by adding the class `defer-meta
* to the element. This is so you can add more context within
* the wrapper if needed. Just add the class and this script
* won't touch it no more.
* 
* @param {HTMLElement} element The element to add the meta for
* @returns {void} Appends the meta after the element on DOM.
*/
function addTypographyMeta(element) {

  if (element.classList.contains('defer-meta')) {
      return;
  }

  const meta = document.createElement('div');
  meta.classList.add('typography-meta');

  const fontSize = window.getComputedStyle(element).fontSize;
  const lineHeight = window.getComputedStyle(element).lineHeight;
  const fontWeight = window.getComputedStyle(element).fontWeight;
  const fontFamily = window.getComputedStyle(element).fontFamily.split(',')[0];
  const letterSpacing = window.getComputedStyle(element).letterSpacing;
  const tagName = element.tagName;

  meta.innerHTML = `
      <p class="typography-meta__item">Element: <b>${tagName}</b></p>
      <p class="typography-meta__item">Font family: <b>${fontFamily}</b></p>
      <p class="typography-meta__item">Font size: <b>${fontSize}</b></p>
      <p class="typography-meta__item">Line height: <b>${lineHeight}</b></p>
      <p class="typography-meta__item">Font weight: <b>${fontWeight}</b></p>
      <p class="typography-meta__item">Letter spacing: <b>${letterSpacing}</b></p>
  `;

  element.after(meta);
  
}

function updateTypographyMeta(element) {
  const meta = element.nextSibling;
  const fontSize = window.getComputedStyle(element).fontSize;
  const lineHeight = window.getComputedStyle(element).lineHeight;
  const fontWeight = window.getComputedStyle(element).fontWeight;
  const fontFamily = window.getComputedStyle(element).fontFamily.split(',')[0];
  const letterSpacing = window.getComputedStyle(element).letterSpacing;
  const tagName = element.tagName;

  meta.innerHTML = `
      <p class="typography-meta__item">Element: <b>${tagName}</b></p>
      <p class="typography-meta__item">Font family: <b>${fontFamily}</b></p>
      <p class="typography-meta__item">Font size: <b>${fontSize}</b></p>
      <p class="typography-meta__item">Line height: <b>${lineHeight}</b></p>
      <p class="typography-meta__item">Font weight: <b>${fontWeight}</b></p>
      <p class="typography-meta__item">Letter spacing: <b>${letterSpacing}</b></p>
  `;

  element.after(meta);
  
}