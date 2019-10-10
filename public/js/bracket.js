$(document).ready(function() {

    let knownBrackets = [2,4,8,16],

        teams  = [],
        currentBracket  = [],
        tournament = [],
        authenticated = false,

        bracketCount = 0,
        homeScoreInput = $("#homeScore"),
        awayScoreInput = $("#awayScore"),
        gameNumberHiddenBlock = $("#gameNumber"),
        scoreModal = $("#scoreModal"),
        resetBtn = $(".reset"),
        scoreBlockInputs = $('.score'),
        roundColumns = $('.round_column'),
        winnerRadioBlock = '.modal-body input[name="winner"]'
    ;

    function getBracket(base) {
        let closest 		= _.find(knownBrackets, function(k) {
            return k >= base;
        }), byes 			= closest - base;

        if(byes > 0)
            base = closest;
        let bracket 	= [],
            round 		= 1,
            count       = base - 1,
            baseT 		= base / 2,
            baseC 		= base / 2,
            teamMark	= 0,
            bracketCount = 0,
            nextInc		= base / 2;

        for(i=1; i <= count; i++) {
            let baseR = i/baseT,
                isBye = false,
                basedRound = round > 1 && round % 2 !== 0 ? round+1 : round;
            ;

            let last = _.map(_.filter(bracket, function(b) {
                return b.nextGame === i;
            }), function(b) {
                return {
                    game: b.gameNumber,
                    teams: b.teamsName
                };
            });

            let savedBracket = _.filter(currentBracket, function(b) {
                return b.gameNumber === i;
            })[0];

            let homeTeam = {
                    id: savedBracket && savedBracket.homeTeam ? savedBracket.homeTeam.id : null,
                    name: savedBracket && savedBracket.homeTeam ? savedBracket.homeTeam.text : teams[teamMark] ?
                        teams[teamMark].name : ''
                },
                awayTeam =  {
                    id: savedBracket && savedBracket.awayTeam ? savedBracket.awayTeam.id : null,
                    name: savedBracket && savedBracket.awayTeam ? savedBracket.awayTeam.text : teams[teamMark] ?
                        teams[teamMark].name : ''
                };
            bracket.push({
                lastGames:	round === 1 ? null : [last[0].game,last[1].game],
                nextGame:	nextInc+i>base-1?null:nextInc+i,
                teamsName:	round === 1 ? [ {
                    id: homeTeam.id,
                    name:
                        authenticated ? '<select name="home_team_'+i+'" class="select-team">' +
                            '<option value="'+homeTeam.id+'">'+homeTeam.name+'</option>' +
                            '</select>' : homeTeam.name
                }, {
                    id: awayTeam.id,
                    name:
                        authenticated ? '<select name="home_team_'+i+'" class="select-team">' +
                            '<option value="'+awayTeam.id+'">'+awayTeam.name+'</option>' +
                            '</select>' : awayTeam.name
                }
                ] : [
                    homeTeam,
                    awayTeam
                ],
                gameNumber:	savedBracket?savedBracket.gameNumber : i,
                roundNo:	round,
                homeScore:	savedBracket? savedBracket.homeScore : null,
                awayScore:	savedBracket? savedBracket.awayScore : null,
                winner:	savedBracket && savedBracket.winner ? savedBracket.winner.id : null,
                teamCount: savedBracket?
                    savedBracket.round.teamCount : tournament.firstRoundTeamCount / basedRound,
                roundId:    savedBracket?
                    savedBracket.round.id : tournament.firstRoundId,
                bye:		isBye
            });

            teamMark += 2;
            bracketCount++;
            savedBracket = null;

            if(i%2 !== 0)
                nextInc--;

            while(baseR >= 1) {
                round++;
                baseC /= 2;
                baseT = baseT + baseC;
                baseR = i/baseT;
            }
        }

        renderBrackets(bracket);
    }


    function renderBrackets(structure) {
        let groupCount	= _.uniq(_.map(structure, function(s) { return s.roundNo; })).length;
        let grouped = _.groupBy(structure, function(s) { return s.roundNo; });
        let selectInputClass = '.select-team';
        let renderBracket = function(gg) {
            let homeScore = gg.homeScore !== null ? +gg.homeScore : "",
                awayScore = gg.awayScore !== null ? +gg.awayScore : "";

            let editText = authenticated? 'Редактировать' :'';

            return '\n<div class="mtch_container '+(gg.thirdPlace ?"third_position":"")+'">' +
                '   <div class="match_unit">\n' +
                '      <div class="m_segment m_top '+ (gg.winner === gg.teamsName[0].id ? "winner" :"loser")+ '" data-team-id="'+gg.teamsName[0].id+'" ' +
                '       ><span><a href="#">' +
                '          <span data-position="home" data-game-number="'+gg.gameNumber+'">'+gg.teamsName[0].name+'</span></a>' +
                '               <strong>'+homeScore+'</strong></span>\n' +
                '      </div>\n' +
                '      <div class="m_segment m_botm '+ (gg.winner === gg.teamsName[1].id ? "winner" :"loser")+ '" data-team-id="'+gg.teamsName[1].id+'"' +
                '       >' +
                '       <span><a href="#">' +
                '          <span data-position="away" data-game-number="'+gg.gameNumber+'">'+gg.teamsName[1].name+'</span></a>' +
                '          <strong>'+awayScore+'</strong></span>\n' +
                '      </div>\n' +
                '      <div class="m_dtls">' +
                '          <span class="edit_score" data-game-number="'+gg.gameNumber+'" >'+editText+'</span>' +
                '      </div>\n' +
                '   </div>' +
                '</div>'
        };

        for(g=1; g<=groupCount; g++) {
            let counter = 1;

            _.each(grouped[g], function(gg) {
                let reversed = counter++ > Math.ceil((gg.teamCount/2)/2) ? "_reversed" : "";
                $(".r_"+ gg.roundNo + "" + reversed).append(renderBracket(gg));
            });
        }
        if(currentBracket.length === tournament.firstRoundTeamCount) {
            var savedBracket = currentBracket[tournament.firstRoundTeamCount - 1];
            $('.r_4').append(renderBracket({
                lastGames: null,
                nextGame: null,
                teamsName: [
                    savedBracket.homeTeam ?
                        {id: savedBracket.homeTeam.id, name: savedBracket.homeTeam.text} : {id:null, name: ""},
                    savedBracket.awayTeam ?
                        {id: savedBracket.awayTeam.id, name: savedBracket.awayTeam.text} : {id:null, name: ""},
                ],
                gameNumber: currentBracket.length,
                roundNo: 4,
                homeScore: savedBracket ? savedBracket.homeScore : null,
                awayScore: savedBracket ? savedBracket.awayScore : null,
                winner: savedBracket && savedBracket.winner ? savedBracket.winner.id : null,
                teamCount: savedBracket ?
                    savedBracket.round.teamCount : tournament.firstRoundTeamCount / basedRound,
                roundId: savedBracket ?
                    savedBracket.round.id : tournament.firstRoundId,
                thirdPlace: true
            }));
        }

        let finals = _.last(structure);

        if(finals.winner !== null) {
            $(".r_"+ (groupCount)).append('' +
                '<div class="winner_team">' +
                '<span>ПОБЕДИТЕЛЬ<a href="#"><span>'+
                (finals.winner === finals.teamsName[0].id ?
                    finals.teamsName[0].name :
                    finals.teamsName[1].name)
                +'</span></a>\n' +
                '  </span>' +
                '</div>'
            );
        }

        bracketCount++;

        $(selectInputClass).select2({
            ajax: {
                url: '/team-available-list',
                data: {
                    tournamentId: tournament.id,
                    roundId: structure[0].roundId
                }
            },
            width: '100%',

        });
        $(selectInputClass).off('change');

        $(selectInputClass).on('change', function () {
            let teamId = this.value,
                parent = $(this).parent();

            $.post( "/set-tournament-bracket-team",
                {
                    tournamentId: tournament.id,
                    gameNumber: parent.data('game-number'),
                    teamPosition: parent.data('position'),
                    teamId: teamId
                }, function () {
                    updateGrid();
                }
            );
        });

        if(authenticated) {
            let scoreSaveBtn = $('.save-score'),
                editScoreBtn = $('.edit_score');
            ;

            editScoreBtn.off('click');
            scoreSaveBtn.off('click');

            editScoreBtn.on('click', function () {
                let gameNumber = $(this).data('game-number')
                ;

                let data = _.filter(currentBracket, function(b) {
                    return b.gameNumber === gameNumber;
                })[0];

                if(!data.homeTeam || !data.awayTeam)
                    return;


                homeScoreInput.val( +data.homeScore );
                awayScoreInput.val( +data.awayScore );
                gameNumberHiddenBlock.val( gameNumber );
                checkWinnerOption();

                scoreModal.modal("show")
            });

            scoreSaveBtn.on('click', function () {
                $.post("set-result", {
                    tournamentId: tournament.id,
                    gameNumber: gameNumberHiddenBlock.val(),
                    homeScore: homeScoreInput.val(),
                    awayScore: awayScoreInput.val(),
                    winner: $(winnerRadioBlock + ':checked').val()
                }, function () {
                    updateGrid();
                    scoreModal.modal("hide");
                });
            });
        }
    }

    let checkWinnerOption = function() {
        let homeScore = homeScoreInput.val(),
            awayScore = awayScoreInput.val();
        $(winnerRadioBlock).attr('disabled', true);

        if(homeScore === awayScore) {
            $(winnerRadioBlock).attr('checked', 'checked');
            $(winnerRadioBlock).removeAttr('disabled');
        }
    };

    scoreBlockInputs.on('change', function () {
        checkWinnerOption();
    });

    scoreModal.on('hidden.bs.modal', function () {
        let options = '.modal-body input[name="winner"]';
        $(options).attr('checked', true).attr('checked', false).attr('disabled', true);
    });

    resetBtn.on('click', function () {
        if(!tournament)
            return;

        $.ajax({
            type:"PUT",
            url:"/reset?tournamentId="+tournament.id
        }).done( function() {
            updateGrid();
        });
    });

    $.ajax({
        url:"/is-authenticated"
    }).done( function(data) {
        authenticated = data.results;

        if(!authenticated)
            resetBtn.hide();

        updateGrid();
    });

    let updateGrid = function(){
        $.ajax({
            url:"/active-tournament"
        }).done( function( data ) {
            tournament = data.results;
            $.ajax({
                url:"/tournament-bracket",
                data: {"tournamentId": tournament.id}
            }).done( function( data ) {
                currentBracket = data.results;
                if(currentBracket.length <= 0) {
                    $.ajax({
                        type: "GET",
                        url:"/team-list"
                    }).done( function( data ) {
                        if(data.status === 200) {
                            teams = _.shuffle(data.results);
                        }
                    });
                }

                roundColumns.empty();

                getBracket(tournament.firstRoundTeamCount);
            });
        });
    }
});