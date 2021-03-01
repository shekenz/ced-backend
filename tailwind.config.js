const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: ['./storage/framework/views/*.php', './resources/views/**/*.blade.php'],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Monument Grotesk', 'Nunito', ...defaultTheme.fontFamily.sans],
				dashboard: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
			fontSize: {
				custom: ['1.1em', '1.2em'],
			}
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};