# Fibonacci

Draw Fibonacci trees (hierarchical tree and radial tree) using [D3.js] (https://github.com/d3).

## Installation

There is no instalation needed to use the library in your code. It is written in vanilla JS (using ES6 syntax) and consists of two files `tree-generator.min.js` and `fibonacci-tree.min.js`. In your HTML file you need include three [D3.js] (https://github.com/d3) libraries first and then two mentioned files from `fibonacci` folder:

```html
    <script src="https://d3js.org/d3.v5.min.js"></script>
    <script src="https://d3js.org/d3-dsv.v1.min.js"></script>
    <script src="https://d3js.org/d3-fetch.v1.min.js"></script>
    <script src="fibonacci/tree-generator.min.js"></script>
    <script src="fibonacci/fibonacci-tree.min.js"></script>
```

Complete example can be found in [index.html] (/index.html) file. However to run the example you need a server. It can be any server of your choice. Simple [http-server] (https://github.com/http-party/http-server) is referenced in the project. To install it just run

    npm install

in the project root directory to install the server (you need to have [Node.js] (https://nodejs.org) already installed).

To start the server use

    npm run start

Now you can visit http://localhost:8080 to view the example.

Note: The server is in fact used just to allow importing of tree data from CSV or JSON file.

## Usage

Fibonacci tree can be included into a webpage for example the following way:  

```html
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Radial tree</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://d3js.org/d3.v5.min.js"></script>
    <script src="https://d3js.org/d3-dsv.v1.min.js"></script>
    <script src="https://d3js.org/d3-fetch.v1.min.js"></script>
    <script src="fibonacci/tree-generator.min.js"></script>
    <script src="fibonacci/fibonacci-tree.min.js"></script>
</head>

<body>
    <h1>Radial tree</h1>
    <div class="fibonacci">
        <svg class="fibonacci__svg" width="900" height="900"></svg>
        <div class="fibonacci__tooltip"></div>
    </div>
    <script>
        const toNodeData = (d) => ({
            id: +d.id,
            accountNo: d.cbm_account_num,
            userId: d.user_id,
            email: d.email,
            lchild: +d.lchild,
            rchild: +d.rchild,
        });

        const svg = d3.select(".fibonacci__svg")
            .call(d3.zoom().on("zoom", () =>
                svg.select("g").attr("transform", d3.event.transform)));
        const tooltip = d3.select(".fibonacci__tooltip");

        d3.csv("sample-data.csv", toNodeData).then(data =>
            new FibonacciTree(data, svg, tooltip, { levels: 12, isRadial: true })
        );
    </script>
</body>

</html>
```

Fibonacci tree is rendered inside SVG element: 
```html
<svg class="fibonacci__svg" width="900" height="900"></svg>
```
Note that you can set dimensions of the resulted image here (in pixels).

To disable zoom and panning of the tree you need to delete (or comment) lines
```js
.call(d3.zoom().on("zoom", () =>
    svg.select("g").attr("transform", d3.event.transform)));
```

Calling function 
```js
d3.csv("sample-data.csv", toNodeData)
```
imports data from CSV file. You can also import data from JSON file using
```js
d3.json("sample-data.json", toNodeData)
```
Identifiers (variable names) used in the data file are converted using `toNodeData` function to those expected by Fibonacci library.

## Configuration

Fibonaccit tree configuration object is passed as a fourth parameter to the constructor of `FibonacciTree` class. For examle if you want to draw 12 levels of radial tree you can use: 
```js
new FibonacciTree(data, svg, tooltip, { levels: 12, isRadial: true })
```

Default configuration values are:
```js
{
    isRadial: true,
    levels: 12,
    margin: { x: 0, y: 0 }
}
```

To draw hierarchical tree just use `isRadial: false`. You can also set horizontal and vertical margin around the tree (such margin is inside SVG element), for example `margin: { x: 60, y: 40 }` means horizontal margin 60 px and vertical margin 40 px.

To configure style of tree nodes and lines (colour, line strength, etc.) just edit CSS file (`style.css`) that is included in the project.

