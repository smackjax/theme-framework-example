// const entryPoints = require('../../_webpack.output-chunks.js');

const path = require('path');
const checkForFileNames = require('../check-for-filenames');

// Finds all chunk files
const chunkFilePrefix = 'webpack-chunk';

var foundChunks = {};
function onChunkFileFound(fullChunkPath, filename) {
    // Split prefix flag from 
    var filenameParts = filename.split('.');
    // Check for correct split array length
    if (filenameParts.length < 3 || filenameParts[2] !== 'js' ) { 
        console.log('!!Found file with correct prefix, but was incorrectly formatted: ', filename);
        console.log('!!Chunk file naming format is (prefix).(chunk-name).js');
    } else {
        // Extract chunk name from file name
        var chunkName = filenameParts[1];
        // Adds chunk with correct name and path to chunk object
        foundChunks[chunkName] = fullChunkPath;
    }
    
}
// Start recursion
checkForFileNames(path.join(__dirname, '../', '../'), chunkFilePrefix, onChunkFileFound);


module.exports = ()=>({
    // Easier to do this way rather than use the magic prefix
    'imagesIndex': path.resolve(__dirname, '../', '../', 'images', 'index'),
    ...foundChunks
});