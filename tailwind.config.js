/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: ["class"],
    content: [
        "app/**/*.{ts,tsx}",
        "components/**/*.{ts,tsx}",
        "*.{js,ts,jsx,tsx,mdx}",
        "./templates/**/*.{html,twig}",
        "./assets/**/*.{js,jsx,ts,tsx,vue}",
        "./src/Form/**/*.php"  // Pour les formulaires Symfony générés
    ],
    theme: {
        container: {
            center: true,
            padding: "2rem",
            screens: {
                "2xl": "1400px",
            },
        },
        extend: {
            fontFamily: {
                sans: ['Space Grotesk', 'sans-serif'],
                mono: ['JetBrains Mono', 'monospace'],
            },
            keyframes: {
                shimmer: {
                    "0%": { backgroundPosition: "200% 50%" },
                    "100%": { backgroundPosition: "-200% 50%" },
                },
            },
            animation: {
                shimmer: "shimmer 8s ease-in-out infinite",
            },
            colors: {
                border: "hsl(var(--border))",
                input: "hsl(var(--input))",
                ring: "hsl(var(--ring))",
                background: '#0B0C0E',
                foreground: "hsl(var(--foreground))",
                primary: '#8564FA',
                secondary: {
                    DEFAULT: "hsl(var(--secondary))",
                    foreground: "hsl(var(--secondary-foreground))",
                },
                destructive: {
                    DEFAULT: "hsl(var(--destructive))",
                    foreground: "hsl(var(--destructive-foreground))",
                },
                muted: {
                    DEFAULT: "hsl(var(--muted))",
                    foreground: "hsl(var(--muted-foreground))",
                },
                accent: {
                    DEFAULT: "hsl(var(--accent))",
                    foreground: "hsl(var(--accent-foreground))",
                },
                popover: {
                    DEFAULT: "hsl(var(--popover))",
                    foreground: "hsl(var(--popover-foreground))",
                },
                card: {
                    DEFAULT: "hsl(var(--card))",
                    foreground: "hsl(var(--card-foreground))",
                },
            },
        },
    },
    plugins: [
        require("tailwindcss-animate"),
        require('@tailwindcss/forms')  // Optionnel, pour de meilleurs styles de formulaires
    ],
}
