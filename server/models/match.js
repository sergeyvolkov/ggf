var mongoose = require('mongoose'),
    Schema = mongoose.Schema;

var MatchSchema = new Schema({
  id:           String,
  homeTeam:     String,
  awayTeam:     String,
  homeScore:    Number,
  awayScore:    Number,
  status:       String,
  tournamentId: Number
});

module.exports = mongoose.model('Match', MatchSchema);
