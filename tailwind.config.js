/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                manrope: ["Manrope", "sans-serif"],
                poppins: ["Poppins", "sans-serif"],
                notosans: ["Noto Sans", "sans-serif"],
            },
            colors: {
                primary: "#3B82F6",
                secondary: "#8B5CF6",
                accent: "#F59E0B",
                success: "#10B981",
                danger: "#EF4444",
                warning: "#F59E0B",
                info: "#3B82F6",
                dark: "#1F2937",
                light: "#F3F4F6",
            },
        },
    },
    plugins: [],
};
