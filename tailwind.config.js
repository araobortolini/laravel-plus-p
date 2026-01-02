import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                // Cores extraídas do layout PlusPDV
                primary: {
                    DEFAULT: '#2563EB', // Azul Royal (Botões e Títulos) - Matches Tailwind blue-600
                    hover: '#1D4ED8',   // Azul mais escuro para hover - Matches Tailwind blue-700
                    light: '#EFF6FF',   // Fundo bem claro - Matches Tailwind blue-50
                },
                sidebar: {
                    DEFAULT: '#172554', // Azul Marinho Profundo (Barra Lateral) - Matches Tailwind blue-950
                    hover: '#1E3A8A',   // Azul ligeiramente mais claro para hover na sidebar
                    active: '#FFFFFF',  // Fundo do item ativo (Branco)
                    text: '#93C5FD',    // Texto inativo (Azul claro acinzentado)
                }
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};