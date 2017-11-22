<?php
/**
 * author     : Allen <hi@summic.com>
 * createTime : 16/12/24 上午10:44
 * description: 
 */
namespace kuainiu\components;

use yii\composer\Installer;
class AdminLTEInstaller extends Installer
{
    public static function initProject($event)
    {
        foreach (['formatAdminLTE'] as $method) {
            call_user_func_array([__CLASS__, $method], [$event]);
        }
    }
    /**
     * 替换 AmdinLTE 的 google font api
     * [@link] http://www.cmsky.com/google-fonts-ssl-ustc/
     * @param $event
     */
    public static function formatAdminLTE($event)
    {
        $composer = $event->getComposer();
        $extra = $composer->getPackage()->getExtra();
        if (isset($extra['asset-installer-paths']['bower-asset-library'])) {
            $bowerAssetDir = $extra['asset-installer-paths']['bower-asset-library'];
            $cssFile[] = rtrim($bowerAssetDir, '/') . '/../almasaeed2010/adminlte/dist/css/AdminLTE.css';
            $cssFile[] = rtrim($bowerAssetDir, '/') . '/../almasaeed2010/adminlte/dist/css/AdminLTE.min.css';
            foreach ($cssFile as $css) {
                self::replaceUrl($css);
            }
        } else {
            echo "'npm-asset-library' is not set.\n";
        }
    }
    /**
	 * 用 fonts.css.network 替换 fonts.googleapis.com 的资源
     * @param $cssFile
     */
    public static function replaceUrl($cssFile)
    {
        if (file_exists($cssFile)) {
            $content = file_get_contents($cssFile);
            if ($content = str_replace('fonts.googleapis.com', 'fonts.css.network', $content)) {
                file_put_contents($cssFile, $content);
                echo "'{$cssFile}' google api replace success.\n";
            }
        } else {
            echo "'{$cssFile}' file is not exists.\n";
        }
    }
}
