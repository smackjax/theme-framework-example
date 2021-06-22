const {dirname, join} = require('path');
// Path to build folder
const buildPath = join(__dirname, '../', '../', '../');

module.exports = ()=>({
    // Path to assets on build
    path: buildPath,
    filename: './js/[name].script.js',
    publicPath: '/wp-content/themes/jedwardkruft-theme',
});
