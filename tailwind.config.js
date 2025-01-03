/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    safelist: [
        'top-[57px]', // 57px header height for aura & nora theme
        'lg:pt-[57px]',
        'top-[61px]', // 61px header height for lara theme
        'lg:pt-[61px]',
        'top-[64px]', // 64px header height for material theme
        'lg:pt-[64px]',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'sans-serif'],
            },
        },
    },
    plugins: [require('postcss-import'), require('tailwindcss-primeui')],
    darkMode: ['selector'],
};
