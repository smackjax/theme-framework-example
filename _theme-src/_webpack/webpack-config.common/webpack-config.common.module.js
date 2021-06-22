const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = isProduction => ({
    rules: [
        // Babel
        { 
            test: /\.js$/,
            exclude: /(node_modules|bower_components)/,
            use: {
                loader: 'babel-loader',
            }
        },
        
        {
            test: /\.(ejs)$/,
            use: {
                // loader: "raw-loader",
                loader: "compile-ejs-loader",
            }
        },


        // Handle template partials
        {
            // Loader for both html and php
            test:/\.partial\..*$/,
            use: [ {
              loader: 'html-loader',
            // Uncomment to minimize (I think)
              options: {
                minimize: true,
                interpolate: true
              }
            }],
        },

        // Enable autoprefixer
        {
            test: /\.css$/,
            use: [
                'style-loader',
                { 
                    loader: 'css-loader', 
                    options: { 
                        importLoaders: 1,
                        config: {
                            path: '../'
                        },
                    } 
                },
              'postcss-loader'
            ]
          },

        {
            test: /\.(css|scss)$/,
            use: [
                // fallback to style-loader in development
                MiniCssExtractPlugin.loader,
                "css-loader",
                "sass-loader"
            ]
        },

        // Images
        {
            test: /\.(jpe?g|png)$/i,
            loader: 'responsive-loader',
            options: {
                adapter: require('responsive-loader/sharp'),
                quality: 85,
                placeholder: true,
                placeholderSize: 35,
                name: "/images/[hash].[ext]",
                // disable: !isProduction,
            }
        },
        {
            test: /\.(svg)$/,
            use: [{
                loader: 'url-loader',
                options: {
                    limit: 50,
                    name: "/images/[hash].[ext]"
                }
            }]
        },
    ]
})