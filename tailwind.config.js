module.exports = {
    purge: [
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            fontFamily: {
                sans: ['Fredoka', 'sans-serif'],
            },
        },
    },
    variants: {
        extend: {
            borderWidth: ['hover', 'active'],
            textDecoration: ['responsive', 'hover', 'focus', 'group-hover'],
            fontWeight: ['hover', 'focus', 'active'],
            outline: ["focus"],
            display: ["group-hover"],
            backgroundColor: ['even', 'active']

        },
    },
    plugins: [
        require('daisyui'),
    ],
    corePlugins: {
        outline: false,
    }
}