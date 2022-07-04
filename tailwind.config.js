const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php', 
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: { 
                
                danger: '#ff5252',
                primary: '#2196f3',
            }, 
            height: {
                '128': '32rem',
                '192': '48rem',
                '256': '64rem',
            },
            width: {
                '128': '32rem',
                '192': '48rem',
                '256': '64rem',
            },
            maxWidth: {
                '128': '32rem',
                '192': '48rem',
                '256': '64rem',
            },
        
            
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
