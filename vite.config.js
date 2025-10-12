import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import html from '@rollup/plugin-html';
import { glob } from 'glob';

/**
 * Get Files from a directory
 * @param {string} query
 * @returns array
 */
function GetFilesArray(query) {
  return glob.sync(query);
}

/**
 * Processing All JS Files
 * 
 */
const libsJsFiles__________ = GetFilesArray('resources/assets/vendor/libs/**/*.js');
const vendorJsFiles________ = GetFilesArray('resources/assets/vendor/js/*.js');
const pageJsFiles__________ = GetFilesArray('resources/assets/js/*.js');
const pageJsSetupFiles_____ = GetFilesArray('resources/js/pages/*.js');
const commonJsSetupFiles___ = GetFilesArray('resources/js/*.js');
const allImgSetupFiles_____ = GetFilesArray('resources/img/*.*');

/**
 * Processing Core, Libs Scs, Themes & Pages Scss Files
 * 
*/
const CoreScssFiles________ = GetFilesArray('resources/assets/vendor/scss/**/!(_)*.scss');
const LibsScssFiles________ = GetFilesArray('resources/assets/vendor/libs/**/!(_)*.scss');
const FontsScssFiles_______ = GetFilesArray('resources/assets/vendor/fonts/!(_)*.scss');
const LibsCssFiles_________ = GetFilesArray('resources/assets/vendor/libs/**/*.css');
const CommonCssFiles_______ = GetFilesArray('resources/css/*.css');

// Deleted
// Tabler Js setup files
// const tablerJsSetupFiles___ = GetFilesArray('resources/tabler-dist/js/*.js');
// const libsTablerFiles______ = GetFilesArray('resources/tabler-dist/libs/**/**/*.js');
// const libsTablerFiles______ = GetFilesArray('resources/tabler-dist/libs/**/dist/*.js');
// const LibsTablerCssFiles___ = GetFilesArray('resources/tabler-dist/css/*.css');

// Processing Window Assignment for Libs like jKanban, pdfMake
function libsWindowAssignment() {
  return {
    name: 'libsWindowAssignment',
    transform(src, id) {
      if (id.includes('jkanban.js')) {
        return src.replace('this.jKanban', 'window.jKanban');
      } else if (id.includes('vfs_fonts')) {
        return src.replaceAll('this.pdfMake', 'window.pdfMake');
      }
    }
  };
}

// Exporting defined configs
export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/sweetalert.js',
        ...pageJsFiles__________,
        ...vendorJsFiles________,
        ...libsJsFiles__________,
        ...commonJsSetupFiles___,
        ...allImgSetupFiles_____,
        ...pageJsSetupFiles_____,
        ...CoreScssFiles________,
        ...LibsScssFiles________,
        ...LibsCssFiles_________,
        ...CommonCssFiles_______,
        ...FontsScssFiles_______
        // ...tablerJsSetupFiles___,
        // ...libsTablerFiles______,
        // ...LibsTablerCssFiles___,
      ],
      refresh: true
    }),
    html(),
    libsWindowAssignment()
  ],
  // resolve: {
  //   alias: {
  //     '@tabler': '/resources/tabler-dist',
  //   },
  // },
});
