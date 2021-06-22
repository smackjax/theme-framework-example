// Webpack COMMON config

const entry = require('./webpack-config.common.entry');
const webpackModule = require('./webpack-config.common.module');
const output = require('./webpack-config.common.output');
const plugins = require('./webpack-config.common.plugins');

module.exports = (isProduction)=>({
    "entry": typeof entry === 'function' ? entry(isProduction) : entry,
    "output": typeof output === 'function' ? output(isProduction) : output,
    "module": typeof webpackModule === 'function' ? webpackModule(isProduction) : webpackModule,
    "plugins": typeof plugins === 'function' ? plugins(isProduction) : plugins,
    stats: {
        colors: true
    },
    target: 'node',
})