<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Agregar Factura de Compras</title>
    <?php session_start(); require 'menu/css_lte.ctp'; ?>
    <style>
        .form-group { margin-top: 15px; }
        .control-label { font-weight: bold; }
        .table th, .table td { text-align: center; vertical-align: middle; }
        .table th { background-color: #f4f4f4; }
        .table { margin-top: 15px; }
        .row { margin-bottom: 15px; }
        .form-horizontal .col-lg-3, .form-horizontal .col-lg-6 { margin-bottom: 15px; }

        .title-container {
    display: flex;
    align-items: center; /* Alinea el SVG y el título verticalmente */
    gap: 10px; /* Espaciado entre la imagen y el título */
}

.icon {
    width: 24px; /* Ajusta el tamaño del SVG */
    height: auto; /* Mantén las proporciones */
}

.title {
    font-size: 2.5rem; /* Ajusta el tamaño del título */
    margin: 0; /* Elimina márgenes innecesarios */
}

    #vdep_cod {
        margin-top: -0px; /* Ajusta este valor según necesites */
    }




    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>

        <div class="content-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary">
                            <div class="box-header">
                            <div class="title-container">
    <!-- Ícono SVG -->
    <svg
   width="64pt" height="64pt" viewBox="0 0 22.577778 22.577778" version="1.1" id="svg831" inkscape:version="1.1.2 (1:1.1+202202050950+0a00cf5339)" sodipodi:docname="29 - Invoice.svg"
   inkscape:export-filename="/media/taufikramadhan/Data/Tr Design Studio/Project Design/TR Creative Design/Icon Design/Project Hiring/Icon Icons/019 - Commerce And Shopping/5 - Send/29 - Invoice.png" inkscape:export-xdpi="576" inkscape:export-ydpi="576" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
   xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
   xmlns="http://www.w3.org/2000/svg"  xmlns:svg="http://www.w3.org/2000/svg" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"  xmlns:cc="http://creativecommons.org/ns#"  xmlns:dc="http://purl.org/dc/elements/1.1/"> <defs
     id="defs825"> <pattern id="EMFhbasepattern" patternUnits="userSpaceOnUse" width="6" height="6" x="0" y="0" /><pattern
       id="EMFhbasepattern-9"  patternUnits="userSpaceOnUse"  width="6"  height="6"  x="0"  y="0" /> <pattern id="EMFhbasepattern-0" patternUnits="userSpaceOnUse" width="6" height="6" x="0"
       y="0" /> <pattern id="EMFhbasepattern-7" patternUnits="userSpaceOnUse" width="6" height="6" x="0" y="0" /><pattern  id="EMFhbasepattern-2"  patternUnits="userSpaceOnUse" width="6"  height="6"  x="0"   y="0" /> <pattern
       id="EMFhbasepattern-98" patternUnits="userSpaceOnUse" width="6" height="6" x="0" y="0" /><pattern id="EMFhbasepattern-6" patternUnits="userSpaceOnUse" width="6" height="6" x="0"y="0" />
    <pattern id="EMFhbasepattern-01" patternUnits="userSpaceOnUse" width="6"  height="6" x="0" y="0" /><pattern id="EMFhbasepattern-07"
       patternUnits="userSpaceOnUse" width="6" height="6" x="0" y="0" /> <pattern    id="EMFhbasepattern-8"  patternUnits="userSpaceOnUse"  width="6"  height="6"  x="0"  y="0" /><pattern id="EMFhbasepattern-4" patternUnits="userSpaceOnUse" width="6"   height="6" x="0" y="0" /><pattern   id="EMFhbasepattern-40"
       patternUnits="userSpaceOnUse"  width="6"  height="6"  x="0"  y="0" /><pattern  id="EMFhbasepattern-08" patternUnits="userSpaceOnUse" width="6"height="6"x="0"y="0" />
    <pattern id="EMFhbasepattern-04" patternUnits="userSpaceOnUse" width="6" height="6" x="0" y="0" /> <pattern    id="EMFhbasepattern-014" patternUnits="userSpaceOnUse" width="6"
       height="6" x="0" y="0" /><pattern   id="EMFhbasepattern-27"   patternUnits="userSpaceOnUse"   width="6"   height="6"   x="0"y="0" /><pattern
       id="EMFhbasepattern-09"   patternUnits="userSpaceOnUse"   width="6"   height="6"   x="0"   y="0" /><pattern  id="EMFhbasepattern-5"  patternUnits="userSpaceOnUse"  width="6"  height="6"  x="0"  y="0" /><pattern
       id="EMFhbasepattern-018"  patternUnits="userSpaceOnUse"  width="6"  height="6"  x="0"  y="0" /></defs><sodipodi:namedview   id="base"pagecolor="#ffffff" bordercolor="#666666" borderopacity="1.0" inkscape:pageopacity="0.0" inkscape:pageshadow="2" inkscape:zoom="4.4249417" inkscape:cx="19.322288"
     inkscape:cy="47.232261" inkscape:document-units="pt" inkscape:current-layer="layer1" showgrid="false" units="pt" inkscape:window-width="1366" inkscape:window-height="705" inkscape:window-x="0"
     inkscape:window-y="31" inkscape:window-maximized="1" inkscape:pagecheckerboard="true" inkscape:showpageshadow="false" inkscape:object-paths="true"  inkscape:snap-intersection-paths="true"  inkscape:snap-smooth-nodes="true"inkscape:snap-midpoints="true"showguides="true"inkscape:snap-bbox="true"inkscape:bbox-nodes="true"inkscape:snap-nodes="false" inkscape:snap-global="true"
     inkscape:document-rotation="0"> <inkscape:grid   type="xygrid"   id="grid1378" /><sodipodi:guide   position="0.97013831,21.607643"   orientation="78.000048,0"   id="guide1380"   inkscape:locked="false" /><sodipodi:guide position="0.97013831,0.97013129" orientation="0,78.000005"
       id="guide1382" inkscape:locked="false" /> <sodipodi:guide    position="21.607639,0.97013129"    orientation="-78.000048,0"    id="guide1384"
       inkscape:locked="false" /> <sodipodi:guide  position="21.607639,21.607643"  orientation="0,-78.000005"  id="guide1386"  inkscape:locked="false" /></sodipodi:namedview><metadata   id="metadata828">  <rdf:RDF> <cc:Work  rdf:about=""> <dc:format>image/svg+xml</dc:format> <dc:type
           rdf:resource="http://purl.org/dc/dcmitype/StillImage" />  </cc:Work></rdf:RDF></metadata><g   inkscape:label="Icon"   inkscape:groupmode="layer"
     id="layer1" transform="translate(0,-274.42223)"><g  id="g236484"  style="display:inline;stroke-width:0.794904"  transform="matrix(1.2580135,0,0,1.2580135,-76.108606,159.94028)">
     <path
         style="color:#000000;fill:#d0e2ee;stroke-width:0.794904;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;-inkscape-stroke:none"
         d="m 75.160157,107.45475 c 0,-2.39607 -0.199219,-12.255821 -0.199219,-14.888314 -5.17e-4,-0.146171 -0.119455,-0.264234 -0.265625,-0.263672 l -11.970704,-3e-5 c -0.137454,-7e-6 -0.252025,0.105229 -0.263672,0.242188 -0.169822,2.082914 0.09957,4.546221 0.232422,6.876953 0.132849,2.330735 0.120017,4.525875 -0.535156,6.017575 l 0.01172,-0.0234 c -0.151553,0.26856 -0.238283,0.58088 -0.238281,0.91015 0,1.01972 0.83184,1.85156 1.851562,1.85156 l 10.734883,-0.006 c 0.318463,0 0.64207,-0.41099 0.64207,-0.71701 z"
         id="path767739" sodipodi:nodetypes="cccccsccsscc" />
      <path id="path225727" style="color:#000000;fill:#a8c2e1;fill-opacity:1;stroke-width:3.00436;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;-inkscape-stroke:none"
         d="m 274.70703,348.86133 c -1.46104,1.76595 -2.3418,4.0302 -2.3418,6.49414 0,5.62383 4.58126,10.21484 10.20508,10.21484 0.31158,0 0.61921,-0.0174 0.92383,-0.0449 -0.10045,-6.71324 -0.17773,-12.57181 -0.17773,-15.66797 -0.002,-0.55246 -0.45146,-0.99822 -1.00391,-0.99609 z"
         transform="scale(0.26458334)" />
      <path
         style="color:#000000;fill:#fd913c;stroke-width:0.794904;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;-inkscape-stroke:none"
         d="m 71.589844,93.361328 c -1.238931,0 -2.25,1.009117 -2.25,2.248047 0,1.23893 1.011069,2.25 2.25,2.25 1.23893,0 2.248047,-1.01107 2.248047,-2.25 0,-1.23893 -1.009117,-2.248047 -2.248047,-2.248047 z"
         id="path767745" />
      <path
         style="color:#000000;fill:#91a9d9;stroke-width:0.794904;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;-inkscape-stroke:none"
         d="m 64.3125,105.00195 a 0.26460996,0.26460996 0 0 0 -0.259766,0.26563 0.26460996,0.26460996 0 0 0 0.259766,0.26367 c 0.441507,0 0.794935,0.35342 0.794922,0.79492 -1.6e-5,0.73373 -0.590478,1.32226 -1.324219,1.32227 a 0.26464844,0.26464844 0 0 0 0,0.52929 h 10.583984 c 1.019723,0 1.851541,-0.83184 1.851563,-1.85156 2.2e-5,-0.72749 -0.594771,-1.32422 -1.322266,-1.32422 z"
         id="path767757" />
      <path
         id="path179466"
         style="fill:#fd750d;fill-opacity:1;stroke-width:3.00436;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5"
         d="m 272.65625,353.11914 c -0.16386,0.72083 -0.25,1.47002 -0.25,2.23828 0,4.109 2.47484,7.67565 6.00781,9.27539 0.42301,-1.00895 0.65821,-2.11587 0.65821,-3.27539 0,-3.96502 -2.73498,-7.30707 -6.41602,-8.23828 z"
         transform="scale(0.26458334)" />
      <path
         style="color:#000000;fill:#fd913c;stroke-width:0.794904;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;-inkscape-stroke:none"
         d="m 74.763672,91.773437 c -1.23893,10e-7 -2.248047,1.009117 -2.248047,2.248047 0,1.238931 1.009117,2.25 2.248047,2.25 1.23893,0 2.25,-1.011069 2.25,-2.25 0,-1.23893 -1.01107,-2.248046 -2.25,-2.248047 z"
         id="path767763" />
      <path
         style="color:#000000;fill:#4895ef;stroke-width:0.420637;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;-inkscape-stroke:none"
         d="m 64.048385,93.625259 h 2.116667 c 0.146579,0 0.264584,0.118005 0.264584,0.264584 v 1.5875 c 0,0.146579 -0.118005,0.264583 -0.264584,0.264583 h -2.116667 c -0.146579,0 -0.264583,-0.118004 -0.264583,-0.264583 v -1.5875 c 0,-0.146579 0.118004,-0.264584 0.264583,-0.264584 z"
         id="path767791" />
      <path
         style="color:#000000;fill:#4895ef;stroke-width:0.794904;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;-inkscape-stroke:none"
         d="m 64.048828,93.890625 h 2.117188 v 1.585937 h -2.117188 z"
         id="path768181" />
      <path
         style="color:#000000;fill:#4895ef;stroke-width:0.794904;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;-inkscape-stroke:none"
         d="m 64.048828,93.361328 c -0.288582,0 -0.529297,0.240716 -0.529297,0.529297 v 1.585937 c 0,0.288582 0.240716,0.529297 0.529297,0.529297 h 2.117188 c 0.288581,0 0.527343,-0.240714 0.527343,-0.529297 v -1.585937 c 0,-0.288583 -0.238761,-0.529297 -0.527343,-0.529297 z"
         id="path767793" />
      <path
         id="path650143"
         style="color:#000000;fill:#91a9d9;stroke-width:3.00436;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;-inkscape-stroke:none"
         d="m 237.07031,348.86133 c -0.51951,-3e-5 -0.95402,0.39642 -0.99804,0.91406 -5.5e-4,0.007 5.4e-4,0.0166 0,0.0234 v 0.008 c -0.01,0.12131 -0.0183,0.24326 -0.0274,0.36524 -0.0158,0.21313 -0.0295,0.42744 -0.043,0.64257 -0.02,0.31806 -0.0376,0.63873 -0.0527,0.96094 -0.0117,0.24918 -0.0223,0.49846 -0.0312,0.75 -0.004,0.0979 -0.009,0.19473 -0.0117,0.29297 -0.0807,2.56063 -0.0253,5.23866 0.0977,7.97266 0.0246,0.5468 0.0525,1.09557 0.082,1.64648 0.0296,0.55091 0.0602,1.10412 0.0937,1.6582 0.0335,0.55409 0.0691,1.1097 0.10547,1.66602 0.21814,3.33789 0.47794,6.70621 0.66601,10.00586 0.0314,0.55057 0.0613,1.09849 0.0879,1.64453 3e-5,6.5e-4 -3e-5,10e-4 0,0.002 0.0798,1.63745 0.13573,3.2522 0.15625,4.83008 1e-5,6.5e-4 -1e-5,10e-4 0,0.002 0.0137,1.05166 0.0121,2.08684 -0.01,3.10157 -2e-5,6.4e-4 10e-6,10e-4 0,0.002 -0.0109,0.50701 -0.0277,1.00964 -0.0488,1.50586 -0.0212,0.49686 -0.0477,0.98765 -0.0801,1.47265 -0.0323,0.48435 -0.0709,0.96408 -0.11523,1.43555 -6e-5,6.4e-4 6e-5,0.001 0,0.002 -0.0222,0.23539 -0.045,0.4692 -0.0703,0.70118 -7e-5,6.4e-4 7e-5,10e-4 0,0.002 -0.33053,3.02331 -0.9376,5.75305 -1.94336,8.04297 -0.12393,0.22714 -0.23918,0.45915 -0.33789,0.70117 -2.2e-4,5.5e-4 2.3e-4,0.001 0,0.002 -0.2778,0.68165 -0.45158,1.41743 -0.50195,2.1836 -4e-5,6.5e-4 4e-5,0.001 0,0.002 -0.01,0.15273 -0.0156,0.30798 -0.0156,0.46289 0,0.6022 0.0765,1.1859 0.2207,1.74414 1.6e-4,6.1e-4 -1.6e-4,0.001 0,0.002 0.0576,0.22266 0.1266,0.44069 0.20508,0.65429 2.1e-4,5.8e-4 -2.1e-4,0.001 0,0.002 0.47225,1.28438 1.31281,2.39424 2.39062,3.20118 0.17972,0.13455 0.3662,0.26179 0.5586,0.3789 0.0962,0.0586 0.19382,0.11399 0.29296,0.16797 0.29743,0.16194 0.60646,0.30384 0.92774,0.42188 0.74964,0.27541 1.55927,0.42578 2.40234,0.42578 a 1.0000006,1.0000006 0 0 0 1.00391,-1.00391 1.0000006,1.0000006 0 0 0 -1.00391,-0.99609 c -2.77319,0 -4.99804,-2.22486 -4.99804,-4.99805 0,-0.89544 0.23366,-1.73437 0.64257,-2.45898 a 1.0001006,1.0001006 0 0 0 0.0449,-0.0879 c 2.75534,-6.27338 2.69167,-14.77842 2.18554,-23.65821 -0.50613,-8.87978 -1.49623,-18.14681 -0.8789,-25.71875 a 1.0001006,1.0001006 0 0 0 0.008,-0.0234 l 0.0586,-1.05469 z"
         transform="scale(0.26458334)" />
      <path
         id="path194975"
         style="color:#000000;fill:#4377d1;fill-opacity:1;stroke-width:0.794904;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;-inkscape-stroke:none"
         d="m 64.048806,93.361229 c -0.288581,0 -0.529167,0.240586 -0.529167,0.529167 h 2.117183 c 0.288583,0 0.527616,0.240583 0.527616,0.529167 v 1.586465 h 0.0016 c 0.288581,0 0.527617,-0.241099 0.527617,-0.529683 v -1.585949 c 0,-0.288584 -0.239033,-0.529167 -0.527617,-0.529167 z" />
      <path
         style="color:#000000;fill:#d0e2ee;fill-opacity:1;stroke-width:0.794904;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;-inkscape-stroke:none"
         d="m 64.31315,105.53189 c 0.439332,0 0.785615,0.35062 0.789063,0.78907 l -0.04492,0.26953 h -1.273438 c -0.149263,0 -0.263671,-0.11637 -0.263671,-0.26563 0,-0.4415 0.351462,-0.79297 0.792968,-0.79297 z"
         id="path205439" />
    </g>
    <path
       id="path177774"
       style="color:#000000;display:inline;fill:#000000;stroke-width:1;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;-inkscape-stroke:none"
       d="m 17.945228,275.39245 c -1.558594,0 -2.82857,1.26998 -2.82857,2.82857 0,0.85853 0.385528,1.62997 0.992047,2.14987 -0.07772,1.12708 -1.0089,2.01206 -2.156371,2.01206 -1.19882,0 -2.16482,-0.96601 -2.16482,-2.16483 0,-1.19881 0.966,-2.16222 2.16482,-2.16221 0.183892,-6.7e-4 0.332272,-0.15027 0.33155,-0.33416 -6.65e-4,-0.18292 -0.148616,-0.33092 -0.33155,-0.33154 -1.558591,0 -2.830518,1.26932 -2.830518,2.82791 0,1.55859 1.271927,2.83053 2.830518,2.83053 1.36876,0 2.513862,-0.98074 2.772661,-2.27534 0.369673,0.17794 0.783641,0.27824 1.220233,0.27824 1.558591,0 2.830518,-1.27192 2.830518,-2.83053 0,-1.55859 -1.271927,-2.82857 -2.830518,-2.82857 z m -14.5212018,9.58502 c -0.1624196,-2.84959 -0.4447996,-5.785 -0.2827914,-8.25297 H 14.733758 c 0.183892,-6.6e-4 0.332272,-0.15025 0.331548,-0.33415 -6.67e-4,-0.18293 -0.148618,-0.33092 -0.331548,-0.33155 l -11.9338311,10e-6 c -0.1729177,-10e-6 -0.317544,0.13194 -0.3321961,0.30424 -0.2136396,2.62033 0.1254114,5.71939 0.292541,8.65148 0.1668604,2.92743 0.1507314,5.68488 -0.6696003,7.56128 -0.1835656,0.33319 -0.2886436,0.71879 -0.2886398,1.12467 0,1.28282 1.0464722,2.3293 2.3292937,2.3293 H 17.445954 c 1.282825,0 2.329267,-1.04648 2.329294,-2.3293 2.6e-5,-0.80238 -0.574802,-1.47794 -1.333349,-1.6324 -0.01527,-2.9761 -0.248984,-6.8155 -0.248984,-10.01929 -6.66e-4,-0.18389 -0.150259,-0.33226 -0.334151,-0.33155 -0.182934,6.7e-4 -0.33092,0.14863 -0.331549,0.33155 0,3.22259 0.231927,7.04773 0.248985,9.98548 H 4.7970234 c -0.9151961,0 -1.6629454,0.75101 -1.6629454,1.66621 0,0.54753 0.4497134,0.99725 0.9972474,0.99725 h 1.3359474 c -0.3032253,0.40528 -0.787885,0.66569 -1.3359474,0.66569 -0.9230548,0 -1.6635946,-0.73989 -1.6635946,-1.66294 0,-0.29721 0.077833,-0.57646 0.2210355,-0.83246 0.924918,-2.10337 0.9037293,-4.93492 0.7352599,-7.89055 z m 14.5212018,-8.91866 c 1.19882,0 2.164171,0.9634 2.164171,2.16221 0,1.19883 -0.965351,2.16418 -2.164171,2.16418 -1.198824,0 -2.162223,-0.96535 -2.162223,-2.16418 0,-1.19881 0.963399,-2.16221 2.162223,-2.16221 z m -0.0091,0.33155 c -0.179905,0.005 -0.323809,0.15313 -0.323097,0.33414 v 0.12417 c -0.367796,0.10139 -0.643598,0.44235 -0.643598,0.83927 0,0.475 0.394837,0.86724 0.869833,0.86724 h 0.213878 c 0.117712,0 0.201531,0.0838 0.201531,0.20153 0,0.11775 -0.08381,0.20152 -0.201531,0.20152 h -0.53574 c -0.183826,6.7e-4 -0.332267,0.15032 -0.331548,0.33415 6.65e-4,0.18282 0.148733,0.33084 0.331548,0.33155 h 0.09556 v 0.0956 c 6.66e-4,0.18293 0.149267,0.33092 0.332201,0.33155 0.183889,6.7e-4 0.333514,-0.14766 0.334147,-0.33155 v -0.12611 c 0.367122,-0.1009 0.640994,-0.43983 0.640994,-0.83668 0,-0.475 -0.392232,-0.86788 -0.867229,-0.86788 h -0.213878 c -0.117713,0 -0.204131,-0.0832 -0.204133,-0.20088 0,-0.11775 0.08642,-0.20413 0.204133,-0.20413 h 0.533078 c 0.18383,6.6e-4 0.333435,-0.14772 0.334151,-0.33156 6.65e-4,-0.18484 -0.149306,-0.33487 -0.334151,-0.33414 h -0.09297 v -0.0936 c 6.65e-4,-0.18486 -0.149296,-0.33489 -0.334148,-0.33416 -0.003,10e-6 -0.0063,-7e-5 -0.0091,0 z m -13.4706493,0.99985 c -0.3630388,0 -0.665698,0.30265 -0.665698,0.6657 v 1.99514 c 0,0.36304 0.3026592,0.66635 0.665698,0.66635 h 2.6634448 c 0.3630388,0 0.663748,-0.30331 0.663748,-0.66635 v -1.99514 c 0,-0.36305 -0.3007092,-0.6657 -0.663748,-0.6657 z m 4.3270431,0 c -0.1838297,-6.7e-4 -0.3334327,0.14771 -0.334151,0.33154 -6.655e-4,0.18484 0.1493061,0.33488 0.334151,0.33416 h 1.9977452 c 0.183831,-6.7e-4 0.332271,-0.15033 0.331551,-0.33416 -6.65e-4,-0.18281 -0.148736,-0.33083 -0.331551,-0.33154 z m -4.3270431,0.6657 h 2.6634448 v 1.99514 H 4.4655217 Z m 9.4693063,0.33219 c -0.176859,0.009 -0.317305,0.15507 -0.316596,0.33415 v 0.12354 c -0.36743,0.10064 -0.641647,0.4396 -0.641647,0.83668 0,0.47499 0.392882,0.86982 0.867878,0.86982 h 0.213233 c 0.117712,0 0.201531,0.0838 0.201531,0.20153 0,0.11775 -0.08381,0.20153 -0.201531,0.20153 h -0.535681 c -0.183826,6.7e-4 -0.332267,0.15032 -0.331548,0.33414 3.33e-4,0.18308 0.148481,0.33149 0.331548,0.33221 h 0.09621 v 0.0956 c 6.67e-4,0.18389 0.150258,0.33228 0.334148,0.33155 0.182934,-6.7e-4 0.330922,-0.14863 0.331551,-0.33155 v -0.12677 c 0.367229,-0.10077 0.640994,-0.43975 0.640994,-0.83667 0,-0.475 -0.392232,-0.86724 -0.867229,-0.86724 h -0.213233 c -0.117712,0 -0.20153,-0.0864 -0.20153,-0.20412 0,-0.11775 0.08382,-0.20088 0.20153,-0.20088 h 0.535033 c 0.183319,-3.4e-4 0.33184,-0.14889 0.332196,-0.33221 6.66e-4,-0.18407 -0.148115,-0.33378 -0.332196,-0.33414 h -0.09556 v -0.093 c 6.66e-4,-0.1839 -0.147658,-0.33353 -0.33155,-0.33416 -0.0058,-2e-5 -0.01183,-2.6e-4 -0.01754,0 z m -5.1422632,0.33415 c -0.1838297,-6.6e-4 -0.3334352,0.14772 -0.334151,0.33155 6.655e-4,0.18384 0.1503213,0.33227 0.334151,0.33155 H 9.458221 c 0.1828108,-6.6e-4 0.3308349,-0.14873 0.331547,-0.33155 -6.655e-4,-0.18281 -0.1487337,-0.33083 -0.331547,-0.33155 z m -4.6611499,2.66085 c -0.1838297,6.6e-4 -0.3322678,0.15032 -0.3315482,0.33414 6.655e-4,0.18282 0.1487362,0.33084 0.3315482,0.33155 h 0.665698 c 0.1838297,6.7e-4 0.3334327,-0.14771 0.334151,-0.33155 6.655e-4,-0.18484 -0.149306,-0.33487 -0.334151,-0.33414 z m 1.9977481,0 c -0.1838297,6.6e-4 -0.3322703,0.15032 -0.3315507,0.33414 6.655e-4,0.18282 0.1487362,0.33084 0.3315507,0.33155 h 1.6635945 c 0.1838298,6.7e-4 0.3334328,-0.14771 0.3341511,-0.33155 6.655e-4,-0.18484 -0.1493061,-0.33487 -0.3341511,-0.33414 z m -1.9977481,1.3314 c -0.1838297,6.6e-4 -0.3322678,0.15032 -0.3315482,0.33415 3.321e-4,0.18307 0.1484808,0.33149 0.3315482,0.33219 h 6.9904891 c 0.184083,6.7e-4 0.333792,-0.14812 0.334149,-0.33219 6.65e-4,-0.18485 -0.149304,-0.33488 -0.334149,-0.33415 z m 0.6461963,1.33204 c -0.352191,0 -0.6461963,0.294 -0.6461963,0.64619 v 4.6976 c 0,0.3522 0.2940053,0.64621 0.6461963,0.64621 H 16.134104 c 0.352192,0 0.646197,-0.29401 0.646197,-0.64621 v -4.6976 c 0,-0.35219 -0.294005,-0.64619 -0.646197,-0.64619 z m 0.019499,0.66571 h 5.3268918 v 0.66569 H 4.7970674 Z m 5.9932388,0 h 2.329299 v 0.66569 h -2.329298 z m 2.994997,0 H 16.1146 v 0.66569 h -2.329297 z m -8.9882358,1.33204 h 5.3268918 v 3.32654 H 4.7970674 Z m 5.9932388,0 h 2.329299 v 3.32654 h -2.329298 z m 2.994997,0 H 16.1146 v 3.32654 h -2.329297 z m -7.9877377,0.66569 c -0.1838259,-6.6e-4 -0.3334276,0.14773 -0.3341472,0.33155 -6.655e-4,0.18486 0.1493035,0.33487 0.3341472,0.33416 h 2.9949955 c 0.1838298,-6.7e-4 0.3322678,-0.15032 0.3315482,-0.33416 -6.655e-4,-0.18281 -0.1487362,-0.33083 -0.3315482,-0.33155 z m 5.9899927,0 c -0.182814,6.7e-4 -0.33084,0.14874 -0.331552,0.33155 -6.65e-4,0.18384 0.147722,0.33344 0.331552,0.33416 h 0.334147 c 0.18383,-6.7e-4 0.332271,-0.15032 0.331551,-0.33416 -6.65e-4,-0.18281 -0.148736,-0.33083 -0.331551,-0.33155 z m 2.994992,0 c -0.182811,6.7e-4 -0.330837,0.14874 -0.331549,0.33155 -6.65e-4,0.18384 0.147719,0.33344 0.331549,0.33416 h 0.334151 c 0.184082,-3.4e-4 0.332919,-0.15007 0.332199,-0.33416 -6.65e-4,-0.18306 -0.149132,-0.33118 -0.332199,-0.33155 z m -8.9849847,1.33141 c -0.1840813,-6.7e-4 -0.3337912,0.14812 -0.3341472,0.33219 -6.655e-4,0.18484 0.149306,0.33487 0.3341472,0.33416 h 1.3313985 c 0.1838285,-6.7e-4 0.3322703,-0.15033 0.3315507,-0.33416 -3.321e-4,-0.18306 -0.1484833,-0.33149 -0.3315507,-0.33219 z m -1.3320463,2.66149 c -0.184845,-6.7e-4 -0.3348769,0.1493 -0.334151,0.33416 6.654e-4,0.18382 0.1503212,0.33226 0.334151,0.33154 h 0.3315482 c 0.1838297,6.6e-4 0.3334314,-0.14772 0.334151,-0.33154 6.655e-4,-0.18486 -0.1493061,-0.33489 -0.334151,-0.33416 z m 1.6635983,0 c -0.1838297,6.7e-4 -0.3322703,0.15032 -0.331552,0.33416 6.668e-4,0.18281 0.1487375,0.33083 0.331552,0.33154 h 2.3292938 c 0.1838284,6.6e-4 0.3334314,-0.14772 0.3341497,-0.33154 6.668e-4,-0.18486 -0.149306,-0.33489 -0.3341497,-0.33416 z m 8.3218837,0 c -0.184843,-6.7e-4 -0.334875,0.1493 -0.334151,0.33416 6.67e-4,0.18382 0.150323,0.33226 0.334151,0.33154 H 16.1146 c 0.183826,6.6e-4 0.333429,-0.14772 0.334147,-0.33154 6.65e-4,-0.18486 -0.149302,-0.33489 -0.334147,-0.33416 z m 3.661334,1.99709 c 0.555423,0 0.997266,0.44508 0.997248,1.00049 -2.1e-5,0.92306 -0.740541,1.66296 -1.663596,1.66296 H 5.7604428 c 0.4329944,-0.42331 0.7027553,-1.0126 0.7027553,-1.66296 0,-0.37442 -0.1255875,-0.72128 -0.3367501,-1.00049 z m -12.3147697,1.00049 c 0,0.11385 -0.011574,0.22436 -0.033149,0.33157 h -1.633101 c -0.1877736,0 -0.3315482,-0.1438 -0.3315482,-0.33157 0,-0.55542 0.494661,-1.00049 0.9972475,-1.00049 0.5554179,0 1.0004943,0.44507 1.0004943,1.00049 z"
       sodipodi:nodetypes="sscsscccsscssssccccccscsssscccccssscsscsssssssccssssscsccccccssssscscccsssssssssssscsccscccccccsccsssssccccccccssssscccccsssccccccccsccscccsccscccccccccssssssscscccccccccccccccccccccccccccccccsccscccsccscccsccsccccccccccsccscccsccscccsccscccsscsccscsscs" />
  </g>
