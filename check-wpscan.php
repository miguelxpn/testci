<?php

function getPluginsAndThemes($wpContentPath) {
    $pluginsPath = $wpContentPath . '/plugins';
    $themesPath = $wpContentPath . '/themes';
    
    $plugins = [];
    $themes = [];
    
    // Get plugin directories
    if (is_dir($pluginsPath)) {
        $pluginDirs = scandir($pluginsPath);
        
        foreach ($pluginDirs as $dir) {
            if ($dir !== '.' && $dir !== '..' && is_dir($pluginsPath . '/' . $dir)) {
                $plugin = [
                    'name' => $dir,
                    'version' => getPluginVersion($pluginsPath . '/' . $dir)
                ];
                
                $plugins[] = $plugin;
            }
        }
    }
    
    // Get theme directories
    if (is_dir($themesPath)) {
        $themeDirs = scandir($themesPath);
        
        foreach ($themeDirs as $dir) {
            if ($dir !== '.' && $dir !== '..' && is_dir($themesPath . '/' . $dir)) {
                $theme = [
                    'name' => $dir,
                    'version' => getThemeVersion($themesPath . '/' . $dir)
                ];
                
                $themes[] = $theme;
            }
        }
    }
    
    return [
        'plugins' => $plugins,
        'themes' => $themes
    ];
}

function getPluginVersion($pluginPath) {
    $pluginFile = $pluginPath . '/' . basename($pluginPath) . '.php';
    
    if (file_exists($pluginFile)) {
        $pluginData = getPluginData($pluginFile);
        
        return $pluginData['Version'];
    }
    
    return 'Unknown';
}

function getThemeVersion($themePath) {
    $themeFile = $themePath . '/style.css';
    
    if (file_exists($themeFile)) {
        $themeData = getThemeData($themeFile);
        
        return $themeData['Version'];
    }
    
    return 'Unknown';
}

function getPluginData($pluginFile) {
    $defaultHeaders = [
        'Name' => 'Plugin Name',
        'Version' => 'Version',
        'Description' => 'Description',
        'Author' => 'Author',
        'AuthorURI' => 'Author URI',
        'PluginURI' => 'Plugin URI'
    ];
    
    $pluginData = getHeaderData($pluginFile, $defaultHeaders);
    
    return $pluginData;
}

function getThemeData($themeFile) {
    $defaultHeaders = [
        'Theme Name' => 'Theme Name',
        'Theme URI' => 'Theme URI',
        'Description' => 'Description',
        'Author' => 'Author',
        'Author URI' => 'Author URI',
        'Version' => 'Version'
    ];
    
    $themeData = getHeaderData($themeFile, $defaultHeaders);
    
    return $themeData;
}

function getHeaderData($file, $defaultHeaders) {
    $fileData = file_get_contents($file);
    
    $headers = [];
    
    foreach ($defaultHeaders as $headerKey => $headerName) {
        $regex = '/^' . $headerName . ':\s*(.+)/m';
        
        if (preg_match($regex, $fileData, $matches)) {
            $headers[$headerKey] = $matches[1];
        } else {
            $headers[$headerKey] = 'Unknown';
        }
    }
    
    return $headers;
}


$wpscan_token = $_ENV['WPSCAN_TOKEN'];
$wp_content_path = $_ENV['WP_CONTENT_PATH'];

echo $wpscan_token;

$result = getPluginsAndThemes($wp_content_path);
var_dump($result);

exit(1);