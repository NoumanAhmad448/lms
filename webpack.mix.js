const mix = require('laravel-mix');

// JavaScript files
mix.setPublicPath("public").js('resources/js/app.js', 'js')
   .js('resources/js/bootstrap.js', 'js')
   .js('resources/js/course_category.js', 'js')
   .js('resources/js/course_instruction.js', 'js')
   .js('resources/js/course_time_selection.js', 'js')
   .js('resources/js/course_title.js', 'js')
   .js('resources/js/main.js', 'js')
   .js('resources/js/users.js', 'js')
   .js('resources/js/edit_user.js', 'js')
   .js('resources/js/fade_out_msg.js', 'js')
   .js('resources/js/dashboard.js', 'js')
   .js('resources/js/target_ur_students.js', 'js')
   .js('resources/js/landing_page.js', 'js')
   .js('resources/js/price.js', 'js')
   .js('resources/js/promotion.js', 'js')
   .js('resources/js/message.js', 'js')
   .js('resources/js/admin_courses.js', 'js')
   .js('resources/js/common_functions.js', 'js')
   .js('resources/js/course-content.js', 'js')
   .js('resources/js/course/show-course.js', 'js/course')
   .js('resources/js/course/course_curriculum.js', 'js/course')
   .js('resources/js/profile.js', 'js')

   // CSS files
   .postCss('resources/css/app.css', 'css', [
     require('@tailwindcss/postcss'),
     require('autoprefixer'),
   ])
   .postCss('resources/css/course_instruction.css', 'css', [
     require('@tailwindcss/postcss'),
     require('autoprefixer'),
   ])
   .postCss('resources/css/text.css', 'css', [
     require('@tailwindcss/postcss'),
     require('autoprefixer'),
   ])

   // SCSS files
   .sass('resources/sass/responsive.scss', 'css', {
     implementation: require('sass'),
     sassOptions: {
       includePaths: ['node_modules'],
     },
   })

   // Webpack configuration
   .webpackConfig(require('./webpack.config'));