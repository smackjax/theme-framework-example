const webpack = require('webpack');
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

// Page templates
// const HtmlPlugins = require('../../_webpack.output-files');

// Finds all files with html-plugin exports
const outputFilePrefix = 'html-plugin';
const checkForFileNames = require('../check-for-filenames');
var HtmlPlugins = [];
function onFileFound(fullFilePath) {
    HtmlPlugins.push( require("" + fullFilePath) );
}

// Start recursion
checkForFileNames(path.join(__dirname, '../', '../'), outputFilePrefix, onFileFound);


module.exports = ()=>([
    // Where the css files will be output to, and their names
    new MiniCssExtractPlugin({
        filename: './css/[name].style.css',
        chunkFilename: './css/[name].style.css',
    }),

 
    // ======= HTML pages ===========
    ...HtmlPlugins
])