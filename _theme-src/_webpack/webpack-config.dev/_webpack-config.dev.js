// Webpack DEV config

const merge = require('webpack-merge');
const commonConfig = require('../webpack-config.common/_webpack-config.common.js');

// Vars unique for this build config
const entry = require('./webpack-config.dev.entry');
const webpackModule = require('./webpack-config.dev.module');
const output = require('./webpack-config.dev.output');
const plugins = require('./webpack-config.dev.plugins');
const devServer = require('./webpack-config.dev.server');

// Statically setting a flag was simpler in the long run
const isProduction = false;

// Unique config assembled
const devConfig = {
    "entry": typeof entry === 'function' ? entry(isProduction) : entry,
    "output": typeof output === 'function' ? output(isProduction) : output,
    "module": typeof webpackModule === 'function' ? webpackModule(isProduction) : webpackModule,
    "plugins": typeof plugins === 'function' ? plugins(isProduction) : plugins,
    "devServer": devServer()
};

// Final config
module.exports = merge(commonConfig(isProduction), devConfig);