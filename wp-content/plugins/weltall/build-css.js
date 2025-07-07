/**
 * Script to compile Sass files to CSS
 * 
 * This script uses the sass package to compile Sass files to CSS
 * It ensures that paths are resolved correctly to avoid the "uv_cwd" error
 */

const fs = require('fs');
const path = require('path');
const sass = require('sass');

// Define paths using __dirname to ensure correct resolution
const PLUGIN_DIR = __dirname;
const SCSS_DIR = path.join(PLUGIN_DIR, 'assets', 'scss');
const CSS_DIR = path.join(PLUGIN_DIR, 'assets', 'css');

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

// Get all SCSS files
const files = fs.readdirSync(SCSS_DIR)
  .filter(file => file.endsWith('.scss'))
  .map(file => ({
    input: path.join(SCSS_DIR, file),
    output: path.join(CSS_DIR, file.replace('.scss', '.css'))
  }));

// Compile each SCSS file to CSS
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