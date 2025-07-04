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
                primarylight: "#cffafe", // cyan-100
                primary: "#0891b2", // cyan 600
                primarydark: "#164e63", // cyan 800
                success: "#22c55e", // green 500
                successlight: "#dcfce7", // green 100
                successdark: "#166534", // green 800
                warninglight: "#fef3c7", // amber 100
                warningdark: "#92400e", // amber 800
                warning: "#f59e0b", // amber 500
                danger: "#f43f5e", // rose 500
                dangerlight: "#ffe4e6", // rose 100
                dangerdark: "#9f1239", // rose 800
                dark: "#374151", // gray 700
                darkhover: "#1f2937", // gray 800
                light: "#f9fafb", // gray 50
                lighthover: "#e2e8f0", // gray 100
                muted: "#9ca3af", // gray 400
                info: "#2563eb", // blue 600
                infodark: "#1e40af" // blue 800
            },
        },
    },
    plugins: [],
};
