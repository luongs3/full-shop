<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/test.css" rel="stylesheet">
    <script src="/js/jquery-2.2.0.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>

</head>
<body>
<div class="container-fluid">
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <button class="btn btn-default" id="x">X</button>
                    <button class="btn btn-default" id="y">Y</button>
                </div>
            </div>
        </div>
    </div>
    <div class="area">
        <div class="row">
            <span class="square" id="1-1"></span>
            <span class="square" id="1-2"></span>
            <span class="square" id="1-3"></span>
        </div>
        <div class="row">
            <span class="square" id="2-1"></span>
            <span class="square" id="2-2"></span>
            <span class="square" id="2-3"></span>
        </div>
        <div class="row">
            <span class="square" id="3-1"></span>
            <span class="square" id="3-2"></span>
            <span class="square" id="3-3"></span>
        </div>
    </div>
</div>
</body>
</html>


<script>
    var user = 'X', ai = 'O', turn, position = [], ai_pos = [], user_pos = [];
        $(window).load(function(){
            $("#myModal").modal('show');
        });
    function predictUser(pos) {
        var i, j, k;
        var temp, col = [], row = [];
        for (i = 0; i < pos.length; i++) {
            temp = pos[i].split('-');
            col.push(temp[1]);
            row.push(temp[0]);
        }
//        find next move in the same row
        for (i = 0; i < pos.length; i++) {
            for (j = 1; j < 4; j++) {
                if (ai_pos.indexOf(row[i] + "-" + j) > -1) {
                    break;
                }
            }
            if (j == 4) {
                for (k = 1; k < 4; k++) {
                    if (position.indexOf(row[i] + "-" + k) == -1) {
                        return row[i] + "-" + k;
                    }
                }
            }
        }
//        find next move in the same col
        for (i = 0; i < pos.length; i++) {
            for (j = 1; j < 4; j++) {
                if (ai_pos.indexOf(j + "-" + col[i]) > -1) {
                    break;
                }
            }
            if (j == 4) {
                for (k = 1; k < 4; k++) {
                    if (position.indexOf(k + "-" + col[i]) == -1) {
                        return k + "-" + col[i];
                    }
                }
            }
        }
//        can't find: random move
        for(i=1; i<4;i++){
            for(j=1;j<4;j++){
                if(position.indexOf(i+"-"+j)==-1)
                    return i+"-"+j;
            }
        }
        // can't find the next move => end game
        return false;
    }

    function predictAI(pos) {
        var i, j, k;
        var temp, col = [], row = [];
        for (i = 0; i < pos.length; i++) {
            temp = pos[i].split('-');
            col.push(temp[1]);
            row.push(temp[0]);
        }
//        find next move in the same row
        for (i = 0; i < pos.length; i++) {
            for (j = 1; j < 4; j++) {
                if (user_pos.indexOf(row[i] + "-" + j) > -1) {
                    break;
                }
            }
            if (j == 4) {
                for (k = 1; k < 4; k++) {
                    if (position.indexOf(row[i] + "-" + k) == -1) {
                        return row[i] + "-" + k;
                    }
                }
            }
        }
//        find next move in the same col
        for (i = 0; i < pos.length; i++) {
            for (j = 1; j < 4; j++) {
                if (user_pos.indexOf(j + "-" + col[i]) > -1) {
                    break;
                }
            }
            if (j == 4) {
                for (k = 1; k < 4; k++) {
                    if (position.indexOf(k + "-" + col[i]) == -1) {
                        return k + "-" + col[i];
                    }
                }
            }
        }
//        can't find: random move
        for(i=1; i<4;i++){
            for(j=1;j<4;j++){
                if(position.indexOf(i+"-"+j)==-1)
                    return i+"-"+j;
            }
        }
    // can't find the next move => end game
        return false;
    }

    function checkWin(pos){
        if(pos.length<3) return false;
        var i, j, k;
        var temp, col = [], row = [];
        for (i = 0; i < pos.length; i++) {
            temp = pos[i].split('-');
            col.push(temp[1]);
            row.push(temp[0]);
        }
        col = col.sort();
        row = row.sort();
        var count;
        // check row
        for (i = 0; i < pos.length-1; i++) {
            count = 1;
            while(row[i]==row[i+1] && i < pos.length-1){
                count++;
                i++;
            }
            if(count==3) return true;
        }
        // check col
        for (i = 0; i < pos.length-1; i++) {
            console.log("check-column: " + pos);
            count = 1;
            while(col[i]==col[i+1]){
                count++;
                i++;
            }
            if(count==3) return true;
        }
        return false;
    }

    function play(square) {
        $(square).text(user);
        user_pos.push($(square).attr('id'));
        position.push($(square).attr('id'));
        var user_move = predictUser(user_pos);
        var check;
        if (user_move == false) {
            ai_move = predictAI(ai_pos);
            ai_pos.push(ai_move);
            check = checkWin(ai_pos);
            if(check==true){
                alert("Loser");
                return false;
            }
            $("#"+ai_move).text(ai);
        } else {
            var userPositionPredict = user_pos.slice();
            userPositionPredict.push(user_move);
            check = checkWin(userPositionPredict);
            console.log("check: " + check);
            if(check==true){
                ai_pos.push(user_move);
                check = checkWin(ai_pos);
                if(check==true){
                    alert("Loser");
                    return false;
                }
                $("#"+user_move).text(ai);
            } else {
                ai_move = predictAI(ai_pos);
                ai_pos.push(ai_move);
                console.log("checkWin-ai-pos: " + ai_pos);
                check = checkWin(ai_pos);
                if(check==true){
                    alert("Loser");
                    return false;
                }
                $("#"+ai_move).text(ai);
            }
        }
        console.log('position: '+position);
        console.log('user_pos: '+user_pos);
        console.log('ai_pos: '+ai_pos);
        console.log('user_move: '+user_move);
        console.log("-----------------");
    }
    $(document).ready(function () {
        $("#x").click(function (e) {
            user = 'x';
            ai = 'y';
            ai_pos.push("1-1");
            position.push("1-1");
            $("#1-1").text(ai);
            $("#myModal").modal('hide');
        });
        $("#y").click(function (e) {
            user = 'y';
            ai = 'x';
            position.push("1-1");
            ai_pos.push("1-1");
            $("#1-1").text(ai);
            $("#myModal").modal('hide');
        });
        $(".square").on('click', function (e) {
            play(this);
        })
    });
</script>

