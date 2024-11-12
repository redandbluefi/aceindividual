# JavaScript Formatting and Linting

The Eternia base theme includes ESLint for JavaScript linting. The ESLint configuration is located in the `.eslintrc.js` file.

Linting is based on the Airbnb JavaScript Style Guide with custom adjustments to fit the Eternia theme's requirements.

## Using the Linter

- ESLint is integrated into the build process, but you can also run it manually to check for issues in your JavaScript code.
- To use the linter manually:
  1. Run `npm install` to install all necessary node modules including ESLint.
  2. Use the command `npx eslint [file-name.js]` to lint a specific JavaScript file.

## Formatting Code

### With Visual Studio Code (VS Code)

- To automate the code formatting process, we recommend setting up your Visual Studio Code editor with specific settings for ESLint.
- These settings will ensure that your JavaScript code is automatically formatted on save and is in line with our project's coding standards.
- Follow these steps to configure your VS Code for JavaScript formatting:

  #### Setting Up VS Code

  1. Open Visual Studio Code.
  2. Access the settings by either:
     - Using the shortcut `Ctrl + ,` (or `Cmd + ,` on Mac).
     - Clicking on `File > Preferences > Settings`.
  3. In the search bar at the top of the Settings tab, type `settings`.
  4. Click on the link to `Edit in settings.json` found at the top of the search results.
  5. Add the following configuration to your `settings.json` file:

     ```
     "editor.formatOnSave": false,
     "editor.codeActionsOnSave": {
       "source.fixAll.eslint": "always",
       "source.sortImports": "always",
     }
     ```

  6. Save the `settings.json` file and restart VS Code.

- Now, with these settings, your JavaScript code should automatically format according to the ESLint rules when you save a file.
- ESLint will also fix many common issues automatically, but you may need to address some linting errors manually.

### ESLint Configuration

- The ESLint configuration for the project can be found in the `.eslintrc.js` file at the root of the project.

- If you are using Vue.js 2.x. add this to your `.eslintrc.js` file:

  ```
   extends: [
    ...,
    'plugin:vue/recommended',
  ],

  ```

- Feel free to review and modify the ESLint rules as per the project's needs, keeping in mind the overall consistency and coding standards.
