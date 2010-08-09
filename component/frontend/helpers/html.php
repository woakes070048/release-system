<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class ArsHelperHtml
{
	/**
	 * Processes the message, replacing placeholders with their values and running any
	 * plug-ins
	 * @param string $message The message to process
	 * @return string The processed message
	 */
	static public function preProcessMessage($message)
	{
		// Parse [SITE]
		$site_url = JURI::base();
		$message = str_replace('[SITE]', $site_url, $message);

		// Run content plug-ins
		$app = JFactory::getApplication();
		$params =& $app->getParams('com_content');
		$article = new JObject();
		$article->text = $message;
		$limitstart = 0;
		JPluginHelper::importPlugin('content');
		$dispatcher	=& JDispatcher::getInstance();
		$results = $dispatcher->trigger('onPrepareContent', array (& $article, & $params, $limitstart));
		$message = $article->text;

		// Return the value
		return $message;
	}
}