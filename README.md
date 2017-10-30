# MetricsVisualizer

Metrics Visualizer is a Dashboard for Nultiple Organization and Layer Architecture Software Development.

Developed by CakePHP2.

# Installation

First, set up environment for cakePHP2 as official instruction 

[CakePHP](http://www.cakephp.org) - The rapid development PHP framework

Then, edit Database Setting in app/Config/database.php for your environment.

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

[Research Paper](http://www.washi.cs.waseda.ac.jp/?p=3160)
* Metrics visualization technique based on the origins and function layers for OSS-based development

[Demo Site](http://www.washi.cs.waseda.ac.jp/metrics-visualize-tool/graphs) 
* Login ID: reader
* password: guest
