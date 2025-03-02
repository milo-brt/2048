# The 2048 game in PHP [university project]  

🇫🇷 Pour la version française, [c'est par ici](README_fr.md)

Practical work n°2 of the course unit [LIFRW : Introduction to Networks and Web](http://perso.univ-lyon1.fr/olivier.gluck/supports_enseig.html#LIFRW) done during my first year of preparatory class at [Polytech Lyon](https://polytech.univ-lyon1.fr/english-version)

## Goal

Make the 2048 game in PHP following a precise and detailed organization as described in the practical work:
- the homepage is an `.html` file that redirects to the PHP game when the "New Game" button is clicked
- the current game score, grid content, and player action history are stored in `.txt` files on the server side
- the game can be played with buttons on the page
- the game displays a message when the player looses
- many instructions are given on how to code the game, especially on managing the grid and moving the tiles
- the rules must appear on the page

## Personal Additions

- Complete CSS overhaul to make the game more modern and visually appealing
- Keyboard support for playing (arrow keys)

## Drawbacks

- It is not possible to play with multiple players at the same time, as the save is unique and stored on the server side
- With each player action, the server is solicited to update the grid, which is not optimal in terms of performance, especially for an online game

## Result

<img src="2048.png" alt="Preview of the 2048 game" width="500"/>

A copy of the project is hosted [here](https://projects.milobrt.fr/2048)