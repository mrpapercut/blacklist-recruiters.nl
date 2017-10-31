const path = require('path');
const webpack = require('webpack');

const extractTextPlugin = require('extract-text-webpack-plugin');
const extractSass = new extractTextPlugin('bundle.css');

const PLUGINS = [extractSass];

const CONSTANTS = {
    CONTEXT: path.join(__dirname, './src'),
    TARGET: path.join(__dirname, './dist')
};

module.exports = (env) => {

    const DEV = process.env.NODE_ENV !== 'production' && env !== 'production';

    if (!DEV) PLUGINS.push(
        new webpack.optimize.UglifyJsPlugin({minimize: true}),
        new webpack.DefinePlugin({
            'process.env': {
                'NODE_ENV': JSON.stringify('production')
            }
        })
    );

    return {
        entry: './js/main.js',
        context: CONSTANTS.CONTEXT,
        output: {
            path: CONSTANTS.TARGET,
            filename: 'bundle.js',
            sourceMapFilename: '[name].map',
            chunkFilename: '[id].chunk.js'
        },
        devtool: DEV ? 'cheap-module-eval-source-map' : false,
        module: {
            rules: [{
                test: /\.js$/,
                loader: 'babel-loader',
                exclude: /node_modules/
            }, {
                test: /\.scss$/,
                loader: extractSass.extract(['css-loader', 'sass-loader'])
            }]
        },
        plugins: PLUGINS
    };
}
