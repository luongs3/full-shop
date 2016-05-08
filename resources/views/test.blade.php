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

</div>
</body>
</html>


<script>
    var currency = [
        { name: 'ONE HUNDRED', val: 100.00},
        { name: 'TWENTY', val: 20.00},
        { name: 'TEN', val: 10.00},
        { name: 'FIVE', val: 5.00},
        { name: 'ONE', val: 1.00},
        { name: 'QUARTER', val: 0.25},
        { name: 'DIME', val: 0.10},
        { name: 'NICKEL', val: 0.05},
        { name: 'PENNY', val: 0.01}
    ];
    function checkCashRegister(price, cash, cid) {
        // Here is your change, ma'am.
        var sum = countMoney(cid);
        var refund, paid = [], i, temp;
        refund = cash - price;
        if(refund>sum)
            return "Insufficient Funds";
        else if(refund==sum)
            return "Closed";
        cid = convert(cid);
        for(i=cid.length-1;i>-1;i--){
            temp = refund;
                while(refund>=cid[i][0] && cid[i][1]>=cid[i][0]){
                    refund = Math.round((refund - cid[i][0])*100)/100;
                    cid[i][1] = cid[i][1] - cid[i][0];
                }
            cid[i][1] = Math.round((temp - refund)*100)/100;
            if(refund==0){
                paid.push(cid[i]);
                break;
            }
            else if(temp > refund){
                paid.push(cid[i]);
            }
        }
        if(refund>0)             return "Insufficient Funds";
                return revert(paid);
    }
    function countMoney(cid){
        var sum=0;
        cid.map(function(value,index){
            sum+= value[1];
        });
        return sum;
    }
    function convert(cid){
        var new_cid=[];
        cid.map(function(value,index){
            new_cid.push([findCurrency(value[0]),value[1]]);
        });
        return new_cid;
    }
    function findCurrency(name){
        for(var key in currency){
            if(currency[key].name==name){
                return currency[key].val;
            }
        }
    }
    function revert(cid){
        var new_cid=[];
        cid.map(function(value,index){
            new_cid.push([findCurrency1(value[0]),value[1]]);
        });
        return new_cid;
    }

    function findCurrency1(val){
        for(var key in currency){
            if(currency[key].val==val){
                return currency[key].name;
            }
        }
    }


    console.log(checkCashRegister(19.50, 20.00, [["PENNY", 0.01], ["NICKEL", 0], ["DIME", 0], ["QUARTER", 0], ["ONE", 1.00], ["FIVE", 0], ["TEN", 0], ["TWENTY", 0], ["ONE HUNDRED", 0]]));


</script>

