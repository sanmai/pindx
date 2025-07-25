export default [
    {
        ignores: ["eslint.config.*"]
    },
    {
        languageOptions: {
            ecmaVersion: 2020,
            sourceType: "script",
            globals: {
                window: "readonly",
                document: "readonly",
                console: "readonly",
                fetch: "readonly"
            }
        },
        rules: {
            "no-undef": "error",
            "no-unused-vars": "warn",
            "no-console": "off"
        }
    }
];
