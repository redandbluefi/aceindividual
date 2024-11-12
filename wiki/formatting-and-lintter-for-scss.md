# SCSS Formatting and Linting

The Eternia base theme includes StyleLint for SCSS linting. The StyleLint configuration is located in the `.stylelintrc.json` file.

## How to use Stylelint

1. Install Stylelint (https://marketplace.visualstudio.com/items?itemName=stylelint.vscode-stylelint) VS Code Extension: This was added to the recommended extensions in this file (.vscode/extensions.json).

### Manually

1. Run `npm install` to install all necessary node modules including StyleLint.
2. Use the command `npx stylelint [file-name.scss]` to lint a specific SCSS file.

### Automatically with Visual Studio Code (VS Code)

To automate the code formatting process, we recommend setting up your Visual Studio Code editor with specific settings for StyleLint. These settings will ensure that your SCSS code is automatically formatted on save and is in line with our project's coding standards.

#### Setting Up VS Code

1. Open Visual Studio Code.
2. Access the settings by either:
   - Using the shortcut `Ctrl + ,` (or `Cmd + ,` on Mac).
   - Clicking on `File > Preferences > Settings`.
3. In the search bar at the top of the Settings tab, type `settings`.
4. Click on the link to `Edit in settings.json` found at the top of the search results.
5. Add the following configuration to your `settings.json` file:

   ```json
   {
     // Eternia SCSS/CSS-linter
     "css.validate": false,
     "less.validate": false,
     "scss.validate": false,
     "editor.formatOnSave": true,
     "editor.codeActionsOnSave": {
       "source.fixAll.stylelint": "always",
       "source.sortImports": "always"
     },
     "files.autoSaveDelay": 500,
     "stylelint.config": null,
     "stylelint.validate": ["scss"]
   }
   ```

Now, with these settings, your SCSS code should automatically format according to the StyleLint rules when you save a file. StyleLint will also fix many common issues automatically, but you may need to address some linting errors manually.

#### StyleLint Configuration

The StyleLint configuration for the project can be found in the `.stylelintrc.json` file at the root of the project.

Project team can modify the rules as per the project’s needs when strictly necessary, keeping in mind the overall consistency and coding standards. If it is not broken, don't fix it.

#### About the .stylelintrc.json configuration file:

`.stylelint-config-standard-scss` is a shared config that the stylelint-scss recommends to use.
`.stylelint-config-recess-order` is a config that sorts CSS properties to the desired order. Seems to be the most popular ordering config at the moment (e.g., used by Recess and Bootstrap). Not necessary and can be left out.

- rules determine what the linter looks for and complains about. Current config is not finished and is simply filled with rules that were found necessary.

## Conclusion

By following these steps, you ensure that your SCSS files are linted and formatted according to the project’s standards, improving code consistency and quality across the team.

If you have any questions or run into issues, feel free to consult the Stylelint documentation or reach out to the development team for assistance.
