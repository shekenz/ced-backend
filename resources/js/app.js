require('./bootstrap');

require('alpinejs');

// Import TinyMCE
const tinymce = require('tinymce/tinymce');

// Default icons are required for TinyMCE 5.3 or above
require('tinymce/icons/default');

// A theme is also required
require('tinymce/themes/silver');

// Initialize the app
tinymce.init({
    selector: '#tiny',
});