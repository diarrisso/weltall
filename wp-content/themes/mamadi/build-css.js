/**
 * Script to compile Sass files to CSS
 * 
 * This script uses the sass package to compile Sass files to CSS
 * It ensures that paths are resolved correctly to avoid the "uv_cwd" error
 */

const fs = require('fs');
const path = require('path');
const sass = require('sass');

const THEME_DIR = __dirname;
const SCSS_DIR = path.join(THEME_DIR, 'assets', 'scss');
const CSS_DIR = path.join(THEME_DIR, 'assets', 'css');

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

try {
  if (!fs.existsSync(CSS_DIR)) {
    fs.mkdirSync(CSS_DIR, { recursive: true });
    console.log(`Created directory: ${CSS_DIR}`);
  }
} catch (err) {
  console.error(`Error creating directory: ${err.message}`);
  process.exit(1);
}


files.forEach(file => {
  try {
    console.log(`Compiling ${file.input} to ${file.output}...`);

    const result = sass.compile(file.input, {
      style: 'compressed',
      sourceMap: true
    });

    fs.writeFileSync(file.output, result.css);
    console.log(`Successfully compiled Sass to CSS: ${file.output}`);


    if (result.sourceMap) {
      fs.writeFileSync(`${file.output}.map`, JSON.stringify(result.sourceMap));
      console.log(`Source map created: ${file.output}.map`);
    }
  } catch (err) {
    console.error(`Error compiling ${file.input}: ${err.message}`);
  }
});
