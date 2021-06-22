const path = require('path');
const HtmlPlugin = require('html-webpack-plugin');

module.exports = 
    new HtmlPlugin({
        template: path.join(__dirname, 'functions.php'),
        filename: 'functions.php',
        // functions.php doesn't need chunks added
        inject: false,
        minify: false,
    });