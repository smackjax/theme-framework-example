const path = require('path');
const HtmlPlugin = require('html-webpack-plugin');

module.exports = 
    new HtmlPlugin({
        template: path.join(__dirname, 'header-common-head-scripts.ejs'),
        filename: 'header-common-head-scripts.php',
        chunks: []
    });