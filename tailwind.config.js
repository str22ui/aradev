/** @type {import('tailwindcss').Config} */
export default {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontSize: {
                xxs: "9px",
            },
            backgroundColor: {
                primary: "#4883B2",
                utama: "#6256CA",
                primaryDark: "#B48C5E",
                primaryLight: "#ECDBC9",
                landingMenu: "#FFFAF3",
            },
            colors: {
                primary: "#0C609E",
                primaryDark: "#B48C5E",
                primaryLight: "#ECDBC9",
                gray1: "#2C2C2C",
                gray2: "#6D6D6D",
                gray3: "#4D4D4D",
                gray4: "#3E3E3E",
                brown1: "#745E3B",
            },
        },
    },
    plugins: [],
  }
