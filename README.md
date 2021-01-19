# Universal Card Game

A web application created during the second hackaton in the [Wild Code School](https://www.wildcodeschool.com/) in Bordeaux, supported by [Ekino](https://www.ekino.com/), a web company that creates digital services.
The theme was **"Create a web app that bring people together during the pandemic"**, and we had 48 hours from 13th to 15th of January, 2021 to come up with an idea and show a working demo.

The concept is simple - we didn't find any existing app in which you have a pile of 54 cards and you can play any game you want, so we decided to create one. There is no precise rules, no limits - only your imagination.

# How to run
- clone the repo
- run ```composer install```
- run ```yarn install```
- run ```yarn encore dev```

- create an .env.local file,  uncomment the ```DATABASE_URL="mysql``` line and comment the postgre one, set db_name to "hackaton2" and replace db_user and db_password with your creditentials
- run ```symfony console d:d:c``` to create this database
- run ```symfony console d:m:m``` to execute migrations and create tables
- run ```symfony console d:f:l``` to load the fixtures

- run ```symfony server:start```

## Team Members
- [Marta](https://github.com/kozmarti)
- [Mathias](https://github.com/gouedard-mathias)
- [Vlad](https://www.ekino.com/)

## Acknoledgment
Many thanks to [Guillaume Harari](https://github.com/guillaumebdx) our beloved teacher, our and all the Ekino team for organizing the event.


## To do list for future improvements
- Re-make the front using ReactJS
- Add possibility to play with more that 2 people
- Deploy

