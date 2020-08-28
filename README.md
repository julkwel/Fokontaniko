# Fokontaniko

Fokontany management

![Fokontaniko](https://raw.githubusercontent.com/julkwel/Fokontaniko/master/public/images/Capture%20du%202020-06-01%2021-12-13.png)

- Specs :
```
 - symfony => 5.1
 - Webpack for assets management
```

## Requirements:

```
- php v^7.4
- nodejs && (npm || yarn)
- Motivation and feeling
- Little symfony skills.
- Little javascript skills.
- php-ext-gd
```

## Installation :

```
- git clone your_fork.git
- cd Fokontaniko 
- composer install
- yarn install
```

- Update the database configuration in `.env` to follow your own environment.

## Database:

```
- bin/console d:d:c
- bin/console d:s:u -f
```

## Command to create super admin user :

`- php bin/console app:create:user`

## Command to create fokontany :

`- php bin/console app:create:fokontany`

## Command to launch test :

`- php bin/phpunit tests/SecurityTest`

# TODO :

```
- Manage migration request. [Running]
- Manage payements of "adidy". [Done]
- Generate graph for president of fokontany. [improvement]
- Your ideas ...
```

**Code for fun !!**
