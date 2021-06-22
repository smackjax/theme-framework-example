const path = require('path');

const port = 9000;
module.exports = ()=>({
    contentBase: path.join(__dirname, '../', '../'),
    compress: true,
    port,
    proxy: {
        '/server-actions/': {
            target: `http://jedwardkruft.local`,
            secure: false,
            changeOrigin: true
        }
    }
});