const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: {
		content: ['./storage/framework/views/*.php', './resources/views/**/*.blade.php'],
		options: {
			safelist: ['black-square'],
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