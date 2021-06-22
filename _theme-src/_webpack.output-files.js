/* ========== THEME OUTPUT FILES ============ */
// This file dictates all the files that Webpack builds.
// On build(or server start) this file looks for any files starting with "webpack-file." and adds their export to the htmlPlugin file array.
// NOTE: The plugin is meant for html, but works fine with a php file. 

var path = require('path'); 
fs = require('fs');

var outputFilePrefix = "html-plugin";
var foundPlugins = [];

function onOutputFileFound(filename, fullFilePath) {
    foundPlugins.push( require("" + fullFilePath) );
}


// Recursively look for files to output
// Kudos to Lucio M Tato
// https://stackoverflow.com/a/25462405
function fromDir(startPath, filter){

    if (!fs.existsSync(startPath)){
        console.log("!!Invalid dir while recursively searching for output files: ", startPath);
        return;
    }

    // Find all files
    var files = fs.readdirSync(startPath);

    for( var i=0; i < files.length; i++){
        var fullFilePath = path.join(startPath,files[i]);
        var filename = files[i];

        // Check if result is folder
        var stat = fs.lstatSync(fullFilePath);
        if ( stat.isDirectory() ) {
            // RECURSION! SO DON'T SCREW UP!
            fromDir(fullFilePath, filter); 
        }
        
        else if (filename.indexOf(filter)>=0) {
            onOutputFileFound(filename, fullFilePath);
        };
    };
};

// Start recursive search
fromDir(__dirname, outputFilePrefix);

// console.log("!!!!!!!!!!!!!!!!!!!!!!!!!! ", foundPlugins);

// Return all chunk files 
return foundPlugins;