module.exports = {
    purge: {
        enabled: !process.env.ROLLUP_WATCH,
        mode: "all",
        content: ["./**/**/*.html", "./**/**/*.svelte"],

        options: {
            whitelistPatterns: [/svelte-/],
            defaultExtractor: (content) =>
                [...content.matchAll(/(?:class:)*([\w\d-/:%.]+)/gm)].map(
                    ([_match, group, ..._rest]) => group
                ),
        },
    },
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: "#009688",
                    dark: "#00796B",
                    light: "#B2DFDB",
                },
                accent: {
                    DEFAULT: "#FF5722",
                },
            },
        },
    },
    variants: {
        extend: {},
    },
    plugins: [],
};
