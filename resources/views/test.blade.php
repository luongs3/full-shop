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

    function updateInventory(arr1, arr2) {
        // All inventory must be accounted for or you're fired!
        var i=0;
        var result = arr1.slice();
        arr2.map(function(value,index){
            for(i=0;i<arr1.length;i++){
                if(arr1[i][1]==value[1]){
                    result[i][0] += value[0];
                    break;
                }
            }
            if(i==arr1.length)
                result.push(value);
        });
//        sort
        result.sort(function(a,b){
            var str1 = a[1];
            var str2 = b[1];
            var len;
            if(str1.length>str2.length)
                len = str2.length;
            else len = str1.length;
            for(var i=0;i<len;i++) {
                if (str1.charCodeAt(i) > str2.charCodeAt(i))
                    return 1;
                else if (str1.charCodeAt(i) < str2.charCodeAt(i))
                    return -1;
            }
            if(i==len)
                return -1;
        });

        return result;
    }
    // Example inventory lists
    var curInv = [
        [21, "Bowling Ball"],
        [2, "Dirty Sock"],
        [1, "Hair Pin"],
        [5, "Microphone"]
    ];

    var newInv = [
        [2, "Hair Pin"],
        [3, "Half-Eaten Apple"],
        [67, "Bowling Ball"],
        [7, "Toothpaste"]
    ];
    console.log(updateInventory([], [[2, "Hair Pin"], [3, "Half-Eaten Apple"], [67, "Bowling Ball"], [7, "Toothpaste"]]));

</script>

