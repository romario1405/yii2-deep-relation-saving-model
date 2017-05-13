/**
 * Created by Donii Sergii <doniysa@gmail.com> on 5/1/17.
 */
module.exports = {
    build_dir: __dirname + '/src/assets/tabular/build',
    dist_dir: __dirname + '/src/assets/tabular/dist',
    server_root_path: __dirname + '/src/assets/tabular/build',
    listen_port: 1111,
    copy_js_files: true,
    delete_files: true,
    build_template_path: '',
    js_path: 'js',
    css_path: 'css',
    dist_templates_path: 'templates',
    sass_path: 'sass',
    less_path: 'less',
    images_path: 'images',
    template: 'gulp-pug',
    template_options: {
        pretty: true,
        locals: {
            time: '-----timestamp------'
        },
        variables: {
            asd: 'test'
        }
    },
    copyPaths: {
        'src/assets/tabular/build': [
            __dirname + '/src/assets/tabular/dist/plugins'
        ],
        'src/assets/tabular/build/plugins/yii': [
            __dirname + '/vendor/yiisoft/yii2/assets/yii.activeForm.js',
            __dirname + '/vendor/yiisoft/yii2/assets/yii.js',
            __dirname + '/vendor/yiisoft/yii2/assets/yii.validation.js',
        ],
        'src/assets/tabular/build/plugins/jquery/': [
            __dirname + '/vendor/bower/jquery/dist/jquery.js',
            __dirname + '/vendor/bower/jquery/dist/jquery.min.js'
        ],
        'src/assets/tabular/build/plugins/jquery.repeater/': [
            __dirname + '/vendor/bower/jquery.repeater/jquery.repeater.js',
            __dirname + '/vendor/bower/jquery.repeater/jquery.repeater.min.js'
        ],
        'src/assets/tabular/build/plugins/': [
            __dirname + '/tests/application/assets/bootstrap'
        ]
    },
    skip_styles_dir: [
        '!src/assets/tabular/dist/less/layouts/*.less',
        '!src/assets/tabular/dist/less/**/**/**/**/**/**/**/_*.less',
    ],
    skip_templates_dir: [
        '!src/assets/tabular/dist/templates/layouts/*.pug',
        '!src/assets/tabular/dist/templates/**/**/**/**/**/**/_*.pug',
    ],
    template_extensions: 'pug',
    livereload_options: {},
    rsync_js_callback: undefined
};