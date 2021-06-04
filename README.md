## Measures
This plugin allows increase the user's experience by creating a game-levels system.
You configure some event that are fired by your users that will make them win experience points.
User's profile can now integrate an experience gauge, and you can create a leaderboard page.

### Installation
This plugin can be installed using composer:
```terminal
composer require sunlab/wn-levelup-plugin
```

### How to use
From the backend, create all the levels you want.
Then create some "experience increasers": they are some event that should increase the user experience when they are fired.
Experience increaser "measure name" attribute should correspond to one previously set with [SunLab.Measures](https://github.com/sunlabdev/wn-measures-plugin).

### Components
The plugin provides two components:
- Experience gauge, that could be inserted into a public user's profil page or an account page
- Leaderboard, which displays the most experienced user in a descendant order

### Note on gamification plugin
Totally optionally, this plugin fit perfectly with the [SunLab.Gamification repository](https://github.com/sunlabdev/wn-gamification-plugin)
plugin already released,
both are based on [SunLab.Measures](https://github.com/sunlabdev/wn-measures-plugin) and are designed to increase the user experience providing a game-feeling.

### TODO-List:
- [ ] Implements a user's experience win history component to let user knows precisely when he won all his points
