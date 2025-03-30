const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                dental: {
                    primary: '#3490dc', // Example color for primary
                    secondary: '#ffed4a', // Example color for secondary
                    accent: '#e3342f', // Example color for accent
                    bg: '#f8fafc', // Example background color
                },
                mint: {
                    50: '#f3faf7',
                    100: '#e6f5ee',
                    200: '#ccf2e9',
                    500: '#38b2ac',
                },
            },
        },
    },
    plugins: [],
};