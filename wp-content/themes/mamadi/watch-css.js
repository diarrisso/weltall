/**
 * Script to watch and compile Sass files to CSS
 * 
 * This script uses the sass package to watch and compile Sass files to CSS
 * It ensures that paths are resolved correctly to avoid the "uv_cwd" error
 */

const fs = require('fs');
const path = require('path');
const sass = require('sass');

// Define paths using __dirname to ensure correct resolution
const THEME_DIR = __dirname;
const SCSS_DIR = path.join(THEME_DIR, 'assets', 'scss');
const CSS_DIR = path.join(THEME_DIR, 'assets', 'css');

// Files to compile
const files = [
  { 
    input: path.join(SCSS_DIR, 'style.scss'), 
    output: path.join(CSS_DIR, 'style.css') 
  },
  { 
    input: path.join(SCSS_DIR, 'fonts.scss'), 
    output: path.join(CSS_DIR, 'fonts.css') 
  }
];

// Ensure the CSS directory exists
try {
  if (!fs.existsSync(CSS_DIR)) {
    fs.mkdirSync(CSS_DIR, { recursive: true });
    console.log(`Created directory: ${CSS_DIR}`);
  }
} catch (err) {
  console.error(`Error creating directory: ${err.message}`);
  process.exit(1);
}

// Function to compile all Sass files to CSS
function compileAllSass() {
  files.forEach(file => {
    try {
      console.log(`Compiling ${file.input} to ${file.output}...`);

      const result = sass.compile(file.input, {
        style: 'compressed',
        sourceMap: true
      });

      fs.writeFileSync(file.output, result.css);
      console.log(`Successfully compiled Sass to CSS: ${file.output}`);

      // Write source map if available
      if (result.sourceMap) {
        fs.writeFileSync(`${file.output}.map`, JSON.stringify(result.sourceMap));
        console.log(`Source map created: ${file.output}.map`);
      }
    } catch (err) {
      console.error(`Error compiling ${file.input}: ${err.message}`);
      // Continue with other files even if one fails
    }
  });
}

// Function to compile a specific Sass file to CSS
function compileSassFile(filename) {
  const file = files.find(f => path.basename(f.input) === filename);

  if (file) {
    try {
      console.log(`Compiling ${file.input} to ${file.output}...`);

      const result = sass.compile(file.input, {
        style: 'compressed',
        sourceMap: true
      });

      fs.writeFileSync(file.output, result.css);
      console.log(`Successfully compiled Sass to CSS: ${file.output}`);

      // Write source map if available
      if (result.sourceMap) {
        fs.writeFileSync(`${file.output}.map`, JSON.stringify(result.sourceMap));
        console.log(`Source map created: ${file.output}.map`);
      }
    } catch (err) {
      console.error(`Error compiling ${file.input}: ${err.message}`);
    }
  } else {
    // If the changed file is not in our list but might be imported by one of our files,
    // compile all files to be safe
    compileAllSass();
  }
}

// Initial compilation
compileAllSass();

// Watch for changes in the SCSS directory
console.log(`Watching for changes in ${SCSS_DIR}...`);
console.log('Press Ctrl+C to stop watching.');

fs.watch(SCSS_DIR, { recursive: true }, (eventType, filename) => {
  if (filename && filename.endsWith('.scss')) {
    console.log(`\nFile ${filename} changed. Recompiling...`);
    compileSassFile(filename);
  }
});
