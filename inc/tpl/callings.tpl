{% extends 'default.tpl' %}
{% block title %}Calling List{% endblock %}
{% block right %}
    <ul id="navlist">
      {% for org in organizations %}
      <li><a href="#{{ org.name }}"></a></li>
      {% endfor %}
    </ul>
{% endblock %}
{% block left %}
  {% for org in organizations %}
    <a id="{{ org.name }}"></a>
    <div class="orgDiv">
      <h1>{{ org.name }}</h1>
      {% for leader in org.leaders %}
      {% if leader.length < 0 %}
      <div class="calling lengthUnfilled">
        <h1>{{ leader.name }}</h1>
        <p>OPEN</p>
      </div>
      {% else %}
      {% if leader.length > 63072000 %}
      <div class="calling lengthWarn">
      {% else %}
      <div class="calling lengthOkay">
      {% endif %}
      {% endif %}  
      {% if leader.length > 0 %}
        <h1>{{ leader.name }}</h1>
        <p class="name">{{ leader.person }}</p>
        <p class="sustained">Sustained: {{ leader.sustained }}</p>
        {% if leader.setApart == "Yes" %}
        <p class="setApart">Set Apart: {{ leader.setApart }}</p>
        {% else %}
        <p class="notSetApart">Set Apart: {{ leader.setApart }}</p>
        {% endif %}
      </div>
      {% endif %}
      {% endfor%}
      
      {% for calling in org.callings %}
      {% if calling.length < 0 %}
      <div class="calling lengthUnfilled">
        <h1>{{ calling.name }}</h1>
        <p>OPEN</p>
      </div>
      {% else %}
      {% if calling.length > 63072000 %}
      <div class="calling lengthWarn">
      {% else %}
      <div class="calling lengthOkay">
      {% endif %}
      {% endif %}  
      {% if calling.length > 0 %}
        <h1>{{ calling.name }}</h1>
        <p class="name">{{ calling.person }}</p>
        <p class="sustained">Sustained: {{ calling.sustained }}</p>
        {% if calling.setApart == "Yes" %}
        <p class="setApart">Set Apart: {{ calling.setApart }}</p>
        {% else %}
        <p class="notSetApart">Set Apart: {{ calling.setApart }}</p>
        {% endif %}
      </div>
      {% endif %}
      {% endfor%}
      <div class="clear"></div>
    </div>
  {% endfor %}
{% endblock %}
