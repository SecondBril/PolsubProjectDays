import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import plugin from 'tailwindcss/plugin';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                mono: ['JetBrains Mono', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                navy: {
                    50: '#EEF2F7',
                    100: '#D9E2EC',
                    200: '#B9C8DA',
                    300: '#90A8C2',
                    400: '#5B7A9E',
                    500: '#3C5C80',
                    600: '#2C4A6E',
                    700: '#203A57',
                    800: '#172A43',
                    900: '#101D30',
                    950: '#0F1829',
                },
                teal: {
                    600: '#0B8C8F',
                    500: '#0EA5A8',
                    100: '#DFF5F4',
                    50: '#F0FBFA',
                },
                surface: '#F7F8FA',
                panel: '#FFFFFF',
                borderSoft: '#EFF1F4',
                textCustom: {
                    900: '#16233D',
                    600: '#5B6478',
                    400: '#94A0B4',
                }
            },
            borderRadius: {
                'admin-sm': '8px',
                'admin-md': '12px',
                'admin-lg': '16px',
            },
            boxShadow: {
                'admin-sm': '0 1px 2px rgba(16,23,42,0.04), 0 1px 1px rgba(16,23,42,0.03)',
                'admin-md': '0 4px 14px rgba(16,23,42,0.06), 0 1px 3px rgba(16,23,42,0.04)',
                'card': '0 1px 2px 0 rgb(16 29 48 / 0.04)',

            },
            spacing: {
                'sidebar': '264px',
            }
        },
    },

    plugins: [
        forms,
        plugin(function({ addComponents, addUtilities }) {
            // 1. Memasukkan kelas komponen kustom
            addComponents({
                '.btn-primary': {
                    display: 'inline-flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    gap: '0.5rem',
                    borderRadius: '0.5rem',
                    backgroundColor: '#172A43', // Menggunakan warna navy.800
                    padding: '0.625rem 1.25rem',
                    fontSize: '0.875rem',
                    fontWeight: '600',
                    color: '#fff',
                    transition: 'all 0.15s',
                    '&:hover': {
                        backgroundColor: '#203A57', // Menggunakan warna navy.700
                    },
                },
                '.btn-outline': {
                    display: 'inline-flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    gap: '0.5rem',
                    borderRadius: '0.5rem',
                    border: '1px solid #cbd5e1',
                    backgroundColor: '#fff',
                    padding: '0.625rem 1.25rem',
                    fontSize: '0.875rem',
                    fontWeight: '600',
                    color: '#334155',
                    transition: 'all 0.15s',
                    '&:hover': {
                        backgroundColor: '#f8fafc',
                    },
                },
                '.badge': {
                    display: 'inline-flex',
                    alignItems: 'center',
                    gap: '0.25rem',
                    borderRadius: '9999px',
                    padding: '0.25rem 0.65rem',
                    fontSize: '0.75rem',
                    fontWeight: '600',
                },
                '.card': {
                    borderRadius: '0.75rem',
                    border: '1px solid #e2e8f0',
                    backgroundColor: '#fff',
                    // Memanggil konfigurasi shadow khusus yang didefinisikan di atas
                    boxShadow: '0 1px 2px 0 rgb(16 29 48 / 0.04)',
                },
            });

            // 2. Memasukkan utilitas khusus seperti x-cloak milik Alpine.js
            addUtilities({
                '[x-cloak]': {
                    display: 'none !important',
                },
            });
        }),
    ],
};


