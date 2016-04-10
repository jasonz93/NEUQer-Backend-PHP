<!DOCTYPE html>
<html lang="en" xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <title>微信签到</title>
    <script>
        var mpId = 'wxa1a6701c72bf29e1';
    </script>
<body id="app">
<router-view></router-view>
<script id="inject-script"></script>
<link id="inject-style" rel="stylesheet">


<script>
    var scriptNode = document.getElementById('inject-script');
    var styleNode = document.getElementById('inject-style');

    var request = new XMLHttpRequest();
    request.open('get', 'http://192.168.16.11:3001/wd');
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var resp = JSON.parse(request.responseText);
            scriptNode.setAttribute('src', 'http://7xow81.dl1.z0.glb.clouddn.com/' + resp.js);
            styleNode.setAttribute('href', 'http://7xow81.dl1.z0.glb.clouddn.com/' + resp.css);
        }
    }
    request.send()
</script>
</body>
</html>

