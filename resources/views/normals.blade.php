@extends('layouts.master')

@section('title', '30-year Normals')

@section('navbar-type', 'fixed-top')


@section('content')

<div class="container" style="min-height: 650px;">
  <h3>1981-2010 Climate Normals</h3>
  <div style="width: 100%; overflow:scroll;">
    <table class="table-bordered table-hover" style="width: 100%;">
  			<tbody>
        <tr>
  				<th style="text-align: center;">Variable</th>
  				<th colspan="13" style="text-align: center;" >Month</th>
  			</tr>
  			<tr>
  				<th>&nbsp;&nbsp;</th>
  				<th style="text-align: center;">Jan</th>
  				<th style="text-align: center;">Feb</th>
  				<th style="text-align: center;">Mar</th>
  				<th style="text-align: center;">Apr</th>
  				<th style="text-align: center;">May</th>
  				<th style="text-align: center;">Jun</th>
  				<th style="text-align: center;">Jul</th>
  				<th style="text-align: center;">Aug</th>
  				<th style="text-align: center;">Sep</th>
  				<th style="text-align: center;">Oct</th>
  				<th style="text-align: center;">Nov</th>
  				<th style="text-align: center;">Dec</th>
  				<th style="text-align: center;">Annual</th>
  			</tr>
  			<tr style="padding-top: 5px;">
  				<td><b>Avg. Maximum Temperature (°F)</b></td>
  				<td>33.3</td>
  				<td>37.7</td>
  				<td>45.1</td>
  				<td>57.5</td>
  				<td>67.4</td>
  				<td>76.7</td>
  				<td>81.6</td>
  				<td>80.0</td>
  				<td>72.6</td>
  				<td>60.8</td>
  				<td>49.3</td>
  				<td>38.3</td>
  				<td>58.5</td>
  			</tr>
  			<tr style="padding-top: 5px;">
  				<td><b>Avg. Minimum Temperature (°F)</b></td>
  				<td>14.3</td>
  				<td>17.1</td>
  				<td>23.8</td>
  				<td>33.9</td>
  				<td>44.0</td>
  				<td>54.4</td>
  				<td>60.0</td>
  				<td>58.3</td>
  				<td>50.0</td>
  				<td>38.2</td>
  				<td>30.2</td>
  				<td>20.1</td>
  				<td>37.1</td>
  			</tr>
  			<tr style="padding-top: 5px;">
  				<td><b>Average Temperature (°F)</b></td>
  				<td>23.8</td>
  				<td>27.4</td>
  				<td>34.4</td>
  				<td>45.7</td>
  				<td>55.7</td>
  				<td>65.6</td>
  				<td>70.8</td>
  				<td>69.2</td>
  				<td>61.3</td>
  				<td>49.5</td>
  				<td>39.8</td>
  				<td>29.2</td>
  				<td>47.8</td>
  			</tr>
  			<tr style="padding-top: 5px;">
  				<td><b>Heating Degree Days</b></td>
  				<td>1276</td>
  				<td>1053</td>
  				<td>947</td>
  				<td>580</td>
  				<td>297</td>
  				<td>68</td>
  				<td>7</td>
  				<td>21</td>
  				<td>147</td>
  				<td>482</td>
  				<td>758</td>
  				<td>1109</td>
  				<td>6744</td>
  			</tr>
  			<tr style="padding-top: 5px;">
  				<td><b>Cooling Degree Days</b></td>
  				<td>0</td>
  				<td>0</td>
  				<td>0</td>
  				<td>0</td>
  				<td>9</td>
  				<td>84</td>
  				<td>186</td>
  				<td>149</td>
  				<td>360</td>
  				<td>1</td>
  				<td>0</td>
  				<td>0</td>
  				<td>465</td>
  			</tr>
  			<tr style="padding-top: 5px;">
  				<td><b>Total Precipitation (in.)</b></td>
  				<td>3.27</td>
  				<td>3.43</td>
  				<td>4.48</td>
  				<td>4.40</td>
  				<td>4.04</td>
  				<td>4.18</td>
  				<td>3.74</td>
  				<td>3.58</td>
  				<td>3.94</td>
  				<td>4.40</td>
  				<td>4.47</td>
  				<td>4.21</td>
  				<td>48.18</td>
  			</tr>
  			<tr style="padding-top: 5px;">
  				<td><b>Total Snowfall* (in.)</b></td>
  				<td>21.2</td>
  				<td>16.1</td>
  				<td>14.7</td>
  				<td>2.4</td>
  				<td>0</td>
  				<td>0</td>
  				<td>0</td>
  				<td>0</td>
  				<td>0</td>
  				<td>0.1</td>
  				<td>2.4</td>
  				<td>20.1</td>
  				<td>72.4</td>
  			</tr>
  		</tbody>
    </table>
  </div>
	*Based on 2003-2010 Normals
</div>

@endsection
