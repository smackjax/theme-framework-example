/* ===========================
    Webpack config 
=========================== */
const webpack = require('webpack');
const {dirname, join} = require('path');

// DEV config
const devConfig = require('./webpack-config.dev/_webpack-config.dev.js');
// PRODUCTION config
const productionConfig = require('./webpack-config.production/_webpack-config.production.js');

// Set theme root folder
global.themePath = dirname(dirname(__dirname));
global.themeRootPath = themePath;
global.devPath = dirname(__dirname);


module.exports = env=>{
    // Failsafe
    const NODE_ENV = (env && env.production) ? 
        'production' :
        'development';

    // Extract whether this build is production 
    const isProduction = 
        (NODE_ENV === 'production' ? true : false);

    // Production build
    if(isProduction) {
       return productionConfig;
    }

    // Dev build
    return devConfig;
}