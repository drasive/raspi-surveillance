# Release Process

- Update composer dependencies
- Update bower dependencies
- Make sure nothing is broken

- Create release folder (raspi-surveillance-v[version].zip)
- Put /REAMDE in "[release]/"
- Use "/src/" as "[release]/Website"
	- Create .env file with APP_ENV=raspi, APP_DEBUG=false and a random APP_KEY set
	- Run ```composer install``` (compiles for release)
	- Remove project files (*.sln)
	- Remove .git*
- Use "/setup/" as "[release]/Setup"
	- *.sql
	- enable-camera.sh
	- motion*
	- setup-pi (experimental).sh
- Use "/doc/" as "[release]/Documentation"
	- Database-v*.*
	- User Manual.pdf

- Create git tag (e.g. "v1.3.2")
- Create release on GitHub
