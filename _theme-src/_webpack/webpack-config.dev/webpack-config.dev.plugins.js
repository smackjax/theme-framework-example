// Inject browsersync into htmlplugin templates
var injectIntoHtmlPlugin = require('html-webpack-inject-string-plugin');



module.exports = ()=>([


    new injectIntoHtmlPlugin({
        search: '</body>',
        inject: `<script id="__bs_script__">//<![CDATA[
            document.write("<script async src='http://HOST:3000/browser-sync/browser-sync-client.js?v=2.26.7'><\\/script>".replace("HOST", location.hostname));
        //]]></script>`
    }),
    new injectIntoHtmlPlugin({
        search: '</head>',
        inject: `<meta name="robots" content="noindex">`
    })
])