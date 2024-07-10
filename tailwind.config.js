/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./App/**/*.{php, html, js}"],
  theme: {
    extend: {},
  },
  plugins: [require("tailwind-gradient-mask-image")],
}
