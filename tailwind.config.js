const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
	darkMode: 'class',
	mode: 'jit',
    purge: {
		content: [
			'./storage/framework/views/*.php',
			'./resources/views/**/*.blade.php',
			'./safelist.txt'
		],
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
			},
			colors: {
				dark: colors.gray,
				green: {
					pale: 'rgb(144, 255, 134)',
				}
			},
			cursor: {
				grab: 'grab',
			}
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
			display: ['dark'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};