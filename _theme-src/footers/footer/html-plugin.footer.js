const path = require('path');
const HtmlPlugin = require('html-webpack-plugin');

module.exports = 
    new HtmlPlugin({
        template: path.join(__dirname, 'footer.ejs'),
        filename: 'footer.php',
        chunks: []
    });