/* ========== THEME CHUNK FILES ============ */
// This file searches for all the Webpack project chunks
// On build(or server start) this file looks for any files with "webpack-chunk."(or a custom prefix) and adds them to the Webpack "entry-points" object.
// IMPORTANT: The chunks name comes from the file, for example (prefix).(chunk-name).js

var path = require('path'); 
fs = require('fs');


var chunkFilePrefix = "webpack-chunk";

var foundChunks = {};

function onChunkFileFound(filename, fullChunkPath) {
    // Split prefix flag from 
    var filenameParts = filename.split('.');
    // Check for correct split array length
    if (filenameParts.length < 3 || filenameParts[2] !== 'js' ) { 
        console.log('!!Found file with correct prefix, but was incorrectly formatted: ', filename);
        console.log('!!Chunk file format is (prefix).(chunk-name).js');
    } else {
        // Extract chunk name from file name
        var chunkName = filenameParts[1];
        // Adds chunk with correct name and path to chunk object
        foundChunks[chunkName] = fullChunkPath;
    }
    
}


// Recursively look for chunk files
// Kudos to Lucio M Tato
// https://stackoverflow.com/a/25462405
function fromDir(startPath, filter){

    if (!fs.existsSync(startPath)){
        console.log("!!Invalid dir while recursively searching for chunks: ", startPath);
        return;
    }

    // Find all files
    var files = fs.readdirSync(startPath);

    for( var i=0; i < files.length; i++){

        var fullFilePath = path.join(startPath,files[i]);
        var filename = files[i];

        var stat = fs.lstatSync(fullFilePath);
        if ( stat.isDirectory() ) {
            fromDir(fullFilePath, filter); //recurse
        }

        else if (filename.indexOf(filter)>=0) {
            onChunkFileFound(filename, fullFilePath);
        };
    };
};

// Start recursive search
fromDir(__dirname, chunkFilePrefix);

// Return all chunk files 
return foundChunks;