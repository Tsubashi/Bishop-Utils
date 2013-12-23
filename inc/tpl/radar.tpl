{% extends 'default.tpl' %}
{% block title %}{{ title }}{% endblock %}
{% block extrahead %}
<link href="/inc/css/radar.css" rel="stylesheet" type="text/css" />
{% endblock %}
{% block right %}
    <form method="GET" action="{{ depth.submit }}">
      <fieldset>
        <legend>Change Range (Months)</legend>
        <label>Future:</label><input type="text" name="depth" value="{{ depth.future }}" />
        <label>Past:</label><input type="text" name="past_depth" value="{{ depth.past }}" />
        <br />
        <label>Show Bishopric? <label><input type="checkbox" name="bishopric" value="true" {{ depth.bishopricChecked }} />
        <br />
        <input type="submit" value="GO!" />
      </fieldset>
    </form>
{% endblock %}
{% block left %}
    <div id="list">
      <h1 id="radarTitle"><span id="radarLogo"></span>Bishop's Radar</h1>
      <ul>
        {% for item in items %}
        <li>
          <span class="itemType type_{{ item.class }}">[{{ item.type }}]</span>
          <span class="itemDate date_{{ item.class }}">{{ item.dateString }}</span> - 
          <span class="itemName name_{{ item.class }}">{{ item.name }}</span></li>
        {% endfor %}
      </ul>
    </div>
{% endblock %}
