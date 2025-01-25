/** @type {import('tailwindcss').Config} */
module.exports = {
  purge: ["./public/**/*.{html,js,php}"],
  content: ["./public/**/*.{html,js,php}",
    "./public/includes/*.{html,js,php}",
    'node_modules/preline/dist/*.js'],
  
  darkMode: 'class',
  theme: {
    extend: {
      fontFamily: {
        nunito: ["Nunito", "sans-serif"],
        poppins: ["Poppins", "sans-serif"],
      },
      colors: {
        background: "rgba(var(--background))",
        whitetext: "rgba(var(--whitetext))",
        graytext: "rgba(var(--graytext))",
        whiteground: "rgba(var(--whiteground))",
        buttondark: "rgba(var(--buttondark))",
        blackcol: "rgba(var(--blackcol))",
        primary: {"50":"#eff6ff","100":"#dbeafe","200":"#bfdbfe","300":"#93c5fd","400":"#60a5fa","500":"#3b82f6","600":"#2563eb","700":"#1d4ed8","800":"#1e40af","900":"#1e3a8a","950":"#172554"},
      }
    },
  },
  plugins: [
    require('daisyui'),
    require('preline/plugin'),
    require('@tailwindcss/forms'),
  ],
  daisyui: {
    themes:["light","black"],
  },
};
