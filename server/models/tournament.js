var mongoose = require('mongoose'),
    Schema = mongoose.Schema;

var TournamentSchema = new Schema({
  id:           String,
  name:         String,
  description:  String,
  teams:        Array
});

module.exports = mongoose.model('Tournament', TournamentSchema);
