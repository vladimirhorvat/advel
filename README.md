# App

## Requirements

Android phone, the latest react native and npm

open terminal1:

```
cd project-dir/AdvelApp
npm install
```

edit android/app/src/main/AndroidManifest.xml\
find android:value attribute of the meta-data tag\
insert googleapi key

## How to get a googleapi key?

- Open Google Developer Console at: https://console.developers.google.com/
- In the top-righthand corner select the project you wish to create the API key for, or start a new project
- Select the 'Credentials' tab from the menu located on the right side of the screen
- Click on the '+ Create credentials' button located in the header of the page
- Select 'API Key' from the menu

## And then...

connect phone over USB cable
in terminal1:

```
react-native start
```

in another terminal:

```
react-native run-android
```

allow Location permission by hand in the application settings in the Android OS

before starting the app goto https://advel.fermicoding.com/\
register as a new user. When you log in, look at the URL to find your user id:\
https://advel.fermicoding.com/user/4 (user id is 4)

then in project-dir/AdvelApp/screens/MapScreen.js\
find

```
usageData: {id: 1, coordinates: []},
```

and

```
this.setState({usageData: {id: 1, coordinates: []}});
```

change 1 to your user id

## Usage

No real usage. You can browse the map as you move or see the license, but nothing else.\
The main purpose of the app is that it sends your location to the server every 10 seconds.\
This is a part of a prototype, a feature design to test and improve it, so if you are
worried about privacy, at this stage: don't use this app.

---

# Clients' portal

## Requirements

mysql\
php7.4\
[Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)

```
cd project-dir
composer install
mysql -uroot -e "create database advel"
mysql -uroot advel < project-dir/db.sql
mkdir -p project-dir/web/sites/default/files
chmod 777 project-dir/web/sites/default/files
```

edit web/sites/default/settings.local.php and change lines 4,5,6,14.\
Change line 13 to list your virtual host name.

## Usage

Log in as admin (user: admin password: 111111)\
go to\
node/add/advertisement\
look at the map. Zoom in to a town on it. You can draw your zones using the tool palette on the righ.\
Add date/time and fill out other fields, and you will have defined your zone.
