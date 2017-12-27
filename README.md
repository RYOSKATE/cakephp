# MetricsVisualizer <a href="http://doge.mit-license.org"><img src="http://img.shields.io/:license-mit-blue.svg"></a>

Metrics Visualizer is a Dashboard for Nultiple Organization and Layer Architecture Software Development.

Developed by CakePHP2.

# Installation

First, set up environment for cakePHP2 as official instruction 

[CakePHP](http://www.cakephp.org) - The rapid development PHP framework

Then, edit Database Setting in app/Config/database.php for your environment.

```
//app/Config/database.php
class DATABASE_CONFIG {
	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'root',
		'password' => 'root',
		'database' => 'visualizetool',
		'prefix' => '',
		//'encoding' => 'utf8',
	);
}
```

# Input Data

* Layer
* LayerPath
* MetricsList
* Organization

# Upload Data

* 1st column: filepath (e.g., kernel/drivers/base/power/wakeup.c
* 2nd ~ column: metrics value (e.g., LOC, Cyclomatic complexity)
* last column: Dev group separated by ; (semi-coron) (e.g., Camera Group;Browser Group; Map Group)


## Reference

Research Paper
* [Metrics visualization technique based on the origins and function layers for OSS-based development](http://www.washi.cs.waseda.ac.jp/?p=3160)
* [Metrics Visualization Techniques based on Historical Origins and Functional Layers for Developments by Multiple Organizations](http://www.worldscientific.com/doi/pdf/10.1142/S0218194018500067)

[Demo Site](http://www.washi.cs.waseda.ac.jp/metrics-visualize-tool/graphs) 
* Login ID: reader
* password: guest
