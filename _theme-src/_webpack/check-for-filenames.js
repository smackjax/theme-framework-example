// Recursively look for file names containing a string
// Kudos to Lucio M Tato
// https://stackoverflow.com/a/25462405
const path = require('path');
const fs = require('fs');

module.exports = function checkForFilenames(startPath, filter, callback){

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
            checkForFilenames(fullFilePath, filter, callback); 
        }
        
        else if (filename.indexOf(filter)>=0) {
            callback(fullFilePath, filename);
        };
    };
};