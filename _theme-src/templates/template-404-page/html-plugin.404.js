const path = require('path');
const HtmlPlugin = require('html-webpack-plugin');

module.exports = 
    new HtmlPlugin({
        template: path.join(__dirname, '404.ejs'),
        filename: './404.php',
        chunks: []
    });