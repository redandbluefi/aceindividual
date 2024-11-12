## Mobile menu accessibilty with mobile device screen readers 

In Eternia, the mobile menu opens as a Dialog element. A javascript focustrap solution has been made for the dialog, which prevents the user from advancing to the content of the page from within the mobile menu. This solution uses the keydown EventListener function, which screen readers on mobile devices cannot listen to, as they are used by swiping the screen. This means that when using a screen reader, the user moves from the last element of the mobile menu to the content, while the mobile menu remains open over the content.

Screen readers on mobile devices move down the DOM structure in order, as the user swipes forward. Because of this, the mobile menu dialog has been moved below the header element.
Screen readers only ignore elements with the `aria-hidden=true` attribute. 
Note! If inside an element with the `aria-hidden=true` attribute, there are elements with the `aria-hidden=false` attribute, the screen reader can advance to these elements.

As an improvement to the mobile menu use, the `aria-hidden=false` attribute has been added by default to the skip-to-content link, site-branding logo, site-content, footer and back-to-top button.

The `handleHiddenAttributes()` function has been added to the navigation.js file, which checks the previously mentioned element's aria-hidden and inert value when the dialog is opened and closed.

These actions cause the screen reader on mobile devices to not be able to move to the content while the mobile menu is open. The user can only move back and forth within the navigation and access the browser buttons.

These measures do not change the functionality of the current keyboard-based foctrap.

### What to do?
So in practice, whenever you make some kind of modal that opens on top of the content, you should take these similar measures to hide the rest of the content from the user.
