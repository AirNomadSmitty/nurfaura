# URF Pickem
##Description
With URF Pick'em, we animate a gold graph and update champion KDAs as the game is progressing. The object of the game is to pick the winner of the game as early on as possible. The earlier you pick, the more points you get. Keep guessing until you get one wrong, then save your score to the leaderboard. The demo is hosted here: http://ec2-54-148-243-198.us-west-2.compute.amazonaws.com/

##Dependencies
- "aura/cli-kernel": "~2.0",
- "aura/web-kernel": "~2.0",
- "aura/sql"       : "~2.0",
- "aura/view"      : "~2.0",
- "aura/session"   : "~2.0"

We utilized different pieces of the Aura PHP framework for our backend. These allowed us to handle routing, views, session changes, and database interaction easily.

- "monolog/monolog": "~1.0"

For some request logging

- "guzzlehttp/guzzle" : "~5.0"

The crowd favorite PHP library for hitting APIs

- Angular JS
- Bootstrap JS

##Future Goals
Given the length of the competition and our work schedules, many things got ommitted. We're both developers without much knowledge/experience in design so we opted not to waste too much time on that. Ideally we'd like to make the app more appealing.

Many ideas got scrapped due to time constraints. One main one that we would've liked to have in there is a working killfeed. In an ideal world, we wanted to pull some champion-specific sound files from the client and play them on each kill. We also would've liked to pair this with a map that updates with positions where champions died over the course of the game. 

##Thanks Riot!
URF Pick'em isn't endorsed by Riot Games and doesn't reflect the views or opinions of Riot Games or anyone officially involved in producing or managing League of Legends. League of Legends and Riot Games are trademarks or registered trademarks of Riot Games, Inc. League of Legends © Riot Games, Inc.
