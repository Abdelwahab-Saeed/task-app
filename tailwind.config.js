import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#f0fdfc',
          100: '#ccfbf8',
          200: '#99f6f0',
          300: '#5eeee5',
          400: '#3fa9a6',
          500: '#3fa9a6',
          600: '#2d8b89',
          700: '#1f6b6a',
          800: '#155554',
          900: '#0e4544',
          950: '#062827',
        },
        dark: {
          bg: '#0F1117',
          card: '#22252E',
          sidebar: '#0A0D12',
          border: '#1F2228',
          hover: '#1A1D24',
        },
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
      },
    },
  },
  plugins: [],
  darkMode: 'class',
};
