## Wordle Cheater

A little project I did for fun that gives the user some suggested words from Wordle rules.

### Install
It is a Laravel 8.83.8 site 
- Clone this repo locally.
- Create a database called 'wdl'
- Enter your db credentials into the .env file
- Run the migration -- php artisan migrate
- Execute the script words-data.sql to bring in the words list
- That should be all :)
- Open the local site

### Usage
* Enter the letter into each cell as it appears in your Wordle app
* Click the block to rotate through black/yellow/green
* Click Enter to show the suggested available words
* Click Clear to clear the current words list
* Don't cheat too much, Wordle is a great app that can be challenging and fun to work out on you own :)

### Updates
* Maybe you can make this look nicer?
* I did try to get the auto prompt to work once a ltter was input, but couldn't get that to work. Maybe you could give it go?
* I am using bootstrap css, because it was easy in the moment :)
