<?php

$radioHomeDir = '/home/pi/radio/';
$activeStationFile = $radioHomeDir . 'active.txt'; 
$radioListFile = $radioHomeDir . 'radio.list';

$content = file_get_contents("radio.tpl");



if (array_key_exists('action', $_POST) && array_key_exists('stations', $_POST) && $_POST['action'] === 'save') {
    file_put_contents($activeStationFile, $_POST['stations']);
    echo exec($radioHomeDir . "kill_mplayer.py");
    exec("python2 " . $radioHomeDir . "keep_mplayer_alive.py");
}

$activeStation = file_get_contents($activeStationFile);
if (!$activeStation) {
    $activeStation = 1;
}

$radioList = file_get_contents($radioListFile);

$stations = explode("\n", $radioList);

$buttons = [];
foreach ($stations as $station) {
    $elements = explode('__', $station);
    if (count($elements) < 3) {
        continue;
    }
    $checked = ((int)$activeStation === (int)trim($elements[0])) ? ' checked="checked"' : '';
    
    $buttons[] = '<input 
                    class="list-group-item-check pe-none" 
                    type="radio" 
                    name="stations" 
                    onclick="this.form.submit();"
                    id="station_' . trim($elements[0]) . '" 
                    value="' . trim($elements[0]) . '"' . $checked . '>
                  <label class="list-group-item rounded-3 py-3" for="station_' . trim($elements[0]) . '">' . trim($elements[1]) . '</label>
                 ';
}

$content = str_replace('***radio-stations***', implode($buttons), $content);


echo $content;
