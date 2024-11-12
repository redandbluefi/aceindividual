/*
Helper function for retrieving the numeric value of a CSS variable.
@param {object} args An object containing the name and unit of the CSS variable.
@returns {number|null} The numeric value of the CSS variable, or null if the variable is not found.
*/
function getCssVariableValue(args) {
  const { name, unit } = args;
  const variable = getComputedStyle(
    document.documentElement,
  ).getPropertyValue(name);
  return variable ? +variable.replace(unit, '') : null;
}

export default getCssVariableValue;
