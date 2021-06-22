## IMAGES
Images are automatically added to the available images when put in this folder, regardless of folder depth. 

**But this is important:** 
After a new image is added, the "dev-build" or "build" npm script has to be run even though it can be used inside the theme src successfully.
The Webpack server page version will be looking for the image inside the 'theme-root'(or parent) folder, **not** the 'theme-src' folder.