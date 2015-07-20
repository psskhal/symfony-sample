

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html style="overflow:hidden;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    

<base href="http&#58;&#47;&#47;co113w.col113.mail.live.com&#47;mail&#47;TodayLight.aspx&#63;layout&#61;TodayDefault&#38;rru&#61;&#38;n&#61;888412693" />

<script type="text/javascript">
    
    
    var isPersistenceInline = false, redirectUrl = 'http\x3a\x2f\x2fco113w.col113.mail.live.com\x2fmail\x2fTodayLight.aspx\x3flayout\x3dTodayDefault\x26rru\x3d\x26n\x3d888412693';
    
    
    var domainLoweringIsDown = false;
    document.domain = "live.com";
    
    if (window.top != self)
    {
        var hostname = "";
        try
        {
            hostname = window.top.location.hostname;
        }
        catch(e)
        {
            hostname = "";
        }

        var mailUrlDomain = "mail.live.com";
        var peopleUrlDomain = "people.live.com";
        var hasMailUrl = (hostname != "") &&
            (hostname.indexOf(mailUrlDomain) != -1) &&
            ((hostname.indexOf(mailUrlDomain) + mailUrlDomain.length) == hostname.length);
        var hasPeopleUrl = (hostname != "") &&
            (hostname.indexOf(peopleUrlDomain) != -1) &&
            ((hostname.indexOf(peopleUrlDomain) + peopleUrlDomain.length) == hostname.length);
        if (!hasMailUrl && !hasPeopleUrl)
        {
            window.top.location.href = self.location.href;
        }
        else
        {
            self.location.href = 'http\x3a\x2f\x2fco113w.col113.mail.live.com\x2fmail\x2fTodayLight.aspx\x3flayout\x3dTodayDefault\x26rru\x3d\x26n\x3d888412693';
        }
    }
    else if (domainLoweringIsDown) 
    {
        if (self.location.hostname.indexOf("mail.live.com") <= 0)
        {
            document.cookie = "afu=" + escape('http\x3a\x2f\x2fco113w.col113.mail.live.com\x2fmail\x2fTodayLight.aspx\x3flayout\x3dTodayDefault\x26rru\x3d\x26n\x3d888412693') + ";path=/;domain=.mail.live.com;";
            self.location.href = 'co113w.col113.mail.live.com'; 
        }
    }


    var gLoadIM = true,
        gUIFrameBaseUrl = "";
    function loadIM(q)
    {
        if (gLoadIM &&
            (!q || q.indexOf('nwi=1') < 0)) 
        {
            gLoadIM = false;
            var win = getUiWindow(), loc = win.location;
            gUIFrameBaseUrl = loc.host;
            var imFrame = document.getElementById("IMFrame");
            if (imFrame)
            {
                imFrame.src = [loc.protocol, "//", gUIFrameBaseUrl, "/im/pages/im.aspx"].join("");
            }
            imFrame = null;
        }
   }


    function uiFrameLoad()
    {
        //
        try
        {
            if(!isPersistenceInline)
            {
                document.title = window.frames[0].document.title;
            }

            if (gLoadIM)
            {
                loadIM(getUiWindow().location.search); 
            }

        }
        catch(e)
        {
        }
    }
    function beforeUnloadHandler()
    {
        try
        {
            var frameUrl = getUiWindow().document.location.href;
            document.cookie = "afu=" + escape(frameUrl) + ";path=/;domain=.mail.live.com;";
        }
        catch(e)
        {
        }
    }
    function getUiFrame()
    {
        return document.getElementById("UIFrame");
    }
    function getUiFrameOrBody()
    {
        return isPersistenceInline ? document.body : getUiFrame();
    }
    function getUiWindow()
    {
        return isPersistenceInline ? window : getUiFrame().contentWindow;
    }
    function makePersistenceStandalone()
    {
        isPersistenceInline = false;

        var imFrame = document.getElementById("IMFrame");
        if(imFrame && imFrame.contentWindow.updateUIFrameRef)
        {
            imFrame.contentWindow.updateUIFrameRef();
        }

    }
    function redirectToLandingPage()
    {
        if(!isPersistenceInline)
        {
            getUiFrame().src = 'http\x3a\x2f\x2fco113w.col113.mail.live.com\x2fmail\x2fTodayLight.aspx\x3flayout\x3dTodayDefault\x26rru\x3d\x26n\x3d888412693';
        }
    }
</script>

</head>
<body style="padding:0;margin:0;overflow:visible;height:100%;width:100%;position:absolute;" onbeforeunload="beforeUnloadHandler()">
    
<div id="appDiv" style="position:absolute;height:100%;width:100%;">
    <iframe id="UIFrame" name="UIFrame"  src="http&#58;&#47;&#47;co113w.col113.mail.live.com&#47;mail&#47;TodayLight.aspx&#63;layout&#61;TodayDefault&#38;rru&#61;&#38;n&#61;888412693" onload="uiFrameLoad();"
        frameborder="0"
        width="100%"
        height="100%"
        marginheight="0"
        marginwidth="0">
    </iframe>

    <iframe id="IMFrame" frameborder="0" width="0" height="0" src=""></iframe>

</div>

</body>
</html>
