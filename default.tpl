<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>{% block title %}Ward Callings{% endblock %}</title>
<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600" rel="stylesheet" type="text/css">
<link href="/inc/css/style.css" rel="stylesheet" type="text/css" />
<link href="/inc/css/print.css" rel="stylesheet" type="text/css" media="print" />
</head>
<body>
<div id="wrapper">
  <div id="right">
    {% block navlist %}
    <ul id="navlist">
      <li><a href="#Bishopric">Bishopric</a></li>
      <li><a href="#HighPriests">High Priests</a></li>
    </ul>
    {% endblock %}
  </div>
  <div id="left">
    {% block content %}
    <a id="Organization"></a>
    <div class="orgDiv">
      <h1>Organization</h1>
      <div class="calling lengthOkay">
        <h1>Calling</h1>
        <p class="name">Name</p>
        <p class="sustained">Sustained: dd/mm/yyyy</p>
        <p class="setApart">Set Apart</p>
      </div>
      <div class="clear"></div>
    </div>
    {% endblock %}
  </div>
  <div class="clear"></div>
</div>
</body>
</html>