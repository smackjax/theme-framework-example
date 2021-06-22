const path = require('path');
const HtmlPlugin = require('html-webpack-plugin');

module.exports = 
    new HtmlPlugin({
        template: path.join(__dirname, 'single.ejs'),
        filename: 'single.php',
        chunks: []
    });