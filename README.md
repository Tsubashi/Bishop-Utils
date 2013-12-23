Bishop-Utils
============
Simple MLS Data visualization utilities for LDS Bishops. Developed during my time as an executive secretary. 

Overview
--------
These PHP utilities are written to use the csv data that can be exported from MLS by admin users. MLS output files should be placed in the data folder. Script output is always HTML. Due to the sensitive nature of this data, be sure to secure these pages with adequate authentication measures. 

Calling Visualizer
------------------
The Calling Visualizer lists all callings grouped by organization. Callings are displayed as boxes, and are colored according to the length of time a calling has been filled.

- <span style="color: green">Green</span>  = Filled
- <span style="color: yellow">Yellow</span> = Filled by the same person for more than 2 years
- <span style="color: red">Red</span>    = Unfilled

Each box contains the Position's name, the name of the person filling the calling, the date they were sustained, and whether they have been set apart. The last item is displayed in read if they have not been set apart, and green if they have. Leadership positions are displayed first, followed by an alphabatized list of all other callings. 

Bishop's Radar
--------------
The Bishop's Radar utility was designed to help keep in memory items that we found we often missed such as youth advancement interviews, baptism interviews, and quarterly reports. reviewing this list weekly in bishopric meeting mitigated these problems. 
The report displays a list of recent and upcoming items, colored according to the type of item.

- <span style="color: orange">Orange</span> = Advancement
- <span style="color: blue">Blue</span> = Baptism
- <span style="color: grey">Grey</span> = Notes
- <span style="color: black">Black</span> = Reports
- <span style="color: black">Green</span> = Bishop's Interviews
- <span style="color: black">Purple</span> = Counselor Interviews