</svg> <h2  class="title">Agregar Factura de Compras</h2></div>
                                
                                <div class="box-tools">
                                    <a href="factura_compra_index.php" class="btn btn-primary btn-md" data-title="Volver">
                                        <i class="fa fa-arrow-left"></i>
                                    </a>
                                </div>
                            </div>

                            <form action="factura_compra_control.php" method="post" class="form-horizontal">
    <input type="hidden" name="accion" value="1">
    <div class="box-body">

    <div class="container">
    <!-- Fila 1 - Orden de Compra, Buscar Presupuesto y N° Factura Proveedor -->
    <div class="row">
        <div class="col-lg-4">
            <label for="orden" class="control-label">Orden de Compra:</label>
            <select class="form-control select2" name="vorden_id" id="orden" onchange="cargarorden(this.value)" required>
                <option value="">Seleccione una orden</option>
                <?php 
                $orden = consultas::get_datos("SELECT * FROM v_orden_compras_cabecera WHERE estado ='FINALIZADO' ORDER BY orden_id DESC");
                foreach ($orden as $ord) { ?>
                    <option value="<?php echo $ord['orden_id']; ?>">
                        <?php echo "N°: " . $ord['orden_id'] . " - Fecha: " . $ord['fecha_orden']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="col-lg-4">
            <label for="buscar_orden" class="control-label">Buscar Orden (ID):</label>
            <div class="input-group">
                <input type="text" id="buscar_orden" class="form-control" placeholder="Ingrese ID" autocomplete="off">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary" onclick="buscarorden()">Buscar</button>
                </span>
            </div>
        </div>

        <div class="col-lg-4">
            <label for="vid_factu_proveedor" class="control-label">N° Factura Proveedor:</label>
            <input type="text" id="id_factu_proveedor" name="vid_factu_proveedor" class="form-control" autocomplete="off">
        </div>
    </div>

    <!-- Fila 2 - Proveedor, Sucursal y Usuario -->
    <div class="row mt-3">
        <div class="col-lg-4">
            <label for="prv_nombre" class="control-label">Proveedor seleccionado:</label>
            <input type="text" id="prv_nombre" name="prv_nombre" class="form-control" readonly>
            <input type="hidden" id="prv_cod" name="vprv_cod">
        </div>

        <div class="col-lg-4">
            <label for="sucursal" class="control-label">Sucursal:</label>
            <input type="text" id="sucursal" name="vid_sucursal_visible" class="form-control" value="<?php echo $_SESSION['sucursal']; ?>" disabled>
            <input type="hidden" name="vid_sucursal" value="<?php echo $_SESSION['id_sucursal']; ?>">
        </div>

        <div class="col-lg-4">
            <label for="vusuario" class="control-label">Usuario:</label>
            <input type="text" name="vusuario" class="form-control" value="<?php echo $_SESSION['usu_nick']; ?>" disabled>
            <input type="hidden" name="vusu_cod" value="<?php echo $_SESSION['usu_cod']; ?>">
        </div>
    </div>

    <!-- Fila 3 - Fecha emisión, Monto total, N° Timbrado -->
    <div class="row mt-3">
        <div class="col-lg-4">
            <label for="fecha" class="control-label">Fecha emisión:</label>
            <?php
            date_default_timezone_set('America/Asuncion');
            $fecha = consultas::get_datos("SELECT CURRENT_TIMESTAMP AS fecha_emision");
            $fecha_formateada = date('Y-m-d\TH:i', strtotime($fecha[0]['fecha_emision']));
            ?>
            <input type="datetime-local" name="fecha_factura_visible" class="form-control" value="<?php echo $fecha_formateada; ?>" disabled>
            <input type="hidden" name="vfecha_emision" value="<?php echo $fecha[0]['fecha_emision']; ?>">
        </div>

        <div class="col-lg-4">
            <label for="monto_total" class="control-label">Monto total:</label>
            <input type="text" id="total" name="vmonto_total" class="form-control" readonly>
        </div>

        <div class="col-lg-4">
            <label for="vtimbrado" class="control-label">N° Timbrado:</label>
            <input type="text" id="timbrado" name="vtimbrado" class="form-control" autocomplete="off">
        </div>
    </div>

    <!-- Fila 4 - Método de Pago, Condición, Cuotas, Fecha Vencimiento y Periodicidad -->
    <div class="row mt-3">
        <div class="col-lg-3">
            <label for="id" class="control-label">Método de Pago:</label>
            <select class="form-control select2" name="vid_metodo_pago" id="id" required>
                <option value="">Seleccione un Método de Pago</option>
                <?php 
                $metodo = consultas::get_datos("SELECT * FROM metodo_pago WHERE activo ='t'");
                foreach ($metodo as $meto) { ?>
                    <option value="<?php echo $meto['id']; ?>">
                        <?php echo $meto['nombre']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="col-lg-3">
            <label for="condicion" class="control-label">Condición:</label>
            <select class="form-control select2" name="vcondicion" required id="condicion" onchange="tipocompra()">
                <option value="CONTADO">CONTADO</option>
                <option value="CREDITO">CREDITO</option>
            </select>
        </div>

        <div class="col-lg-2 tipo" style="display: none;">
            <label for="cuotas" class="control-label">Cant. Cuotas:</label>
            <input type="number" name="vfact_cuota" id="cuotas" class="form-control" min="1" value="1">
        </div>

        <div class="col-lg-2 tipo" style="display: none;">
            <label for="plazo" class="control-label">Fecha de Vencimiento:</label>
            <input type="date" name="vplazo" id="plazo" class="form-control">
        </div>

        <div class="col-lg-2 tipo" style="display: none;">
            <label for="periodicidad" class="control-label">Periodicidad:</label>
            <select name="vperiodicidad" id="periodicidad" class="form-control">
                <option value="">Sin periodicidad</option>
                <option value="semanal">Semanal</option>
                <option value="quincenal">Quincenal</option>
                <option value="mensual">Mensual</option>
                <option value="anual">Anual</option>
            </select>
        </div>
    </div>
    <div class="row mt-3 mt-0">
        <div class="col-lg-3 mt-0"> <!-- Cambié mt-3 a mt-1 -->
        <label for="dep_cod" class="control-label">Deposito:</label>
        <select class="form-control select2" name="vdep_cod" id="vdep_cod" required>
            <option value="">Seleccione un Deposito</option>
            <?php 
            $id_sucursal = (int)$_SESSION['id_sucursal'];
            $deposito = consultas::get_datos("SELECT * FROM deposito WHERE id_sucursal = $id_sucursal");
            foreach ($deposito as $dep) { ?>
                <option value="<?php echo $dep['dep_cod']; ?>">
                    <?php echo htmlspecialchars($dep['dep_descri']); ?>
                </option>
            <?php } ?>
        </select>
    </div>
</div>


</div>




    <!-- Fila 5 - Detalle de la orden -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <h4>Detalle de la orden:</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Material</th>
                        <th>Cantidad</th>
                        <th>Costo Unitario</th>
                        <th>Subtotal</th>
                        <th>Iva 5%</th>
                        <th>Iva 10%</th>
                    </tr>
                </thead>
                <tbody id="detalle_orden">
                    <tr>
                        <td colspan="5">Seleccione un presupuesto para cargar el detalle.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


    <div class="box-footer">
        <button type="submit" class="btn btn-primary pull-right">
            <i class="fa fa-floppy-o"></i> Registrar
        </button>
    </div>
</form>


                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php require 'menu/footer_lte.ctp'; ?>

    <script>
        $(document).ready(function() {
            $('#orden').select2({ width: 'resolve', placeholder: 'Seleccione una orden' });
        });

        function cargarorden(orden_id) {
            if (orden_id) {
                $.ajax({
                    url: "get_orden_factura_compra.php",
                    type: "POST",
                    dataType: "json",
                    data: { orden_id: orden_id },
                    success: function(response) {
                        $("#prv_nombre").val(response.razon_social);
                        $("#prv_cod").val(response.prv_cod);
                        $("#total").val(response.total);
                        $("#detalle_orden").html(response.detalles);
                    },
                    error: function() {
                        console.error("Error al cargar los datos de la orden.");
                    }
                });
            } else {
                $("#detalle_orden").html('<tr><td colspan="3">Debe seleccionar una orden.</td></tr>');
                $("#prv_nombre").val('');
            }
        }

        function tipocompra() {
            if ($("#condicion").val() === "CREDITO") {
                $(".tipo").show();
            } else {
                $(".tipo").hide();
            }
        }

        function buscarorden() {
            const query = document.getElementById('buscar_orden').value.trim();
            if (query) {
                $.ajax({
                    url: 'buscar_factura_orden.php',
                    type: 'POST',
                    data: { query: query },
                    success: function(response) {
                        $('#orden').html(response);
                        const firstOption = $('#orden option:first').val();
                        if (firstOption) {
                            cargarorden(firstOption);
                        } else {
                            $('#detalle_orden').html('<tr><td colspan="3">No se encontró ninguna orden con el ID ingresado.</td></tr>');
                        }
                    },
                    error: function() {
                        alert("Error al buscar la orden. Intente nuevamente.");
                    }
                });
            } else {
                $('#orden').html('<option value="">Ingrese un ID de la orden</option>');
                $('#detalle_orden').html('<tr><td colspan="3">Ingrese un ID de la orden.</td></tr>');
            }
        }

 
    </script>
    <script> 
    document.addEventListener('DOMContentLoaded', function () {
    // Supongamos que tienes el valor en la variable `montoTotal`
    //let montoTotal = 1234567.89; // Ejemplo de valor numérico

    // Asignar el valor al campo oculto (sin formato)
    document.getElementById('total').value = montoTotal;

    // Formatear el valor como moneda
    let montoFormateado = new Intl.NumberFormat('es-PY', { style: 'decimal', minimumFractionDigits: 2 }).format(montoTotal);

    // Mostrar el valor formateado en el campo visible
    document.getElementById('total_mostrado').value = montoFormateado;
});
     </script>

    <?php require 'menu/js_lte.ctp'; ?>
</body>
</html>
