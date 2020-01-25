all: style.css installer.css

_style.css: style.scss
	sass style.scss _style.css

style.css: _style.css
	postcss _style.css --use autoprefixer -d ./
	mv _style.css ../assets/style.css

_installer.css: installer.scss
	sass installer.scss _installer.css

installer.css: _installer.css
	postcss _installer.css --use autoprefixer -d ./
	mv _installer.css ../assets/installer.css
