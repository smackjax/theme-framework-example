// Webpack PRODUCTION config

const merge = require('webpack-merge');
const commonConfig = require('../webpack-config.common/_webpack-config.common.js');

// Vars unique for this build config
const entry = require('./webpack-config.production.entry');
const webpackModule = require('./webpack-config.production.module');
const output = require('./webpack-config.production.output');
const plugins = require('./webpack-config.production.plugins');

// Statically setting a flag was simpler in the long run
const isProduction = true;

// Unique config assembled
const productionConfig = {
    "entry": typeof entry === 'function' ? entry(isProduction) : entry,
    "output": typeof output === 'function' ? output(isProduction) : output,
    "module": typeof webpackModule === 'function' ? webpackModule(isProduction) : webpackModule,
    "plugins": typeof plugins === 'function' ? plugins(isProduction) : plugins
};

// Final config
module.exports = merge(commonConfig(isProduction), productionConfig);