/** @type {import('tailwindcss').Config} */
module.exports = {
	prefix: 'bm-', /* Iniciales de Brayan y Michael */
	important: false,
	content: [
		"**/*.{html, jsx, js}",
		"**/*.js",
		"**/*.html",
	],
	darkMode: 'class',
	theme: {
		extend: {
			colors: {
				primary: '#7e22ce',
				secondary: "#080808",
				outlineColor: "#1F2123"
			}
		},
	},
	plugins: [],
	
}


