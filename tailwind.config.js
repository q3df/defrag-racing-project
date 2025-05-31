import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
                typography: (theme) => ({
                    DEFAULT: {
                    css: {
                        '--tw-prose-body': '#d1d5db',
                        '--tw-prose-headings': '#ffffff',
                        '--tw-prose-lead': '#9ca3af',
                        '--tw-prose-links': '#eeeeee',
                        '--tw-prose-bold': '#ffffff',
                        '--tw-prose-counters': '#9ca3af',
                        '--tw-prose-bullets': '#373737',
                        '--tw-prose-hr': '#374151',
                        '--tw-prose-quotes': '#f3f4f6',
                        '--tw-prose-quote-borders': '#374151',
                        '--tw-prose-captions': '#9ca3af',
                        '--tw-prose-kbd': '#ffffff',
                        '--tw-prose-kbd-shadows': '255 255 255',
                        '--tw-prose-code': '#f3f4f6',
                        '--tw-prose-pre-code': '#d1d5db',
                        '--tw-prose-pre-bg': '#000000',
                        '--tw-prose-th-borders': '#4b5563',
                        '--tw-prose-td-borders': '#374151',

                        'h2, h3, h4': {
                            color: theme('colors.white'),
                        },
                        'a:hover': {
                            color: theme('colors.white'),
                        },
                    },
                },
            }),

            borderWidth: {
                '1': '1px',
            },

            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            screens: {
                'hmd': '500px',
                'xxs': '370px'
            },
            width: {
                '100': '600px'
            },
            maxWidth: {
                '8xl': '90rem',
            },
            colors: {
                grayop: {
                    '100': '#1B232F',
                    '200': '#37415130',
                    '300': '#37415160',
                    '400': '#37415190',
                    '500': '#374151B0',
                    '600': '#374151F0',
                    '700': '#37415150',
                    '800': '#1f293780',
                    '900': '#11182760',
                    '1000': '#111827'
                },
                blackop: {
                    '20': '#00000020',
                    '30': '#00000030',
                    '50': '#00000050',
                    '80': '#00000080'
                }
            }
        },
    },

    plugins: [
        forms,
        typography,
        function ({ addUtilities }) {
            const newUtilities = {
                '.bg-fit': {
                    'background-repeat': 'no-repeat',
                    'background-size': '100% 100%',
                },
            };
            addUtilities(newUtilities, ['responsive', 'hover']);
        }
    ],
};
