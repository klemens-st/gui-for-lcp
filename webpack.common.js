const path = require('path');
const ESLintPlugin = require('eslint-webpack-plugin');

module.exports = {
    entry: './gui-for-lcp/admin/assets/js/admin.js',

    output: {
        filename: 'admin.js',
        path: path.resolve(__dirname, 'gui-for-lcp/admin/assets/js/dist'),
        clean: true,
    },

    plugins: [
        new ESLintPlugin(),
    ],
};
