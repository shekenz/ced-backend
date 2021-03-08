const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
	darkMode: 'class',
    purge: {
		content: ['./storage/framework/views/*.php', './resources/views/**/*.blade.php'],
		options: {
			safelist: ['black-square', 'dark'],
		},
	},

    theme: {
        extend: {
            fontFamily: {
                sans: ['Monument Grotesk', 'Nunito', ...defaultTheme.fontFamily.sans],
				dashboard: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
			fontSize: {
				custom: ['1.1em', '1.2em'],
				'custom-md': ['0.8em', '1.1em'],
			},
			colors: {
				dark: colors.gray,
			},
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};