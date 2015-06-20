module.exports = function(app) {
  var express = require('express');
  var matchesRouter = express.Router();

  var matches = [
    {
      id:   1,
      homeTeam:     'Spain',
      awayTeam:     'Argentina',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   2,
      homeTeam:     'Uruguay',
      awayTeam:     'Chile',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   3,
      homeTeam:     'Colombia',
      awayTeam:     'Netherlands',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   4,
      homeTeam:     'Argentina',
      awayTeam:     'Uruguay',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   5,
      homeTeam:     'Netherlands',
      awayTeam:     'Spain',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   6,
      homeTeam:     'Chile',
      awayTeam:     'Colombia',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   7,
      homeTeam:     'Uruguay',
      awayTeam:     'Spain',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   8,
      homeTeam:     'Chile',
      awayTeam:     'Netherlands',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   9,
      homeTeam:     'Colombia',
      awayTeam:     'Argentina',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   10,
      homeTeam:     'Spain',
      awayTeam:     'Colombia',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   11,
      homeTeam:     'Argentina',
      awayTeam:     'Chile',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   12,
      homeTeam:     'Netherlands',
      awayTeam:     'Uruguay',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   13,
      homeTeam:     'Spain',
      awayTeam:     'Chile',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   14,
      homeTeam:     'Uruguay',
      awayTeam:     'Colombia',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   15,
      homeTeam:     'Argentina',
      awayTeam:     'Netherlands',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   16,
      homeTeam:     'Uruguay',
      awayTeam:     'Netherlands',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   17,
      homeTeam:     'Chile',
      awayTeam:     'Argentina',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   18,
      homeTeam:     'Colombia',
      awayTeam:     'Spain',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   19,
      homeTeam:     'Spain',
      awayTeam:     'Uruguay',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   20,
      homeTeam:     'Argentina',
      awayTeam:     'Colombia',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   21,
      homeTeam:     'Netherlands',
      awayTeam:     'Chile',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   22,
      homeTeam:     'Chile',
      awayTeam:     'Spain',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   23,
      homeTeam:     'Colombia',
      awayTeam:     'Uruguay',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   24,
      homeTeam:     'Netherlands',
      awayTeam:     'Argentina',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   25,
      homeTeam:     'Spain',
      awayTeam:     'Netherlands',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   26,
      homeTeam:     'Colombia',
      awayTeam:     'Chile',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   27,
      homeTeam:     'Uruguay',
      awayTeam:     'Argentina',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   28,
      homeTeam:     'Argentina',
      awayTeam:     'Spain',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   29,
      homeTeam:     'Netherlands',
      awayTeam:     'Colombia',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },
    {
      id:   30,
      homeTeam:     'Chile',
      awayTeam:     'Uruguay',
      homeScore:    0,
      awayScore:    0,
      tournamentId: 5,
      status:       'planned'
    },

  ];
  var selectedMatches = [];

  matchesRouter.get('/', function(req, res) {
    if (req.query.tournamentId) {
      selectedMatches = matches.filter(function(match) {
        return match.tournamentId === +req.query.tournamentId;
      });
    }
    res.send({
      'matches': selectedMatches
    });
  });

  matchesRouter.post('/', function(req, res) {
    res.status(201).end();
  });

  matchesRouter.get('/:id', function(req, res) {
    res.send({
      'matches': {
        id: req.params.id
      }
    });
  });

  matchesRouter.put('/:id', function(req, res) {
    res.send({
      'matches': {
        id: req.params.id
      }
    });
  });

  matchesRouter.delete('/:id', function(req, res) {
    res.status(204).end();
  });

  app.use('/api/v1/matches', matchesRouter);
};
