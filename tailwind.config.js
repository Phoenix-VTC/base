const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                danger: colors.rose,
                primary: colors.orange,
                success: colors.green,
                warning: colors.yellow,
            },
        },
    },
    variants: {},
    purge: {
        content: [
            './app/**/*.php',
            './resources/**/*.html',
            './resources/**/*.js',
            './resources/**/*.jsx',
            './resources/**/*.ts',
            './resources/**/*.tsx',
            './resources/**/*.php',
            './resources/**/*.vue',
            './resources/**/*.twig',
            './storage/framework/views/*.php',
            './vendor/razorui/blade-application-ui/resources/views/components/**/*.blade.php',
            './vendor/wire-elements/modal/resources/views/*.blade.php',
            './vendor/filament/forms/resources/views/**/*.blade.php',
        ],
        options: {
            defaultExtractor: (content) => content.match(/[\w-/.:]+(?<!:)/g) || [],
            whitelistPatterns: [/-active$/, /-enter$/, /-leave-to$/, /show$/],
            safelist: [
                'sm:max-w-2xl'
            ]
        },
    },
    plugins: [
        require('@tailwindcss/ui'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/forms'),
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/line-clamp')
    ],
};
